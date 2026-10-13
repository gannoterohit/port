@component('mail::message')
# New Contact Enquiry

You have received a new message from your website contact form.

**Name:** {{ $enquiry->name }}
**Email:** {{ $enquiry->email }}
@if($enquiry->phone)
**Phone:** {{ $enquiry->phone }}
@endif
**Subject:** {{ $enquiry->subject ?: 'Website Contact Form Submission' }}

**Message:**
{{ $enquiry->message }}

@component('mail::panel')
This enquiry was submitted on {{ $enquiry->created_at->toFormattedDateString() }}
from IP address: {{ $enquiry->ip_address ?: 'N/A' }}
@endcomponent

Thanks,<br>
{{ $websiteName }}
@endcomponent
