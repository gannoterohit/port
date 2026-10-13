<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Mail\EnquiryConfirmation;
use App\Mail\EnquiryNotification;
use App\Models\Enquiry;
use App\Models\EnquiryStatusLog;
use App\Models\Profile;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function show()
    {
        $profile = Cache::remember('profile', 3600, fn () => Profile::getInstance());
        $services = Cache::remember('contact_services', 3600, fn () => \App\Models\Service::where('is_enabled', true)->orderBy('display_order')->get());

        return view('public.contact', compact('profile', 'services'));
    }

    public function submit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'service_type' => ['nullable', 'string', 'max:255'],
            'timeline' => ['nullable', 'string', 'max:100'],
            'subject' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string', 'min:10'],
        ]);

        if ($request->filled('website_hp')) {
            return back()->with('success', 'Your message has been sent successfully. I will get back to you soon.');
        }

        $executed = RateLimiter::attempt(
            'contact-form:'.$request->ip(),
            $perMinute = 5,
            fn () => true
        );

        if (! $executed) {
            return back()->with('error', 'You are submitting too frequently. Please wait a few minutes and try again.');
        }

        $data = $validator->validate();

        $metadata = [];
        if (!empty($data['service_type'])) {
            $metadata[] = "Service: " . $data['service_type'];
        }
        if (!empty($data['timeline'])) {
            $metadata[] = "Expected Timeline: " . $data['timeline'];
        }

        $formattedMessage = !empty($metadata)
            ? implode(" | ", $metadata) . "\n\n" . $data['message']
            : $data['message'];

        $subject = !empty($data['subject'])
            ? $data['subject']
            : (!empty($data['service_type']) ? "Project Enquiry: " . $data['service_type'] : 'Website Contact Form Submission');

        $enquiry = Enquiry::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'subject' => $subject,
            'message' => $formattedMessage,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'new',
        ]);

        EnquiryStatusLog::create([
            'enquiry_id' => $enquiry->id,
            'status' => 'new',
            'note' => 'Enquiry submitted from contact form',
        ]);

        $this->configureMailFromSettings();

        if (Setting::get('notify_admin_on_enquiry', '1') === '1' || Setting::get('notify_admin_on_enquiry', true) === true) {
            $adminEmail = Setting::get('contact_email', config('mail.from.address'));
            if ($adminEmail) {
                try {
                    Mail::to($adminEmail)->send(new EnquiryNotification($enquiry));
                } catch (\Exception $e) {
                    Log::warning('Failed to send enquiry notification email: '.$e->getMessage());
                }
            }
        }

        if (Setting::get('send_enquiry_confirmation', '1') === '1' || Setting::get('send_enquiry_confirmation', true) === true) {
            try {
                Mail::to($enquiry->email)->send(new EnquiryConfirmation($enquiry));
            } catch (\Exception $e) {
                Log::warning('Failed to send enquiry confirmation email: '.$e->getMessage());
            }
        }

        return back()->with('success', 'Your message has been sent successfully. I will get back to you soon.');
    }

    protected function configureMailFromSettings(): void
    {
        $settings = [
            'mail_mailer' => Setting::get('mail_mailer'),
            'mail_host' => Setting::get('mail_host'),
            'mail_port' => Setting::get('mail_port'),
            'mail_username' => Setting::get('mail_username'),
            'mail_password' => Setting::get('mail_password'),
            'mail_encryption' => Setting::get('mail_encryption'),
            'mail_from_address' => Setting::get('mail_from_address'),
            'mail_from_name' => Setting::get('mail_from_name'),
        ];

        foreach ($settings as $key => $value) {
            if ($value !== null && $value !== '') {
                if ($key === 'mail_from_address') {
                    config()->set('mail.from.address', $value);
                } elseif ($key === 'mail_from_name') {
                    config()->set('mail.from.name', $value);
                } elseif ($key === 'mail_mailer') {
                    config()->set('mail.default', $value);
                } elseif (str_starts_with($key, 'mail_')) {
                    $configKey = str_replace('mail_', 'mail.', $key);
                    config()->set($configKey, $value);
                }
            }
        }

        $fromName = config('mail.from.name');
        if (! $fromName || $fromName === config('app.name')) {
            $fromName = Setting::get('mail_from_name') ?: Setting::get('website_name', config('app.name'));
            config()->set('mail.from.name', $fromName);
        }
    }
}
