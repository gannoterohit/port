@extends('public.layouts.app')

@section('title', 'Featured Projects & Case Studies - ' . $websiteName)
@section('meta_description', 'Browse my portfolio of genuine web applications, client solutions, and full-stack software projects.')

@section('content')
<section class="min-h-screen pt-28 sm:pt-36 pb-24 bg-[#080C14] text-slate-100 relative overflow-hidden">
    <!-- Ambient Lighting & Dot Grid -->
    <div class="absolute inset-0 bg-grid-dots-dark opacity-35 pointer-events-none"></div>
    <div class="absolute -top-32 -left-20 w-[500px] h-[500px] bg-[#B85D19]/[0.05] dark:bg-[#E07A5F]/[0.05] rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute top-1/3 -right-20 w-[450px] h-[450px] bg-[#B85D19]/[0.03] dark:bg-[#E07A5F]/[0.04] rounded-full blur-3xl pointer-events-none"></div>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="max-w-7xl 2xl:max-w-[1400px] mx-auto">
            <!-- Header Section -->
            <div class="text-center mb-10">
                <span class="inline-block text-xs font-bold uppercase tracking-wider text-brand bg-emerald-500/10 border border-brand/30 px-3.5 py-1 rounded-full mb-3.5 shadow-xs">
                    Portfolio Showcase
                </span>
                <h1 class="text-4xl sm:text-5xl font-extrabold text-white tracking-tight mb-4">
                    Featured Projects &amp; Case Studies
                </h1>
                <p class="text-base sm:text-lg text-slate-400 max-w-2xl mx-auto leading-relaxed">
                    A curated selection of robust full-stack web applications, high-concurrency APIs, and production client platforms.
                </p>
            </div>

            <!-- Quick Engineering Metrics Strip -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3.5 max-w-4xl mx-auto mb-12">
                <div class="p-3.5 rounded-2xl bg-[#0D1526]/90 border border-black/10 dark:border-white/10 text-center shadow-lg hover:border-brand/30 transition-colors">
                    <span class="text-[11px] font-mono uppercase tracking-wider text-slate-400 block mb-1">Architecture</span>
                    <span class="text-base sm:text-lg font-bold text-white">Clean MVC &amp; APIs</span>
                </div>
                <div class="p-3.5 rounded-2xl bg-[#0D1526]/90 border border-black/10 dark:border-white/10 text-center shadow-lg hover:border-brand/30 transition-colors">
                    <span class="text-[11px] font-mono uppercase tracking-wider text-slate-400 block mb-1">Avg Response</span>
                    <span class="text-base sm:text-lg font-bold text-brand">&lt; 50ms</span>
                </div>
                <div class="p-3.5 rounded-2xl bg-[#0D1526]/90 border border-black/10 dark:border-white/10 text-center shadow-lg hover:border-brand/30 transition-colors">
                    <span class="text-[11px] font-mono uppercase tracking-wider text-slate-400 block mb-1">Production Uptime</span>
                    <span class="text-base sm:text-lg font-bold text-brand">99.9% High Availability</span>
                </div>
                <div class="p-3.5 rounded-2xl bg-[#0D1526]/90 border border-black/10 dark:border-white/10 text-center shadow-lg hover:border-brand/30 transition-colors">
                    <span class="text-[11px] font-mono uppercase tracking-wider text-slate-400 block mb-1">Engineering Quality</span>
                    <span class="text-base sm:text-lg font-bold text-brand">TDD &amp; PSR-12</span>
                </div>
            </div>

            <!-- Search & Interactive Category Filter Pills -->
            <div class="mb-12 space-y-6">
                <!-- Search Box -->
                <form method="GET" action="{{ route('projects') }}" class="max-w-2xl mx-auto flex gap-3 items-center">
                    @if(request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif
                    <div class="relative flex-1">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="search" name="search" value="{{ request('search') }}"
                            placeholder="Search by project name, tech stack (Laravel, MySQL, Redis)..."
                            class="w-full pl-11 pr-4 py-3.5 rounded-2xl border border-black/10 dark:border-white/10 bg-[#0D1526]/90 text-white placeholder-slate-400 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent shadow-lg transition-all">
                    </div>
                    <button type="submit"
                        class="theme-btn-primary inline-flex items-center justify-center px-6 py-3.5 rounded-2xl font-semibold text-sm transition-all shadow-sm shrink-0 hover:scale-[1.02]">
                        Search
                    </button>
                    @if(request()->filled('search') || request()->filled('category'))
                        <a href="{{ route('projects') }}"
                            class="inline-flex items-center justify-center px-4 py-3.5 rounded-2xl border border-slate-700 bg-slate-900/90 text-slate-300 hover:text-white text-sm font-medium transition-colors shadow-xs shrink-0"
                            title="Reset filters">
                            Clear
                        </a>
                    @endif
                </form>

                <!-- Category Filter Pills -->
                @if(isset($categories) && $categories->isNotEmpty())
                    <div class="flex flex-wrap items-center justify-center gap-2.5 pt-2">
                        <a href="{{ route('projects', array_filter(['search' => request('search')])) }}"
                            class="px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold transition-all duration-200 border {{ !request('category') ? 'bg-gradient-to-r from-emerald-600 to-teal-500 text-white border-brand/50 shadow-md shadow-emerald-500/20' : 'bg-slate-900/80 text-slate-300 border-black/10 dark:border-white/10 hover:border-slate-700 hover:text-white hover:bg-slate-800' }}">
                            All Projects
                        </a>
                        @foreach($categories as $cat)
                            <a href="{{ route('projects', array_filter(['category' => $cat, 'search' => request('search')])) }}"
                                class="px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold transition-all duration-200 border {{ request('category') === $cat ? 'bg-gradient-to-r from-emerald-600 to-teal-500 text-white border-brand/50 shadow-md shadow-emerald-500/20' : 'bg-slate-900/80 text-slate-300 border-black/10 dark:border-white/10 hover:border-slate-700 hover:text-white hover:bg-slate-800' }}">
                                {{ $cat }}
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- 3-Column Projects Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($projects as $project)
                    <div class="reveal-on-scroll stagger-{{ ($loop->index % 3) + 1 }} group bg-[#0F172A]/90 rounded-2xl overflow-hidden border border-black/10 dark:border-white/10 shadow-xl card-glow-hover flex flex-col">
                        <a href="{{ route('projects.show', ['project' => $project->slug]) }}" class="relative block overflow-hidden aspect-[16/9] bg-slate-950">
                            @if($project->thumbnail_url)
                                <img src="{{ $project->thumbnail_url }}" alt="{{ $project->thumbnail_alt ?: $project->title }}" width="403" height="227" loading="lazy" decoding="async"
                                    sizes="(min-width: 1024px) 403px, (min-width: 768px) 50vw, 100vw"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-400 bg-gradient-to-br from-slate-900 to-slate-950">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif

                            <!-- Interactive Hover Preview Glassmorphism Overlay -->
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/95 via-slate-950/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-between p-4 z-10 pointer-events-none">
                                <div class="flex items-center justify-between">
                                    <span class="inline-flex items-center gap-1.5 text-[11px] font-bold text-brand bg-slate-950/90 px-2.5 py-1 rounded-full border border-brand/30 shadow-md">
                                        <span class="w-1.5 h-1.5 rounded-full bg-brand animate-pulse"></span>
                                        Interactive Case Study
                                    </span>
                                </div>

                                <div class="flex items-center justify-center">
                                    <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-500 text-white font-bold text-xs shadow-xl shadow-emerald-500/30 transform translate-y-3 group-hover:translate-y-0 transition-transform duration-300">
                                        <span>Explore Case Study</span>
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                    </span>
                                </div>

                                <div class="text-[11px] font-mono text-slate-300 truncate">
                                    Role: {{ $project->role ?: 'Lead Developer' }}
                                </div>
                            </div>

                            <div class="absolute top-3 right-3 flex gap-2 z-20">
                                @if($project->is_featured)
                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-gradient-to-r from-emerald-600 to-teal-500 text-white shadow-xs">
                                        Featured
                                    </span>
                                @endif
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-slate-950/80 backdrop-blur-md text-brand border border-brand/30">
                                    {{ $project->category ?? 'Full Stack' }}
                                </span>
                            </div>
                        </a>

                        <div class="p-6 sm:p-7 flex-1 flex flex-col">
                            @php
                                $impactBadge = '⚡ High-Performance Architecture';
                                $lowerCat = strtolower(($project->category ?? '') . ' ' . $project->title);
                                if (str_contains($lowerCat, 'api')) {
                                    $impactBadge = '⚡ High Throughput & Sub-50ms API';
                                } elseif (str_contains($lowerCat, 'erp') || str_contains($lowerCat, 'admin') || str_contains($lowerCat, 'crm') || str_contains($lowerCat, 'panel')) {
                                    $impactBadge = '🔒 Role-Based ACL & Analytics';
                                } elseif (str_contains($lowerCat, 'e-com') || str_contains($lowerCat, 'shop') || str_contains($lowerCat, 'store')) {
                                    $impactBadge = '💳 Secure Payments & Order Engine';
                                } elseif (str_contains($lowerCat, 'community') || str_contains($lowerCat, 'social')) {
                                    $impactBadge = '🚀 Real-time Interactions & Feeds';
                                }
                            @endphp
                            <div class="mb-2">
                                <span class="inline-flex items-center gap-1.5 text-[11px] font-bold text-brand bg-teal-500/10 border border-teal-500/30 px-2.5 py-0.5 rounded-md shadow-xs">
                                    {{ $impactBadge }}
                                </span>
                            </div>

                            <h2 class="text-xl font-bold text-white mb-2 group-hover:text-brand transition-colors">
                                <a href="{{ route('projects.show', ['project' => $project->slug]) }}">
                                    {{ $project->title }}
                                </a>
                            </h2>

                            <p class="text-slate-400 text-sm mb-4 flex-1 line-clamp-3 leading-relaxed">
                                {{ $project->short_description ?? Str::limit(strip_tags($project->description), 140) }}
                            </p>

                            @if($project->tech_stack && is_array($project->tech_stack))
                                <div class="flex flex-wrap gap-1.5 mb-6">
                                    @foreach(array_slice($project->tech_stack, 0, 5) as $tech)
                                        <span class="text-xs px-2.5 py-1 bg-slate-800 text-slate-300 rounded-md font-medium border border-slate-700/60">
                                            {{ $tech }}
                                        </span>
                                    @endforeach
                                    @if(count($project->tech_stack) > 5)
                                        <span class="text-xs px-2 py-1 text-slate-400 font-medium">
                                            +{{ count($project->tech_stack) - 5 }}
                                        </span>
                                    @endif
                                </div>
                            @endif

                            <div class="pt-4 border-t border-black/10 dark:border-white/10 flex items-center justify-between mt-auto">
                                <a href="{{ route('projects.show', ['project' => $project->slug]) }}"
                                    aria-label="View details of {{ $project->title }}"
                                    class="inline-flex items-center gap-1.5 text-sm font-semibold text-brand hover:text-brand group-hover:underline">
                                    View Details
                                    <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>

                                <div class="flex items-center gap-3">
                                    @if($project->github_url)
                                        <a href="{{ $project->github_url }}" target="_blank" rel="noopener noreferrer"
                                            aria-label="GitHub source for {{ $project->title }}"
                                            class="text-slate-400 hover:text-brand transition-colors" title="View Source Code">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"/>
                                            </svg>
                                        </a>
                                    @endif
                                    @if($project->public_demo_url)
                                        <a href="{{ $project->public_demo_url }}" target="_blank" rel="noopener noreferrer"
                                            aria-label="Live preview of {{ $project->title }}"
                                            class="text-slate-400 hover:text-brand transition-colors" title="Live Preview">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                            </svg>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-16 bg-[#0F172A]/90 rounded-2xl border border-black/10 dark:border-white/10">
                        <svg class="w-16 h-16 text-slate-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        <h3 class="text-lg font-semibold text-white mb-1">No Projects Found</h3>
                        <p class="text-slate-400 text-sm">Check back soon for new case studies and project demonstrations.</p>
                    </div>
                @endforelse
            </div>

            @if($projects->hasPages())
                <div class="mt-12 flex justify-center">
                    {{ $projects->links() }}
                </div>
            @endif
        </div>
    </div>
</section>
@endsection
