@extends('admin.layouts.master')

@section('title', 'Enquiry Details')
@section('header', 'Enquiry #' . $enquiry->id)

@section('admin-content')
<div class="space-y-6">
    <div class="flex justify-between items-start">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Enquiry from {{ $enquiry->name }}</h2>
            <div class="flex gap-2 mt-2">
                <span class="inline-flex px-2 py-1 text-xs rounded-full bg-{{ $enquiry->status_color }}-100 text-{{ $enquiry->status_color }}-800">
                    {{ $enquiry->status_label }}
                </span>
                @if($enquiry->isUnread())
                    <span class="inline-flex px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">
                        New
                    </span>
                @endif
            </div>
        </div>

        <div class="flex gap-2">
            <a href="{{ route('admin.enquiries.export') }}"
                class="text-green-600 hover:text-green-700 px-3 py-1 border border-green-200 rounded-lg text-sm">
                Export
            </a>
            <form method="POST" action="{{ route('admin.enquiries.destroy', $enquiry) }}" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Delete this enquiry? This cannot be undone.')"
                    class="text-red-600 hover:text-red-700 px-3 py-1 border border-red-200 rounded-lg text-sm">
                    Delete
                </button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h3 class="text-sm font-semibold text-gray-500 uppercase mb-3">Contact Details</h3>
            <div class="space-y-3">
                <div>
                    <label class="text-xs text-gray-500">Name</label>
                    <p class="text-gray-900 font-medium">{{ $enquiry->name }}</p>
                </div>
                <div>
                    <label class="text-xs text-gray-500">Email</label>
                    <p class="text-gray-900 font-medium">{{ $enquiry->email }}</p>
                </div>
                <div>
                    <label class="text-xs text-gray-500">Phone</label>
                    <p class="text-gray-900 font-medium">{{ $enquiry->phone ?? '—' }}</p>
                </div>
                <div>
                    <label class="text-xs text-gray-500">Subject</label>
                    <p class="text-gray-900 font-medium">{{ $enquiry->subject ?? '—' }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h3 class="text-sm font-semibold text-gray-500 uppercase mb-3">System Info</h3>
            <div class="space-y-3">
                <div>
                    <label class="text-xs text-gray-500">IP Address</label>
                    <p class="text-gray-900 font-medium">{{ $enquiry->ip_address ?? '—' }}</p>
                </div>
                <div>
                    <label class="text-xs text-gray-500">User Agent</label>
                    <p class="text-xs text-gray-600 break-all">{{ $enquiry->user_agent ?? '—' }}</p>
                </div>
                <div>
                    <label class="text-xs text-gray-500">Submitted</label>
                    <p class="text-gray-900 font-medium">{{ $enquiry->created_at->format('M d, Y H:i') }}</p>
                </div>
                <div>
                    <label class="text-xs text-gray-500">Last Updated</label>
                    <p class="text-gray-900 font-medium">{{ $enquiry->updated_at->format('M d, Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h3 class="text-sm font-semibold text-gray-500 uppercase mb-3">Message</h3>
        <div class="bg-gray-50 rounded-lg p-4">
            <p class="text-gray-800 whitespace-pre-wrap">{{ $enquiry->message }}</p>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <div class="flex justify-between items-center mb-3">
            <h3 class="text-sm font-semibold text-gray-500 uppercase">Update Status</h3>
            <form method="POST" action="{{ route('admin.enquiries.update', $enquiry) }}">
                @csrf
                @method('PUT')
                <div class="flex gap-3 items-end">
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">Status</label>
                        <select name="status" class="admin-input text-sm">
                            <option value="new" {{ $enquiry->status === 'new' ? 'selected' : '' }}>New</option>
                            <option value="in_progress" {{ $enquiry->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="contacted" {{ $enquiry->status === 'contacted' ? 'selected' : '' }}>Contacted</option>
                            <option value="converted" {{ $enquiry->status === 'converted' ? 'selected' : '' }}>Converted</option>
                            <option value="closed" {{ $enquiry->status === 'closed' ? 'selected' : '' }}>Closed</option>
                        </select>
                    </div>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                        Update
                    </button>
                </div>
            </form>
        </div>

        <div class="mt-4">
            <h4 class="text-xs font-semibold text-gray-500 uppercase mb-2">Internal Notes</h4>
            <textarea name="internal_notes" class="admin-textarea" rows="3"
                placeholder="Add your internal notes here...">{{ old('internal_notes', $enquiry->internal_notes) }}</textarea>
        </div>

        <form method="POST" action="{{ route('admin.enquiries.update', $enquiry) }}" class="mt-3">
            @csrf
            @method('PUT')
            <input type="hidden" name="status" value="{{ $enquiry->status }}">
            <div class="flex gap-3">
                <textarea name="internal_notes" class="admin-textarea text-sm flex-1" rows="2"
                    placeholder="Add a note..."></textarea>
                <button type="submit" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium">
                    Save Notes
                </button>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h3 class="text-sm font-semibold text-gray-500 uppercase mb-3">Status History</h3>
        @if($statusLogs && $statusLogs->count() > 0)
            <div class="space-y-3">
                @foreach($statusLogs as $log)
                    <div class="border-l-2 border-gray-200 pl-3 pb-2">
                        <div class="text-sm">
                            <span class="font-medium text-gray-700">{{ $log->user ? $log->user->name : 'System' }}</span>
                            <span class="text-gray-500">changed status to:</span>
                            <span class="font-medium text-{{ \App\Models\Enquiry::where('id', $log->enquiry_id)->first()->status_color }}-600">
                                {{ ucfirst(str_replace('_', ' ', $log->status)) }}
                            </span>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">{{ $log->created_at->format('M d, Y H:i') }}</p>
                        @if($log->note)
                            <p class="text-sm text-gray-600 mt-1">{{ $log->note }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 text-sm">No status changes recorded.</p>
        @endif
    </div>
</div>
@endsection
