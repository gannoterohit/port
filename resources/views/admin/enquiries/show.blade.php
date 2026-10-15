@extends('admin.layouts.master')

@section('title', 'Enquiry Details')
@section('header', 'Enquiry #' . $enquiry->id)

@section('admin-content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <a href="{{ route('admin.enquiries.index') }}" class="text-sm font-medium text-emerald-700 hover:text-emerald-800 flex items-center gap-1">
                    &larr; Back to Enquiries
                </a>
            </div>
            <h2 class="text-2xl font-bold text-gray-900">Enquiry from {{ $enquiry->name }}</h2>
            <div class="flex items-center gap-2 mt-2">
                @php
                    $statusClasses = [
                        'new' => 'bg-emerald-100 text-emerald-900',
                        'in_progress' => 'bg-amber-100 text-amber-800',
                        'contacted' => 'bg-emerald-100 text-emerald-800',
                        'converted' => 'bg-purple-100 text-purple-800',
                        'closed' => 'bg-slate-100 text-slate-800',
                    ];
                @endphp
                <span class="inline-flex px-2.5 py-1 text-xs font-semibold rounded-full {{ $statusClasses[$enquiry->status] ?? 'bg-gray-100 text-gray-800' }}">
                    {{ $enquiry->status_label }}
                </span>
                @if($enquiry->isUnread())
                    <span class="inline-flex px-2 py-0.5 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-900">
                        Unread
                    </span>
                @endif
            </div>
        </div>

        <div class="flex items-center gap-2">
            <a href="mailto:{{ $enquiry->email }}?subject={{ urlencode('Re: ' . ($enquiry->subject ?: 'Your Enquiry')) }}"
                class="bg-emerald-700 hover:bg-emerald-800 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 01-2-2v12a2 2 0 002 2z"></path>
                </svg>
                Reply Email
            </a>
            <form method="POST" action="{{ route('admin.enquiries.destroy', $enquiry) }}" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Delete this enquiry? This action cannot be undone.')"
                    class="text-red-600 hover:text-red-700 px-3 py-2 border border-red-200 hover:bg-red-50 rounded-lg text-sm font-medium transition-colors">
                    Delete
                </button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm">
            <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-4">Contact Information</h3>
            <div class="space-y-4">
                <div>
                    <label class="text-xs text-gray-400 block mb-0.5">Full Name</label>
                    <p class="text-gray-900 font-semibold">{{ $enquiry->name }}</p>
                </div>
                <div>
                    <label class="text-xs text-gray-400 block mb-0.5">Email Address</label>
                    <a href="mailto:{{ $enquiry->email }}" class="text-emerald-700 hover:underline font-medium">
                        {{ $enquiry->email }}
                    </a>
                </div>
                <div>
                    <label class="text-xs text-gray-400 block mb-0.5">Phone / WhatsApp</label>
                    <p class="text-gray-900 font-medium">{{ $enquiry->phone ?? '—' }}</p>
                </div>
                <div>
                    <label class="text-xs text-gray-400 block mb-0.5">Subject</label>
                    <p class="text-gray-900 font-medium">{{ $enquiry->subject ?? '—' }}</p>
                </div>
                @if($enquiry->project_type)
                <div>
                    <label class="text-xs text-gray-400 block mb-0.5">Project / Service Type</label>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200">
                        {{ $enquiry->project_type }}
                    </span>
                </div>
                @endif
                @if($enquiry->budget_range)
                <div>
                    <label class="text-xs text-gray-400 block mb-0.5">Approx. Budget</label>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-50 text-blue-800 border border-blue-200">
                        {{ $enquiry->budget_range }}
                    </span>
                </div>
                @endif
                @if($enquiry->timeline)
                <div>
                    <label class="text-xs text-gray-400 block mb-0.5">Expected Timeline</label>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-purple-50 text-purple-800 border border-purple-200">
                        {{ $enquiry->timeline }}
                    </span>
                </div>
                @endif
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm">
            <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-4">Submission Meta</h3>
            <div class="space-y-4">
                <div>
                    <label class="text-xs text-gray-400 block mb-0.5">Submitted On</label>
                    <p class="text-gray-900 font-medium">{{ $enquiry->created_at->format('F d, Y \a\t h:i A') }}</p>
                </div>
                <div>
                    <label class="text-xs text-gray-400 block mb-0.5">IP Address</label>
                    <p class="text-gray-700 font-mono text-sm">{{ $enquiry->ip_address ?? '—' }}</p>
                </div>
                <div>
                    <label class="text-xs text-gray-400 block mb-0.5">Browser & Device</label>
                    <p class="text-xs text-gray-600 break-words font-mono bg-gray-50 p-2 rounded border border-gray-100">
                        {{ $enquiry->user_agent ?? '—' }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Message Body -->
    <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm">
        <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Submitted Message</h3>
        <div class="bg-slate-50 rounded-xl p-5 border border-slate-100">
            <p class="text-gray-900 whitespace-pre-line leading-relaxed">{{ $enquiry->message }}</p>
        </div>
    </div>

    <!-- Update Status & Notes -->
    <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm">
        <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-4">Manage Status & Staff Notes</h3>
        <form method="POST" action="{{ route('admin.enquiries.update', $enquiry) }}" class="space-y-4">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Enquiry Status</label>
                    <select name="status" class="admin-input text-sm">
                        <option value="new" {{ $enquiry->status === 'new' ? 'selected' : '' }}>New</option>
                        <option value="in_progress" {{ $enquiry->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="contacted" {{ $enquiry->status === 'contacted' ? 'selected' : '' }}>Contacted</option>
                        <option value="converted" {{ $enquiry->status === 'converted' ? 'selected' : '' }}>Converted</option>
                        <option value="closed" {{ $enquiry->status === 'closed' ? 'selected' : '' }}>Closed</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1">Internal Notes</label>
                <textarea name="internal_notes" class="admin-textarea text-sm" rows="3"
                    placeholder="Add internal notes about this client enquiry...">{{ old('internal_notes', $enquiry->internal_notes) }}</textarea>
                <p class="text-xs text-gray-400 mt-1">Internal notes are private and never visible to the client.</p>
            </div>

            <div class="flex justify-end pt-2">
                <button type="submit" class="bg-emerald-700 hover:bg-emerald-800 text-white px-5 py-2.5 rounded-lg text-sm font-medium transition-colors">
                    Save Changes
                </button>
            </div>
        </form>
    </div>

    <!-- Status History -->
    <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm">
        <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-4">Status Change History</h3>
        @if($statusLogs && $statusLogs->count() > 0)
            <div class="space-y-3">
                @foreach($statusLogs as $log)
                    <div class="border-l-2 border-emerald-500 pl-4 py-1">
                        <div class="text-sm">
                            <span class="font-semibold text-gray-900">{{ $log->user ? $log->user->name : 'System' }}</span>
                            <span class="text-gray-500">updated status to</span>
                            <span class="font-semibold text-emerald-700 uppercase text-xs px-2 py-0.5 rounded bg-emerald-50">
                                {{ str_replace('_', ' ', $log->status) }}
                            </span>
                        </div>
                        <p class="text-xs text-gray-400 mt-0.5">{{ $log->created_at->format('M d, Y \a\t h:i A') }}</p>
                        @if($log->note)
                            <p class="text-sm text-gray-600 mt-1 bg-gray-50 p-2 rounded">{{ $log->note }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 text-sm">No status changes recorded yet.</p>
        @endif
    </div>
</div>
@endsection

