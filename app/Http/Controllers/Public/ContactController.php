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
            'project_type' => ['nullable', 'string', 'max:100'],
            'budget_range' => ['nullable', 'string', 'max:100'],
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

        $projectType = $data['project_type'] ?? $data['service_type'] ?? null;
        $budgetRange = $data['budget_range'] ?? null;
        $timeline = $data['timeline'] ?? null;

        $metadata = [];
        if (!empty($projectType)) {
            $metadata[] = "Project Type: " . $projectType;
        }
        if (!empty($budgetRange)) {
            $metadata[] = "Budget: " . $budgetRange;
        }
        if (!empty($timeline)) {
            $metadata[] = "Expected Timeline: " . $timeline;
        }

        $formattedMessage = !empty($metadata)
            ? implode(" | ", $metadata) . "\n\n" . $data['message']
            : $data['message'];

        $subject = !empty($data['subject'])
            ? $data['subject']
            : (!empty($projectType) ? "Project Enquiry: " . $projectType : 'Website Contact Form Submission');

        $enquiry = Enquiry::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'subject' => $subject,
            'project_type' => $projectType,
            'budget_range' => $budgetRange,
            'timeline' => $timeline,
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
            $adminEmail = Setting::get('contact_email');
            if (empty($adminEmail) || $adminEmail === 'hello@example.com') {
                $adminEmail = Setting::get('mail_from_address') ?: config('mail.from.address');
            }

            if ($adminEmail && $adminEmail !== 'hello@example.com') {
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
        $mailer = Setting::get('mail_mailer');
        $host = Setting::get('mail_host');
        $port = Setting::get('mail_port');
        $username = Setting::get('mail_username');
        $password = Setting::get('mail_password');
        $encryption = Setting::get('mail_encryption');
        $fromAddress = Setting::get('mail_from_address');
        $fromName = Setting::get('mail_from_name') ?: Setting::get('website_name', config('app.name'));

        if (! empty($mailer)) {
            config()->set('mail.default', $mailer);
        }

        if (! empty($host)) {
            config()->set('mail.mailers.smtp.host', $host);
            config()->set('mail.host', $host);
        }

        if (! empty($port)) {
            config()->set('mail.mailers.smtp.port', (int) $port);
            config()->set('mail.port', (int) $port);
        }

        if ($username !== null && $username !== '') {
            config()->set('mail.mailers.smtp.username', $username);
            config()->set('mail.username', $username);
        }

        if ($password !== null && $password !== '') {
            config()->set('mail.mailers.smtp.password', $password);
            config()->set('mail.password', $password);
        }

        if (! empty($encryption)) {
            config()->set('mail.mailers.smtp.encryption', $encryption);
            if (strtolower($encryption) === 'ssl') {
                config()->set('mail.mailers.smtp.scheme', 'smtps');
            }
        }

        if (! empty($fromAddress)) {
            config()->set('mail.from.address', $fromAddress);
        }

        if (! empty($fromName)) {
            config()->set('mail.from.name', $fromName);
        }

        try {
            Mail::purge('smtp');
        } catch (\Throwable) {
            // Ignored if mailer instance not yet resolved
        }
    }
}
