@extends('admin.layouts.master')

@section('title', 'Dashboard')
@section('header', 'Dashboard Overview')

@section('admin-content')
<div class="space-y-7">
    {{-- Top Welcome / Hero Banner --}}
    <section class="relative overflow-hidden rounded-2xl border border-[#E5E0D5] bg-gradient-to-br from-white via-[#FAF9F5] to-[#F5EFEB] p-6 shadow-sm">
        <div class="absolute -right-8 -top-8 w-48 h-48 bg-[#B85D19]/5 rounded-full blur-2xl pointer-events-none"></div>
        <div class="relative flex flex-col gap-5 md:flex-row md:items-center md:justify-between">
            <div class="space-y-1.5">
                <div class="inline-flex items-center gap-2 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-[#B85D19]/10 text-[#B85D19] border border-[#B85D19]/20">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#B85D19] animate-pulse"></span>
                    Admin Control Center
                </div>
                <h1 class="text-2xl font-bold tracking-tight text-[#18191B] sm:text-3xl font-display">
                    Welcome back, {{ Auth::user()?->name ?? 'Administrator' }}
                </h1>
                <p class="text-sm text-stone-600 max-w-2xl">
                    Portfolio metrics, client inquiries, recent projects aur visitor activity ka live snapshot.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-2.5">
                <a href="{{ route('admin.projects.create') }}" class="admin-btn-primary">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    New Project
                </a>
                <a href="{{ route('admin.enquiries.index') }}" class="admin-btn-secondary">
                    <svg class="w-4 h-4 mr-1.5 text-stone-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H4a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                    View Inquiries ({{ $stats['unread_enquiries'] }} new)
                </a>
                <a href="{{ url('/') }}" target="_blank" rel="noopener" class="admin-btn-secondary" title="Preview Frontend">
                    <svg class="w-4 h-4 text-stone-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                </a>
            </div>
        </div>

        @if($stats['maintenance_mode'] ?? false)
            <div class="mt-4 p-3 rounded-xl bg-amber-500/10 border border-amber-500/20 text-amber-800 text-xs flex items-center justify-between">
                <span class="flex items-center gap-2 font-medium">
                    <svg class="w-4 h-4 text-amber-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    <strong>Maintenance Mode Active:</strong> Public visitors cannot see portfolio content currently.
                </span>
                <a href="{{ route('admin.maintenance.edit') }}" class="underline font-semibold hover:text-amber-900">Manage Status &rarr;</a>
            </div>
        @endif
    </section>

    {{-- Main Stat Cards Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        {{-- Total Projects --}}
        <div class="admin-stat-card">
            <div class="flex items-start justify-between">
                <div>
                    <span class="text-xs font-semibold text-stone-500 uppercase tracking-wider">Total Projects</span>
                    <h3 class="text-2xl sm:text-3xl font-bold text-[#18191B] mt-1">{{ $stats['total_projects'] }}</h3>
                    <div class="flex items-center gap-2 mt-2 text-xs text-stone-500">
                        <span class="inline-flex items-center text-emerald-700 font-semibold">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1"></span>
                            {{ $stats['published_projects'] }} Live
                        </span>
                        <span>&bull;</span>
                        <span class="text-amber-700 font-medium">{{ $stats['draft_projects'] }} Draft</span>
                    </div>
                </div>
                <div class="w-11 h-11 rounded-xl bg-[#B85D19]/10 border border-[#B85D19]/20 text-[#B85D19] flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-[#E5E0D5]/60 flex items-center justify-between text-xs">
                <a href="{{ route('admin.projects.index') }}" class="text-[#B85D19] font-medium hover:underline inline-flex items-center">
                    Manage Portfolio &rarr;
                </a>
            </div>
        </div>

        {{-- Client Enquiries --}}
        <div class="admin-stat-card">
            <div class="flex items-start justify-between">
                <div>
                    <span class="text-xs font-semibold text-stone-500 uppercase tracking-wider">Client Inquiries</span>
                    <h3 class="text-2xl sm:text-3xl font-bold text-[#18191B] mt-1">{{ $stats['total_enquiries'] }}</h3>
                    <div class="flex items-center gap-2 mt-2 text-xs">
                        @if($stats['unread_enquiries'] > 0)
                            <span class="inline-flex items-center px-1.5 py-0.5 rounded bg-red-100 text-red-700 font-semibold">
                                {{ $stats['unread_enquiries'] }} Unread
                            </span>
                        @else
                            <span class="inline-flex items-center text-emerald-700 font-medium">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1"></span> All read
                            </span>
                        @endif
                        <span>&bull;</span>
                        <span class="text-stone-500">{{ $stats['new_enquiries'] }} New</span>
                    </div>
                </div>
                <div class="w-11 h-11 rounded-xl bg-amber-500/10 border border-amber-500/20 text-amber-700 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 01-2-2v12a2 2 0 002 2z"/></svg>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-[#E5E0D5]/60 flex items-center justify-between text-xs">
                <a href="{{ route('admin.enquiries.index') }}" class="text-[#B85D19] font-medium hover:underline inline-flex items-center">
                    Open Inbox &rarr;
                </a>
            </div>
        </div>

        {{-- Total Services & Skills --}}
        <div class="admin-stat-card">
            <div class="flex items-start justify-between">
                <div>
                    <span class="text-xs font-semibold text-stone-500 uppercase tracking-wider">Services &amp; Skills</span>
                    <h3 class="text-2xl sm:text-3xl font-bold text-[#18191B] mt-1">{{ $stats['total_services'] }} <span class="text-sm font-normal text-stone-500">services</span></h3>
                    <div class="flex items-center gap-2 mt-2 text-xs text-stone-500">
                        <span class="font-semibold text-stone-700">{{ $stats['total_skills'] }}</span> Skills in stack
                        <span>&bull;</span>
                        <span class="font-medium text-stone-600">{{ $stats['total_testimonials'] ?? 0 }} Reviews</span>
                    </div>
                </div>
                <div class="w-11 h-11 rounded-xl bg-stone-900/5 border border-stone-900/10 text-stone-700 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-[#E5E0D5]/60 flex items-center justify-between text-xs">
                <a href="{{ route('admin.services.index') }}" class="text-[#B85D19] font-medium hover:underline inline-flex items-center">
                    Manage Offerings &rarr;
                </a>
            </div>
        </div>

        {{-- Traffic & Analytics --}}
        <div class="admin-stat-card">
            <div class="flex items-start justify-between">
                <div>
                    <span class="text-xs font-semibold text-stone-500 uppercase tracking-wider">Visitor Traffic</span>
                    <h3 class="text-2xl sm:text-3xl font-bold text-[#18191B] mt-1">{{ number_format($stats['total_visits'] ?? 0) }}</h3>
                    <div class="flex items-center gap-2 mt-2 text-xs text-stone-500">
                        <span class="text-emerald-700 font-semibold">+{{ $stats['today_visits'] ?? 0 }} Today</span>
                        <span>&bull;</span>
                        <span>Audited unique visits</span>
                    </div>
                </div>
                <div class="w-11 h-11 rounded-xl bg-emerald-600/10 border border-emerald-600/20 text-emerald-700 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-[#E5E0D5]/60 flex items-center justify-between text-xs">
                <a href="{{ route('admin.analytics.index') }}" class="text-[#B85D19] font-medium hover:underline inline-flex items-center">
                    Full Analytics &rarr;
                </a>
            </div>
        </div>
    </div>

    {{-- Pipeline & Traffic Insights Strip --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Enquiry Funnel / Status breakdown --}}
        <div class="admin-card p-5">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-sm font-bold text-[#18191B] uppercase tracking-wide">Inquiry Status Breakdown</h3>
                    <p class="text-xs text-stone-500 mt-0.5">Contact leads progressing through stages</p>
                </div>
                <span class="text-xs font-mono font-semibold px-2 py-0.5 rounded bg-stone-100 text-stone-700">
                    {{ $stats['total_enquiries'] }} Total
                </span>
            </div>

            <div class="space-y-3">
                <div>
                    <div class="flex items-center justify-between text-xs mb-1 font-medium">
                        <span class="text-stone-700">New Inquiries</span>
                        <span class="font-bold text-[#18191B]">{{ $stats['new_enquiries'] }}</span>
                    </div>
                    <div class="w-full bg-[#E5E0D5] rounded-full h-2 overflow-hidden">
                        @php $newPct = $stats['total_enquiries'] > 0 ? ($stats['new_enquiries'] / $stats['total_enquiries']) * 100 : 0; @endphp
                        <div class="bg-blue-600 h-2 rounded-full transition-all duration-500" style="width: {{ $newPct }}%"></div>
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between text-xs mb-1 font-medium">
                        <span class="text-stone-700">In Progress / Responded</span>
                        <span class="font-bold text-[#18191B]">{{ $stats['in_progress_enquiries'] ?? 0 }}</span>
                    </div>
                    <div class="w-full bg-[#E5E0D5] rounded-full h-2 overflow-hidden">
                        @php $inProgPct = $stats['total_enquiries'] > 0 ? (($stats['in_progress_enquiries'] ?? 0) / $stats['total_enquiries']) * 100 : 0; @endphp
                        <div class="bg-amber-600 h-2 rounded-full transition-all duration-500" style="width: {{ $inProgPct }}%"></div>
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between text-xs mb-1 font-medium">
                        <span class="text-stone-700">Converted Clients</span>
                        <span class="font-bold text-emerald-700">{{ $stats['converted_enquiries'] ?? 0 }}</span>
                    </div>
                    <div class="w-full bg-[#E5E0D5] rounded-full h-2 overflow-hidden">
                        @php $convPct = $stats['total_enquiries'] > 0 ? (($stats['converted_enquiries'] ?? 0) / $stats['total_enquiries']) * 100 : 0; @endphp
                        <div class="bg-emerald-600 h-2 rounded-full transition-all duration-500" style="width: {{ $convPct }}%"></div>
                    </div>
                </div>
            </div>

            <div class="mt-5 pt-4 border-t border-[#E5E0D5] flex items-center justify-between text-xs">
                <span class="text-stone-500">Fast action = higher conversion</span>
                <a href="{{ route('admin.enquiries.index') }}" class="font-semibold text-[#B85D19] hover:underline">Manage leads &rarr;</a>
            </div>
        </div>

        {{-- Device Split Breakdown --}}
        <div class="admin-card p-5">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-sm font-bold text-[#18191B] uppercase tracking-wide">Visitor Devices</h3>
                    <p class="text-xs text-stone-500 mt-0.5">Audience browsing behavior</p>
                </div>
                <span class="text-xs font-mono font-semibold px-2 py-0.5 rounded bg-stone-100 text-stone-700">
                    Live Telemetry
                </span>
            </div>

            @php
                $devTotal = array_sum($deviceBreakdown ?? []);
            @endphp

            @if($devTotal > 0)
                <div class="space-y-3.5">
                    @foreach($deviceBreakdown as $device => $count)
                        @php $pct = $devTotal > 0 ? round(($count / $devTotal) * 100) : 0; @endphp
                        <div>
                            <div class="flex items-center justify-between text-xs mb-1">
                                <span class="capitalize font-medium text-stone-700 flex items-center gap-1.5">
                                    @if(strtolower($device) === 'desktop')
                                        <svg class="w-3.5 h-3.5 text-stone-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                    @elseif(strtolower($device) === 'mobile')
                                        <svg class="w-3.5 h-3.5 text-stone-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                    @else
                                        <svg class="w-3.5 h-3.5 text-stone-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                    @endif
                                    {{ $device }}
                                </span>
                                <span class="font-mono text-stone-600 font-semibold">{{ $count }} ({{ $pct }}%)</span>
                            </div>
                            <div class="w-full bg-[#E5E0D5] rounded-full h-1.5 overflow-hidden">
                                <div class="bg-[#B85D19] h-1.5 rounded-full" style="width: {{ $pct }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="py-8 text-center text-xs text-stone-400">
                    <p>No visitor device data logged yet.</p>
                </div>
            @endif

            <div class="mt-5 pt-4 border-t border-[#E5E0D5] flex items-center justify-between text-xs">
                <span class="text-stone-500">Fully responsive UI ready</span>
                <a href="{{ route('admin.analytics.index') }}" class="font-semibold text-[#B85D19] hover:underline">Detailed traffic &rarr;</a>
            </div>
        </div>

        {{-- Quick Operations Card --}}
        <div class="admin-card p-5">
            <h3 class="text-sm font-bold text-[#18191B] uppercase tracking-wide mb-1">Quick Action Hub</h3>
            <p class="text-xs text-stone-500 mb-4">Direct shortcuts to frequent management screens</p>

            <div class="grid grid-cols-2 gap-2.5">
                <a href="{{ route('admin.projects.create') }}" class="p-3 rounded-xl border border-[#E5E0D5] bg-stone-50/50 hover:bg-[#B85D19]/5 hover:border-[#B85D19]/30 transition-all text-left group">
                    <span class="text-xs font-semibold text-stone-900 group-hover:text-[#B85D19] block">+ Project</span>
                    <span class="text-[11px] text-stone-500">Publish work</span>
                </a>
                <a href="{{ route('admin.services.create') }}" class="p-3 rounded-xl border border-[#E5E0D5] bg-stone-50/50 hover:bg-[#B85D19]/5 hover:border-[#B85D19]/30 transition-all text-left group">
                    <span class="text-xs font-semibold text-stone-900 group-hover:text-[#B85D19] block">+ Service</span>
                    <span class="text-[11px] text-stone-500">Add offering</span>
                </a>
                <a href="{{ route('admin.profile.edit') }}" class="p-3 rounded-xl border border-[#E5E0D5] bg-stone-50/50 hover:bg-[#B85D19]/5 hover:border-[#B85D19]/30 transition-all text-left group">
                    <span class="text-xs font-semibold text-stone-900 group-hover:text-[#B85D19] block">Edit Bio</span>
                    <span class="text-[11px] text-stone-500">Update resume</span>
                </a>
                <a href="{{ route('admin.homepage.edit') }}" class="p-3 rounded-xl border border-[#E5E0D5] bg-stone-50/50 hover:bg-[#B85D19]/5 hover:border-[#B85D19]/30 transition-all text-left group">
                    <span class="text-xs font-semibold text-stone-900 group-hover:text-[#B85D19] block">Homepage</span>
                    <span class="text-[11px] text-stone-500">Reorder sections</span>
                </a>
                <a href="{{ route('admin.seo.edit') }}" class="p-3 rounded-xl border border-[#E5E0D5] bg-stone-50/50 hover:bg-[#B85D19]/5 hover:border-[#B85D19]/30 transition-all text-left group">
                    <span class="text-xs font-semibold text-stone-900 group-hover:text-[#B85D19] block">SEO Tags</span>
                    <span class="text-[11px] text-stone-500">Meta &amp; OpenGraph</span>
                </a>
                <a href="{{ route('admin.settings.index') }}" class="p-3 rounded-xl border border-[#E5E0D5] bg-stone-50/50 hover:bg-[#B85D19]/5 hover:border-[#B85D19]/30 transition-all text-left group">
                    <span class="text-xs font-semibold text-stone-900 group-hover:text-[#B85D19] block">Settings</span>
                    <span class="text-[11px] text-stone-500">System config</span>
                </a>
            </div>
        </div>
    </div>

    {{-- Bottom Two Columns: Recent Inquiries & Recent Projects --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Recent Inquiries --}}
        <div class="admin-card overflow-hidden">
            <div class="border-b border-[#E5E0D5] px-5 py-4 flex items-center justify-between bg-stone-50/50">
                <div>
                    <h2 class="text-sm font-bold text-[#18191B] uppercase tracking-wide">Recent Messages</h2>
                    <p class="text-xs text-stone-500">Inquiries submitted via contact form</p>
                </div>
                <a href="{{ route('admin.enquiries.index') }}" class="text-xs font-semibold text-[#B85D19] hover:underline">
                    View All &rarr;
                </a>
            </div>

            <div class="divide-y divide-[#E5E0D5]">
                @forelse($recentEnquiries as $enquiry)
                    <div class="p-4 hover:bg-[#FAF9F5] transition-colors">
                        <div class="flex items-start justify-between gap-3">
                            <div class="space-y-1 min-w-0">
                                <div class="flex items-center gap-2">
                                    <p class="font-semibold text-sm text-[#18191B] truncate">{{ $enquiry->name }}</p>
                                    @if(!$enquiry->is_read)
                                        <span class="w-2 h-2 rounded-full bg-[#B85D19]" title="Unread"></span>
                                    @endif
                                </div>
                                <p class="text-xs text-stone-500">{{ $enquiry->email }}</p>
                                <p class="text-xs text-stone-700 mt-1 line-clamp-2 leading-relaxed">{{ Str::limit($enquiry->message, 100) }}</p>
                                <p class="text-[11px] text-stone-400 font-mono">{{ $enquiry->created_at->diffForHumans() }}</p>
                            </div>

                            <div class="flex flex-col items-end gap-2 flex-shrink-0">
                                @php
                                    $badge = match($enquiry->status) {
                                        'new' => 'admin-badge-info',
                                        'in_progress' => 'admin-badge-warning',
                                        'contacted' => 'admin-badge-brand',
                                        'converted' => 'admin-badge-success',
                                        default => 'admin-badge-neutral',
                                    };
                                @endphp
                                <span class="{{ $badge }}">{{ $enquiry->status_label }}</span>
                                <a href="{{ route('admin.enquiries.show', $enquiry) }}" class="text-xs text-[#B85D19] font-medium hover:underline">
                                    Open &rarr;
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-xs text-stone-400">
                        <svg class="w-8 h-8 mx-auto text-stone-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H4a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                        No messages received yet.
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Recent Projects --}}
        <div class="admin-card overflow-hidden">
            <div class="border-b border-[#E5E0D5] px-5 py-4 flex items-center justify-between bg-stone-50/50">
                <div>
                    <h2 class="text-sm font-bold text-[#18191B] uppercase tracking-wide">Recent Projects</h2>
                    <p class="text-xs text-stone-500">Portfolio catalog activity</p>
                </div>
                <a href="{{ route('admin.projects.index') }}" class="text-xs font-semibold text-[#B85D19] hover:underline">
                    View All &rarr;
                </a>
            </div>

            <div class="divide-y divide-[#E5E0D5]">
                @forelse($recentProjects as $project)
                    <div class="p-4 hover:bg-[#FAF9F5] transition-colors">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-xl bg-stone-100 border border-[#E5E0D5] flex-shrink-0 overflow-hidden flex items-center justify-center">
                                @if($project->thumbnail)
                                    <img src="{{ $project->thumbnail_url }}" alt="{{ $project->title }}" class="w-full h-full object-cover">
                                @else
                                    <svg class="w-5 h-5 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                @endif
                            </div>

                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2">
                                    <p class="font-semibold text-sm text-[#18191B] truncate">{{ $project->title }}</p>
                                    @if($project->is_featured)
                                        <span class="text-[10px] font-bold px-1.5 py-0.2 rounded bg-amber-100 text-amber-800">Featured</span>
                                    @endif
                                </div>
                                <p class="text-xs text-stone-500 mt-0.5 truncate">{{ $project->subtitle ?? ($project->category?->name ?? 'General') }}</p>
                                <p class="text-[11px] text-stone-400 font-mono mt-0.5">{{ $project->created_at->diffForHumans() }}</p>
                            </div>

                            <div class="flex flex-col items-end gap-1.5">
                                <span class="{{ $project->status === 'published' ? 'admin-badge-success' : 'admin-badge-warning' }}">
                                    {{ $project->status_label }}
                                </span>
                                <a href="{{ route('admin.projects.edit', $project) }}" class="text-xs text-[#B85D19] font-medium hover:underline">
                                    Edit &rarr;
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-xs text-stone-400">
                        <svg class="w-8 h-8 mx-auto text-stone-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                        No projects created yet.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
