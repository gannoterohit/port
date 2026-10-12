<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function show()
    {
        $profile = Cache::remember('profile', 3600, fn () => \App\Models\Profile::getInstance());
        return view('public.contact', compact('profile'));
    }

    public function submit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'subject' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string', 'min:10'],
        ]);

        $executed = RateLimiter::attempt(
            'contact-form:' . $request->ip(),
            $perMinute = 5,
            fn() => true
        );

        if (!$executed) {
            return back()->with('error', 'You are submitting too frequently. Please wait a few minutes and try again.');
        }

        $data = $validator->validate();

        $enquiry = Enquiry::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'subject' => $data['subject'] ?? 'Website Contact Form Submission',
            'message' => $data['message'],
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'new',
        ]);

        \App\Models\EnquiryStatusLog::create([
            'enquiry_id' => $enquiry->id,
            'status' => 'new',
            'note' => 'Enquiry submitted from contact form',
        ]);

        return back()->with('success', 'Your message has been sent successfully. I will get back to you soon.');
    }
}
