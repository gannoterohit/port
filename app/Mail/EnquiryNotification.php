<?php

namespace App\Mail;

use App\Models\Enquiry;
use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EnquiryNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Enquiry $enquiry,
    ) {}

    public function build(): static
    {
        $fromName = Setting::get('mail_from_name') ?: Setting::get('website_name', config('app.name'));

        return $this->from(
            Setting::get('mail_from_address', 'hello@example.com'),
            $fromName
        )->subject('New Contact Enquiry: '.($this->enquiry->subject ?: 'Website Contact Form'))
            ->markdown('mail.enquiry-notification')
            ->with([
                'enquiry' => $this->enquiry,
                'websiteName' => Setting::get('website_name', config('app.name')),
            ]);
    }
}
