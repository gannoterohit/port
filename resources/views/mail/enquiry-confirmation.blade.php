@component('mail::message')
# Thank You for Your Message

Hello {{ $enquiry->name }},

Thank you for reaching out. I have received your message and will get back to you as soon as possible.

**Your message:**
> {{ $enquiry->message }}

Best regards,<br>
{{ $websiteName }}
@endcomponent

