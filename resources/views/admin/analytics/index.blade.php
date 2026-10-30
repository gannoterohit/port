@extends('admin.layouts.master')

@section('title', 'Visitor Analytics & Live Logs')
@section('header', 'Visitor Analytics')

@section('admin-content')
<div class="space-y-6">

    <!-- Top Header Banner -->
    <div class="flex flex-col gap-4 rounded-2xl border border-[#E5E1D5] bg-gradient-to-br from-white to-[#FAF9F5] p-5 shadow-xs sm:flex-row sm:items-center sm:justify-between sm:p-6">
        <div>
            <div class="flex items-center gap-2">
                <span class="relative flex h-2.5 w-2.5">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                </span>
                <p class="text-xs font-mono font-bold uppercase tracking-wider text-emerald-600">Real-Time Traffic Intelligence</p>
            </div>
            <h2 class="mt-1 text-xl font-bold tracking-tight text-stone-900 sm:text-2xl">Visitor Traffic &amp; Page Activity</h2>
            <p class="mt-1 text-xs text-stone-500 sm:text-sm">See who visited your portfolio, what projects they inspected, their location, and device.</p>
        </div>
        <div class="flex flex-wrap items-center gap-2.5">
            <form method="POST" action="{{ route('admin.analytics.clear') }}" onsubmit="return confirm('Clear visitor logs older than 30 days?');">
                @csrf
                <input type="hidden" name="days" value="30">
                <button type="submit" class="admin-btn-secondary text-xs">
                    <svg class="w-3.5 h-3.5 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.133A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.86L5 7m5 5v6m4-6v6m1-10V4a1 1 0 00-1-1h-2a1 1 0 00-1 1v3m-4 0h6"></path></svg>
                    <span>Clean Old Logs (&gt;30d)</span>
                </button>
            </form>
            <a href="{{ route('admin.analytics.index') }}" class="admin-btn-primary text-xs">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                <span>Refresh Live Stats</span>
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
            <svg class="h-5 w-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <!-- High-Impact 4 Stat Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
        <div class="rounded-2xl border border-[#E5E1D5] bg-white p-5 shadow-xs">
            <div class="flex items-center justify-between text-xs font-semibold uppercase tracking-wider text-stone-500 mb-2">
                <span>Total Pageviews</span>
                <span class="p-1.5 rounded-lg bg-black/[0.04] text-stone-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                </span>
            </div>
            <div class="text-2xl sm:text-3xl font-extrabold text-stone-900 tracking-tight">{{ number_format($totalVisits) }}</div>
            <p class="text-[11px] text-stone-400 mt-1">All time portfolio hits</p>
        </div>

        <div class="rounded-2xl border border-[#E5E1D5] bg-white p-5 shadow-xs">
            <div class="flex items-center justify-between text-xs font-semibold uppercase tracking-wider text-stone-500 mb-2">
                <span>Unique Visitors</span>
                <span class="p-1.5 rounded-lg bg-blue-50 text-blue-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </span>
            </div>
            <div class="text-2xl sm:text-3xl font-extrabold text-blue-600 tracking-tight">{{ number_format($uniqueVisitors) }}</div>
            <p class="text-[11px] text-stone-400 mt-1">Distinct IP addresses</p>
        </div>

        <div class="rounded-2xl border border-[#E5E1D5] bg-white p-5 shadow-xs">
            <div class="flex items-center justify-between text-xs font-semibold uppercase tracking-wider text-stone-500 mb-2">
                <span>Today's Visits</span>
                <span class="p-1.5 rounded-lg bg-emerald-50 text-emerald-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </span>
            </div>
            <div class="text-2xl sm:text-3xl font-extrabold text-emerald-600 tracking-tight">{{ number_format($todayVisits) }}</div>
            <p class="text-[11px] text-stone-400 mt-1">{{ number_format($todayUnique) }} unique visitors today</p>
        </div>

        <div class="rounded-2xl border border-[#E5E1D5] bg-white p-5 shadow-xs">
            <div class="flex items-center justify-between text-xs font-semibold uppercase tracking-wider text-stone-500 mb-2">
                <span>Human vs Bot</span>
                <span class="p-1.5 rounded-lg bg-amber-50 text-[#B85D19]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                </span>
            </div>
            <div class="text-2xl sm:text-3xl font-extrabold text-[#B85D19] tracking-tight">
                {{ $totalVisits > 0 ? round(($humanVisits / $totalVisits) * 100) : 100 }}%
            </div>
            <p class="text-[11px] text-stone-400 mt-1">{{ number_format($humanVisits) }} genuine human visits</p>
        </div>
    </div>

    <!-- 3 Analytics Breakdown Cards (Pages, Sources, Devices) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- 1. Top Visited Pages & Projects -->
        <div class="rounded-2xl border border-[#E5E1D5] bg-white p-5 sm:p-6 shadow-xs flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between pb-3 border-b border-[#E5E1D5] mb-4">
                    <h3 class="text-sm font-bold text-stone-900">Most Viewed Pages</h3>
                    <span class="text-[10px] font-mono uppercase tracking-wider text-stone-400">Hits</span>
                </div>
                <div class="space-y-3">
                    @forelse($topPages as $page)
                        @php($pct = $totalVisits > 0 ? round(($page->total / $totalVisits) * 100) : 0)
                        <div>
                            <div class="flex items-center justify-between text-xs mb-1">
                                <span class="font-semibold text-stone-900 truncate max-w-[190px]" title="{{ $page->page_url }}">{{ $page->page_title ?: 'Page' }}</span>
                                <span class="font-mono font-bold text-[#B85D19]">{{ $page->total }}</span>
                            </div>
                            <div class="h-1.5 rounded-full bg-stone-100 overflow-hidden">
                                <div class="h-full bg-[#B85D19] rounded-full" style="width: {{ max(6, $pct) }}%"></div>
                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-stone-400 py-4 text-center">No page views recorded yet.</p>
                    @endforelse
                </div>
            </div>
            <p class="text-[11px] text-stone-400 pt-3 border-t border-[#E5E1D5] mt-4">Tracks homepage, case studies, CV views.</p>
        </div>

        <!-- 2. Traffic Sources / Referrers -->
        <div class="rounded-2xl border border-[#E5E1D5] bg-white p-5 sm:p-6 shadow-xs flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between pb-3 border-b border-[#E5E1D5] mb-4">
                    <h3 class="text-sm font-bold text-stone-900">Traffic Inflow Sources</h3>
                    <span class="text-[10px] font-mono uppercase tracking-wider text-stone-400">Referrers</span>
                </div>
                <div class="space-y-3">
                    @forelse($topReferrers as $ref)
                        @php($pct = $totalVisits > 0 ? round(($ref->total / $totalVisits) * 100) : 0)
                        <div>
                            <div class="flex items-center justify-between text-xs mb-1">
                                <span class="font-semibold text-stone-900 flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full {{ in_array($ref->referer_host, ['LinkedIn', 'GitHub', 'Google Search']) ? 'bg-emerald-500' : 'bg-stone-400' }}"></span>
                                    <span>{{ $ref->clean_referer }}</span>
                                </span>
                                <span class="font-mono font-bold text-stone-700">{{ $ref->total }} ({{ $pct }}%)</span>
                            </div>
                            <div class="h-1.5 rounded-full bg-stone-100 overflow-hidden">
                                <div class="h-full bg-emerald-500 rounded-full" style="width: {{ max(6, $pct) }}%"></div>
                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-stone-400 py-4 text-center">No referrers logged yet.</p>
                    @endforelse
                </div>
            </div>
            <p class="text-[11px] text-stone-400 pt-3 border-t border-[#E5E1D5] mt-4">Detects LinkedIn, GitHub, Google, direct.</p>
        </div>

        <!-- 3. Devices & Browsers -->
        <div class="rounded-2xl border border-[#E5E1D5] bg-white p-5 sm:p-6 shadow-xs flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between pb-3 border-b border-[#E5E1D5] mb-4">
                    <h3 class="text-sm font-bold text-stone-900">Devices &amp; Browsers</h3>
                    <span class="text-[10px] font-mono uppercase tracking-wider text-stone-400">Share</span>
                </div>
                <div class="space-y-3">
                    <p class="text-[11px] font-mono uppercase tracking-wider text-stone-400">Devices:</p>
                    <div class="flex flex-wrap gap-2">
                        @forelse($deviceStats as $d)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl bg-stone-100 text-xs font-semibold text-stone-800">
                                <span>{{ $d->device_type }}</span>
                                <strong class="font-mono text-[#B85D19]">({{ $d->total }})</strong>
                            </span>
                        @empty
                            <span class="text-xs text-stone-400">No device data yet.</span>
                        @endforelse
                    </div>

                    <p class="text-[11px] font-mono uppercase tracking-wider text-stone-400 pt-2">Top Browsers:</p>
                    <div class="space-y-1.5">
                        @foreach($browserStats as $b)
                            <div class="flex items-center justify-between text-xs">
                                <span class="text-stone-700">{{ $b->browser }}</span>
                                <span class="font-mono font-semibold text-stone-900">{{ $b->total }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <p class="text-[11px] text-stone-400 pt-3 border-t border-[#E5E1D5] mt-4">Mobile vs Desktop optimization intelligence.</p>
        </div>
    </div>

    <!-- Filters Bar -->
    <div class="rounded-2xl border border-[#E5E1D5] bg-white p-4 shadow-xs">
        <form method="GET" action="{{ route('admin.analytics.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-center">
            <div class="sm:col-span-5">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by IP, page URL, location (city/country), browser..." class="admin-input text-xs w-full">
            </div>

            <div class="sm:col-span-3">
                <select name="device" class="admin-input text-xs w-full">
                    <option value="all">All Devices</option>
                    <option value="Desktop" {{ request('device') === 'Desktop' ? 'selected' : '' }}>Desktop</option>
                    <option value="Mobile" {{ request('device') === 'Mobile' ? 'selected' : '' }}>Mobile</option>
                    <option value="Tablet" {{ request('device') === 'Tablet' ? 'selected' : '' }}>Tablet</option>
                    <option value="Bot / Crawler" {{ request('device') === 'Bot / Crawler' ? 'selected' : '' }}>Bot / Crawler</option>
                </select>
            </div>

            <div class="sm:col-span-2">
                <input type="date" name="date" value="{{ request('date') }}" class="admin-input text-xs w-full">
            </div>

            <div class="sm:col-span-2 flex items-center gap-2">
                <button type="submit" class="admin-btn-primary text-xs w-full justify-center">Filter</button>
                @if(request()->filled('search') || request()->filled('device') || request()->filled('date'))
                    <a href="{{ route('admin.analytics.index') }}" class="admin-btn-secondary text-xs" title="Reset filters">Reset</a>
                @endif
            </div>
        </form>
    </div>

    <!-- Detailed Live Visitor Logs Table -->
    <div class="rounded-2xl border border-[#E5E1D5] bg-white shadow-xs overflow-hidden">
        <div class="px-5 py-4 border-b border-[#E5E1D5] flex items-center justify-between">
            <h3 class="text-sm font-bold text-stone-900">Recent Visitor Log Entries ({{ $logs->total() }})</h3>
            <span class="text-xs text-stone-400">Auto-logged on public page requests</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-[#FAF9F5] border-b border-[#E5E1D5] text-stone-500 font-mono uppercase tracking-wider text-[10px]">
                    <tr>
                        <th class="py-3 px-4">Time</th>
                        <th class="py-3 px-4">Visitor / IP</th>
                        <th class="py-3 px-4">Location</th>
                        <th class="py-3 px-4">Page Viewed</th>
                        <th class="py-3 px-4">Source / Referrer</th>
                        <th class="py-3 px-4">Device &amp; OS</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E5E1D5]">
                    @forelse($logs as $log)
                        <tr class="hover:bg-stone-50/70 transition-colors">
                            <td class="py-3 px-4 whitespace-nowrap">
                                <span class="font-semibold text-stone-900 block">{{ $log->created_at->diffForHumans() }}</span>
                                <span class="text-[10px] font-mono text-stone-400">{{ $log->created_at->format('M d, H:i:s') }}</span>
                            </td>
                            <td class="py-3 px-4 whitespace-nowrap">
                                <span class="font-mono font-bold text-stone-800">{{ $log->ip_address }}</span>
                                @if($log->is_bot)
                                    <span class="ml-1 px-1.5 py-0.5 rounded text-[10px] bg-amber-100 text-amber-800 font-bold">BOT</span>
                                @endif
                            </td>
                            <td class="py-3 px-4 whitespace-nowrap">
                                <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full bg-stone-100 text-stone-700 text-[11px] font-medium">
                                    <span>📍</span>
                                    <span>{{ $log->location_label }}</span>
                                </span>
                            </td>
                            <td class="py-3 px-4">
                                <a href="{{ $log->page_url }}" target="_blank" class="font-semibold text-stone-900 hover:text-[#B85D19] transition-colors truncate block max-w-xs" title="{{ $log->page_url }}">
                                    {{ $log->page_title ?: parse_url($log->page_url, PHP_URL_PATH) }}
                                </a>
                                <span class="text-[10px] font-mono text-stone-400 truncate block max-w-xs">{{ parse_url($log->page_url, PHP_URL_PATH) ?: '/' }}</span>
                            </td>
                            <td class="py-3 px-4 whitespace-nowrap">
                                @if($log->referer_host && $log->referer_host !== 'Direct / None')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold {{ in_array($log->referer_host, ['LinkedIn', 'GitHub', 'Google Search']) ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-blue-50 text-blue-700 border border-blue-200' }}">
                                        {{ $log->clean_referer }}
                                    </span>
                                @else
                                    <span class="text-stone-400 text-[11px]">Direct</span>
                                @endif
                            </td>
                            <td class="py-3 px-4 whitespace-nowrap">
                                <div class="flex items-center gap-1.5">
                                    <span class="px-2 py-0.5 rounded-md bg-stone-100 text-stone-700 font-semibold text-[11px]">
                                        {{ $log->device_type }}
                                    </span>
                                    <span class="text-stone-500 text-[11px]">
                                        {{ $log->browser }} ({{ $log->os }})
                                    </span>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-stone-400">
                                <svg class="w-8 h-8 mx-auto mb-2 text-stone-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                <span>No visitor records match your filter criteria.</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($logs->hasPages())
            <div class="px-5 py-4 border-t border-[#E5E1D5]">
                {{ $logs->links() }}
            </div>
        @endif
    </div>

</div>
@endsection

