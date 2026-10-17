@extends('admin.layouts.master')

@section('title', 'Enquiry #' . $enquiry->id . ' - ' . $enquiry->name)
@section('header', 'Enquiry Details')

@section('admin-content')
<div class="space-y-6">

    <!-- Top Banner -->
    <div class="flex flex-col gap-4 rounded-2xl border border-[#E5E1D5] bg-gradient-to-br from-white to-[#FAF9F5] p-5 shadow-xs sm:flex-row sm:items-center sm:justify-between sm:p-6">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <a href="{{ route('admin.enquiries.index') }}" class="text-xs font-semibold text-[#B85D19] hover:underline flex items-center gap-1">
                    &larr; Back to Enquiries
                </a>
            </div>
            <h2 class="text-xl font-bold tracking-tight text-stone-900 sm:text-2xl">Message from {{ $enquiry->name }}</h2>
            <div class="flex items-center gap-2 mt-2">
                @php
                    $statusPills = [
                        'new' => 'bg-emerald-50 text-emerald-800 border-emerald-200',
                        'in_progress' => 'bg-amber-50 text-amber-800 border-amber-200',
                        'contacted' => 'bg-blue-50 text-blue-800 border-blue-200',
                        'converted' => 'bg-purple-50 text-purple-800 border-purple-200',
                        'closed' => 'bg-stone-100 text-stone-700 border-stone-200',
                    ];
                @endphp
                <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-bold border {{ $statusPills[$enquiry->status] ?? 'bg-stone-100 text-stone-700' }}">
                    {{ $enquiry->status_label }}
                </span>
                @if($enquiry->isUnread())
                    <span class="inline-flex px-2 py-0.5 text-xs font-bold rounded-full bg-[#B85D19]/10 text-[#B85D19] border border-[#B85D19]/20">
                        Unread
                    </span>
                @endif
            </div>
        </div>

        <div class="flex items-center gap-2.5">
            <a href="mailto:{{ $enquiry->email }}?subject={{ urlencode('Re: ' . ($enquiry->subject ?: 'Your Portfolio Inquiry')) }}" class="admin-btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 01-2-2v12a2 2 0 002 2z"></path>
                </svg>
                <span>Reply Email</span>
            </a>
            <form method="POST" action="{{ route('admin.enquiries.destroy', $enquiry) }}" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Delete this enquiry?')" class="admin-btn-secondary text-rose-600 hover:bg-rose-50 hover:text-rose-700">
                    Delete
                </button>
            </form>
        </div>
    </div>

    <!-- Contact & Meta Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="admin-form-card space-y-4">
            <div class="admin-form-header">
                <h3 class="text-xs font-bold uppercase tracking-wider text-stone-400">Sender Details</h3>
            </div>
            <div class="space-y-3">
                <div>
                    <span class="text-[11px] font-semibold uppercase tracking-wider text-stone-400 block">Full Name</span>
                    <p class="text-sm font-bold text-stone-900 mt-0.5">{{ $enquiry->name }}</p>
                </div>
                <div>
                    <span class="text-[11px] font-semibold uppercase tracking-wider text-stone-400 block">Email Address</span>
                    <a href="mailto:{{ $enquiry->email }}" class="text-sm font-medium text-[#B85D19] hover:underline mt-0.5 block">
                        {{ $enquiry->email }}
                    </a>
                </div>
                <div>
                    <span class="text-[11px] font-semibold uppercase tracking-wider text-stone-400 block">Phone / WhatsApp</span>
                    <p class="text-sm font-medium text-stone-800 mt-0.5">{{ $enquiry->phone ?? '—' }}</p>
                </div>
                <div>
                    <span class="text-[11px] font-semibold uppercase tracking-wider text-stone-400 block">Subject</span>
                    <p class="text-sm font-medium text-stone-800 mt-0.5">{{ $enquiry->subject ?? 'General Inquiry' }}</p>
                </div>
            </div>
        </div>

        <div class="admin-form-card space-y-4">
            <div class="admin-form-header">
                <h3 class="text-xs font-bold uppercase tracking-wider text-stone-400">Submission Technical Details</h3>
            </div>
            <div class="space-y-3">
                <div>
                    <span class="text-[11px] font-semibold uppercase tracking-wider text-stone-400 block">Submitted At</span>
                    <p class="text-sm font-medium text-stone-900 mt-0.5">{{ $enquiry->created_at->format('F d, Y \a\t h:i A') }}</p>
                </div>
                <div>
                    <span class="text-[11px] font-semibold uppercase tracking-wider text-stone-400 block">IP Address</span>
                    <p class="text-xs font-mono text-stone-600 mt-0.5">{{ $enquiry->ip_address ?? '—' }}</p>
                </div>
                <div>
                    <span class="text-[11px] font-semibold uppercase tracking-wider text-stone-400 block">Browser Agent</span>
                    <p class="text-[11px] font-mono text-stone-500 bg-[#FAF9F5] p-2.5 rounded-xl border border-[#E5E1D5] break-all mt-0.5">
                        {{ $enquiry->user_agent ?? '—' }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Message Body -->
    <div class="admin-form-card space-y-3">
        <div class="admin-form-header">
            <h3 class="text-xs font-bold uppercase tracking-wider text-stone-400">Message Content</h3>
        </div>
        <div class="rounded-xl border border-[#E5E1D5] bg-[#FAF9F5] p-5">
            <p class="text-sm text-stone-900 whitespace-pre-line leading-relaxed font-normal">{{ $enquiry->message }}</p>
        </div>
    </div>

    <!-- Update Status & Staff Notes -->
    <div class="admin-form-card space-y-5">
        <div class="admin-form-header">
            <h3 class="text-base font-bold text-stone-900">Manage Status &amp; Private Internal Notes</h3>
            <p class="text-xs text-stone-500">Keep track of client responses, call notes, or follow-up milestones.</p>
        </div>

        <form method="POST" action="{{ route('admin.enquiries.update', $enquiry) }}" class="space-y-4">
            @csrf
            @method('PUT')

            <div class="max-w-xs">
                <label class="block text-xs font-semibold uppercase tracking-wider text-stone-600 mb-1.5">Update Status</label>
                <select name="status" class="admin-input font-medium">
                    <option value="new" {{ $enquiry->status === 'new' ? 'selected' : '' }}>New</option>
                    <option value="in_progress" {{ $enquiry->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="contacted" {{ $enquiry->status === 'contacted' ? 'selected' : '' }}>Contacted</option>
                    <option value="converted" {{ $enquiry->status === 'converted' ? 'selected' : '' }}>Converted Lead</option>
                    <option value="closed" {{ $enquiry->status === 'closed' ? 'selected' : '' }}>Closed</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-stone-600 mb-1.5">Private Staff Notes</label>
                <textarea name="internal_notes" rows="3" class="admin-textarea" placeholder="Add private notes about this client discussion (never visible to client)...">{{ old('internal_notes', $enquiry->internal_notes) }}</textarea>
            </div>

            <div class="flex justify-end pt-2">
                <button type="submit" class="admin-btn-primary">
                    Save Changes
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
