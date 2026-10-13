@extends('admin.layouts.master')

@section('title', 'Enquiries')
@section('header', 'Enquiries')

@section('admin-content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-semibold text-gray-900">Manage Enquiries</h2>
    <a href="{{ route('admin.enquiries.export') }}"
        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
        Export CSV
    </a>
</div>

<div class="bg-white rounded-xl border border-gray-200 p-4 mb-4">
    <form method="GET" class="flex gap-4 items-end">
        <div class="flex-1">
            <label class="block text-xs text-gray-500 mb-1">Search</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, email, message..."
                class="admin-input">
        </div>
        <div>
            <label class="block text-xs text-gray-500 mb-1">Status</label>
            <select name="status" class="admin-input">
                <option value="">All Statuses</option>
                <option value="new" {{ request('status') === 'new' ? 'selected' : '' }}>New</option>
                <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                <option value="contacted" {{ request('status') === 'contacted' ? 'selected' : '' }}>Contacted</option>
                <option value="converted" {{ request('status') === 'converted' ? 'selected' : '' }}>Converted</option>
                <option value="closed" {{ request('status') === 'closed' ? 'selected' : '' }}>Closed</option>
            </select>
        </div>
        <div>
            <label class="block text-xs text-gray-500 mb-1">Date From</label>
            <input type="date" name="date_from" value="{{ request('date_from') }}" class="admin-input">
        </div>
        <div>
            <label class="block text-xs text-gray-500 mb-1">Date To</label>
            <input type="date" name="date_to" value="{{ request('date_to') }}" class="admin-input">
        </div>
        <button type="submit" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm">Filter</button>
    </form>
</div>

<div class="overflow-x-auto">
    <table class="w-full">
        <thead>
            <tr class="border-b border-gray-200">
                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase">Name</th>
                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase">Email</th>
                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase">Phone</th>
                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase">Subject</th>
                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase">Status</th>
                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase">Date</th>
                <th class="text-right py-3 px-4 text-xs font-semibold text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($enquiries as $enquiry)
                <tr class="border-b border-gray-100">
                    <td class="py-3 px-4">
                        <div class="flex items-center gap-2">
                            <span class="font-medium text-gray-900">{{ $enquiry->name }}</span>
                            @if($enquiry->isUnread())
                                <span class="w-2 h-2 bg-emerald-500 rounded-full"></span>
                            @endif
                        </div>
                    </td>
                    <td class="py-3 px-4 text-sm text-gray-700">{{ $enquiry->email }}</td>
                    <td class="py-3 px-4 text-sm text-gray-700">{{ $enquiry->phone ?? '—' }}</td>
                    <td class="py-3 px-4 text-sm text-gray-700">{{ Str::limit($enquiry->subject, 40) ?: '—' }}</td>
                    <td class="py-3 px-4">
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
                    </td>
                    <td class="py-3 px-4 text-sm text-gray-500">{{ $enquiry->created_at->format('M d, Y') }}</td>
                    <td class="py-3 px-4 text-right">
                        <div class="flex justify-end items-center gap-2">
                            <a href="{{ route('admin.enquiries.show', $enquiry) }}" class="text-emerald-700 hover:text-emerald-800" title="View details">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </a>
                        <form method="POST" action="{{ route('admin.enquiries.destroy', $enquiry) }}" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Delete this enquiry? This cannot be undone.')"
                                class="text-red-600 hover:text-red-700">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.133A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.86L5 7m5 5v6m4-6v6m1-10V4a1 1 0 00-1-1h-2a1 1 0 00-1 1v3m-4 0h6"></path>
                                </svg>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center py-8 text-gray-500">No enquiries found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($enquiries->hasPages())
    <div class="mt-4">
        {{ $enquiries->links() }}
    </div>
@endif
@endsection

