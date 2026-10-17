@extends('admin.layouts.master')

@section('title', 'Enquiries')
@section('header', 'Client Communications')

@section('admin-content')
<div class="space-y-6">

    <!-- Top Banner -->
    <div class="flex flex-col gap-4 rounded-2xl border border-[#E5E1D5] bg-gradient-to-br from-white to-[#FAF9F5] p-5 shadow-xs sm:flex-row sm:items-center sm:justify-between sm:p-6">
        <div>
            <div class="flex items-center gap-2">
                <span class="inline-flex h-2 w-2 rounded-full bg-[#B85D19]"></span>
                <p class="text-xs font-mono font-bold uppercase tracking-wider text-[#B85D19]">Inbox &amp; Messages</p>
            </div>
            <h2 class="mt-1 text-xl font-bold tracking-tight text-stone-900 sm:text-2xl">Client Inquiries &amp; Leads</h2>
            <p class="mt-1 text-xs text-stone-500 sm:text-sm">Manage messages received from the portfolio contact form, track status, and export.</p>
        </div>
        <div class="flex items-center gap-2.5">
            <a href="{{ route('admin.enquiries.export') }}" class="admin-btn-secondary">
                <svg class="w-4 h-4 text-stone-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                <span>Export CSV</span>
            </a>
        </div>
    </div>

    <!-- Filters & Search -->
    <div class="rounded-2xl border border-[#E5E1D5] bg-white p-4 shadow-xs">
        <form method="GET" class="flex flex-col gap-3 sm:flex-row sm:items-center">
            <div class="flex-1">
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, email, or message..." class="admin-input pl-10 text-xs sm:text-sm">
                    <svg class="w-4 h-4 text-stone-400 absolute left-3.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="w-full sm:w-44">
                <select name="status" class="admin-input text-xs sm:text-sm">
                    <option value="">All Statuses</option>
                    <option value="new" {{ request('status') === 'new' ? 'selected' : '' }}>New Messages</option>
                    <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="contacted" {{ request('status') === 'contacted' ? 'selected' : '' }}>Contacted</option>
                    <option value="converted" {{ request('status') === 'converted' ? 'selected' : '' }}>Converted Lead</option>
                    <option value="closed" {{ request('status') === 'closed' ? 'selected' : '' }}>Closed</option>
                </select>
            </div>
            <div class="flex items-center gap-2">
                <button type="submit" class="admin-btn-primary text-xs py-2.5">
                    Filter
                </button>
                @if(request('search') || request('status') || request('date_from') || request('date_to'))
                    <a href="{{ route('admin.enquiries.index') }}" class="admin-btn-secondary text-xs py-2.5">
                        Clear
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="overflow-hidden rounded-2xl border border-[#E5E1D5] bg-white shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-stone-700">
                <thead class="border-b border-[#E5E1D5] bg-[#FAF9F5] text-xs font-semibold uppercase tracking-wider text-stone-500">
                    <tr>
                        <th class="px-5 py-3.5">Sender</th>
                        <th class="px-5 py-3.5">Email / Contact</th>
                        <th class="px-5 py-3.5">Subject / Preview</th>
                        <th class="px-5 py-3.5">Status</th>
                        <th class="px-5 py-3.5">Received</th>
                        <th class="px-5 py-3.5 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E5E1D5]">
                    @forelse($enquiries as $enquiry)
                        <tr class="hover:bg-[#FAF9F5] transition-colors {{ $enquiry->isUnread() ? 'bg-[#FAF9F5]/60 font-semibold' : '' }}">
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-2.5">
                                    @if($enquiry->isUnread())
                                        <span class="h-2 w-2 rounded-full bg-[#B85D19] shrink-0" title="Unread message"></span>
                                    @else
                                        <span class="h-2 w-2 rounded-full bg-transparent shrink-0"></span>
                                    @endif
                                    <span class="font-bold text-stone-900">{{ $enquiry->name }}</span>
                                </div>
                            </td>
                            <td class="px-5 py-4">
                                <a href="mailto:{{ $enquiry->email }}" class="text-xs text-stone-600 hover:text-[#B85D19] underline underline-offset-2">
                                    {{ $enquiry->email }}
                                </a>
                                @if($enquiry->phone)
                                    <span class="block text-[11px] text-stone-400 mt-0.5">{{ $enquiry->phone }}</span>
                                @endif
                            </td>
                            <td class="px-5 py-4">
                                <div class="text-xs text-stone-900 font-medium">{{ $enquiry->subject ?: 'General Inquiry' }}</div>
                                <div class="text-[11px] text-stone-500 line-clamp-1 max-w-xs">{{ Str::limit($enquiry->message, 60) }}</div>
                            </td>
                            <td class="px-5 py-4">
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
                            </td>
                            <td class="px-5 py-4 text-xs text-stone-500 whitespace-nowrap">
                                {{ $enquiry->created_at->format('M d, Y') }}
                                <span class="block text-[10px] text-stone-400">{{ $enquiry->created_at->diffForHumans() }}</span>
                            </td>
                            <td class="px-5 py-4 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('admin.enquiries.show', $enquiry) }}" class="rounded-lg p-1.5 text-[#B85D19] hover:bg-[#B85D19]/10 transition" title="View details">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>
                                    <form method="POST" action="{{ route('admin.enquiries.destroy', $enquiry) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Delete this enquiry?')" class="rounded-lg p-1.5 text-stone-400 hover:bg-rose-50 hover:text-rose-600 transition" title="Delete enquiry">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.133A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.86L5 7m5 5v6m4-6v6m1-10V4a1 1 0 00-1-1h-2a1 1 0 00-1 1v3m-4 0h6"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-12 text-center">
                                <div class="mx-auto max-w-sm text-center">
                                    <p class="text-sm font-bold text-stone-900">No enquiries found</p>
                                    <p class="mt-1 text-xs text-stone-500">Messages sent via the contact form on your portfolio will show up here.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($enquiries->hasPages())
            <div class="border-t border-[#E5E1D5] px-5 py-3">
                {{ $enquiries->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
