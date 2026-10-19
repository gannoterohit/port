@extends('public.layouts.app')

@section('title', 'Featured Projects & Case Studies - ' . $websiteName)
@section('meta_description', 'Browse my portfolio of genuine web applications, client solutions, and full-stack software projects.')

@section('content')
<section class="min-h-0 sm:min-h-screen pt-24 sm:pt-36 pb-28 sm:pb-24 bg-[var(--theme-bg-canvas)] text-[var(--theme-text-heading)] relative overflow-hidden transition-colors duration-200">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10 max-w-7xl 2xl:max-w-[1400px]">
        <div class="max-w-7xl 2xl:max-w-[1400px] mx-auto">
            <!-- Header Section -->
            <div class="text-center mb-10">
                <span class="inline-block text-xs font-bold uppercase tracking-wider text-brand badge-brand px-3.5 py-1 rounded-full mb-3.5 shadow-2xs">
                    Portfolio Showcase
                </span>
                <h1 class="text-4xl sm:text-5xl font-extrabold text-[var(--theme-text-heading)] tracking-tight mb-4">
                    Featured Projects &amp; Case Studies
                </h1>
                <p class="text-base sm:text-lg text-[var(--theme-text-body)] max-w-2xl mx-auto leading-relaxed">
                    A curated selection of robust full-stack web applications, high-concurrency APIs, and production client platforms.
                </p>
            </div>

            <!-- Quick Engineering Metrics Strip -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3.5 max-w-4xl mx-auto mb-12">
                <div class="p-3.5 rounded-2xl bg-[var(--theme-bg-card)] border border-[var(--theme-border)] text-center shadow-xs">
                    <span class="text-[11px] font-mono uppercase tracking-wider text-[var(--theme-text-muted)] block mb-1">Architecture</span>
                    <span class="text-base sm:text-lg font-bold text-[var(--theme-text-heading)]">Clean MVC &amp; APIs</span>
                </div>
                <div class="p-3.5 rounded-2xl bg-[var(--theme-bg-card)] border border-[var(--theme-border)] text-center shadow-xs">
                    <span class="text-[11px] font-mono uppercase tracking-wider text-[var(--theme-text-muted)] block mb-1">Avg Response</span>
                    <span class="text-base sm:text-lg font-bold text-brand">&lt; 50ms</span>
                </div>
                <div class="p-3.5 rounded-2xl bg-[var(--theme-bg-card)] border border-[var(--theme-border)] text-center shadow-xs">
                    <span class="text-[11px] font-mono uppercase tracking-wider text-[var(--theme-text-muted)] block mb-1">Production Uptime</span>
                    <span class="text-base sm:text-lg font-bold text-brand">99.9% High Availability</span>
                </div>
                <div class="p-3.5 rounded-2xl bg-[var(--theme-bg-card)] border border-[var(--theme-border)] text-center shadow-xs">
                    <span class="text-[11px] font-mono uppercase tracking-wider text-[var(--theme-text-muted)] block mb-1">Engineering Quality</span>
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
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-[var(--theme-text-muted)]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="search" name="search" value="{{ request('search') }}"
                            placeholder="Search by project name, tech stack (Laravel, MySQL, Redis)..."
                            class="w-full pl-11 pr-4 py-3.5 rounded-2xl border border-[var(--theme-border)] bg-[var(--theme-bg-card)] text-[var(--theme-text-heading)] placeholder-[var(--theme-text-muted)] text-sm focus:outline-none focus:ring-2 focus:ring-brand/30 focus:border-transparent shadow-xs transition-all">
                    </div>
                    <button type="submit"
                        class="theme-btn-primary inline-flex items-center justify-center px-6 py-3.5 rounded-full font-semibold text-xs sm:text-sm transition-all shadow-sm shrink-0 hover:scale-[1.02]">
                        <span>Search</span>
                    </button>
                    @if(request()->filled('search') || request()->filled('category'))
                        <a href="{{ route('projects') }}"
                            class="theme-btn-secondary inline-flex items-center justify-center px-4 py-3.5 rounded-full border text-xs sm:text-sm font-medium transition-colors shrink-0"
                            title="Reset filters">
                            Clear
                        </a>
                    @endif
                </form>

                <!-- Category Filter Pills -->
                @if(isset($categories) && $categories->isNotEmpty())
                    <div class="flex flex-wrap items-center justify-center gap-2.5 pt-2">
                        <a href="{{ route('projects', array_filter(['search' => request('search')])) }}"
                            class="px-4 py-2 rounded-full text-xs sm:text-sm font-semibold transition-all duration-200 border {{ !request('category') ? 'theme-btn-primary' : 'theme-btn-secondary' }}">
                            All Projects
                        </a>
                        @foreach($categories as $cat)
                            <a href="{{ route('projects', array_filter(['category' => $cat, 'search' => request('search')])) }}"
                                class="px-4 py-2 rounded-full text-xs sm:text-sm font-semibold transition-all duration-200 border {{ request('category') === $cat ? 'theme-btn-primary' : 'theme-btn-secondary' }}">
                                {{ $cat }}
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- 3-Column Projects Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($projects as $project)
                    <div class="group bg-[var(--theme-bg-card)] rounded-3xl overflow-hidden border border-[var(--theme-border)] hover:border-brand/40 shadow-xs flex flex-col transition-all duration-300">
                        <a href="{{ route('projects.show', ['project' => $project->slug]) }}" class="relative block overflow-hidden aspect-[16/9] bg-[var(--theme-bg-alt)] border-b border-[var(--theme-border)]">
                            @if($project->thumbnail_url)
                                <img src="{{ $project->thumbnail_url }}" alt="{{ $project->thumbnail_alt ?: $project->title }}" width="403" height="227" loading="lazy" decoding="async"
                                    sizes="(min-width: 1024px) 403px, (min-width: 768px) 50vw, 100vw"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                    onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'w-full h-full flex flex-col items-center justify-center p-6 text-center bg-gradient-to-br from-brand/10 to-[var(--theme-bg-alt)]\'><span class=\'text-sm font-bold text-[var(--theme-text-heading)] mb-1\'>{{ addslashes($project->title) }}</span><span class=\'text-xs font-mono text-brand\'>{{ addslashes($project->category ?? 'Web Application') }}</span></div>';">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center text-[var(--theme-text-muted)] bg-gradient-to-br from-brand/10 to-[var(--theme-bg-alt)] p-6 text-center">
                                    <span class="text-sm font-bold text-[var(--theme-text-heading)] mb-1">{{ $project->title }}</span>
                                    <span class="text-xs font-mono text-brand">{{ $project->category ?? 'Web Application' }}</span>
                                </div>
                            @endif

                            <div class="absolute top-3 right-3 flex gap-2 z-20">
                                @if($project->is_featured)
                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-brand text-white shadow-2xs">
                                        Featured
                                    </span>
                                @endif
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-[var(--theme-bg-card)]/90 backdrop-blur-md text-[var(--theme-text-heading)] border border-[var(--theme-border)]">
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
                                <span class="inline-flex items-center gap-1.5 text-[11px] font-bold text-brand badge-brand px-2.5 py-0.5 rounded-md shadow-2xs">
                                    {{ $impactBadge }}
                                </span>
                            </div>

                            <h2 class="text-xl font-bold text-[var(--theme-text-heading)] mb-2 group-hover:text-brand transition-colors">
                                <a href="{{ route('projects.show', ['project' => $project->slug]) }}">
                                    {{ $project->title }}
                                </a>
                            </h2>

                            <p class="text-[var(--theme-text-body)] text-sm mb-4 flex-1 line-clamp-3 leading-relaxed">
                                {{ Str::limit($project->short_description ?: strip_tags($project->description), 120) }}
                            </p>

                            @if($project->tech_stack && is_array($project->tech_stack))
                                <div class="flex flex-wrap gap-1.5 mb-6">
                                    @foreach(array_slice($project->tech_stack, 0, 5) as $tech)
                                        <span class="text-xs px-2.5 py-1 bg-[var(--theme-bg-alt)] text-[var(--theme-text-body)] rounded-md font-mono font-medium border border-[var(--theme-border)]">
                                            {{ $tech }}
                                        </span>
                                    @endforeach
                                    @if(count($project->tech_stack) > 5)
                                        <span class="text-xs px-2 py-1 text-[var(--theme-text-muted)] font-mono font-medium">
                                            +{{ count($project->tech_stack) - 5 }}
                                        </span>
                                    @endif
                                </div>
                            @endif

                            <div class="pt-4 border-t border-[var(--theme-border)] flex items-center justify-between mt-auto">
                                <a href="{{ route('projects.show', ['project' => $project->slug]) }}"
                                    aria-label="View details of {{ $project->title }}"
                                    class="inline-flex items-center gap-1.5 text-xs sm:text-sm font-semibold text-[var(--theme-text-heading)] hover:text-brand group-hover:underline">
                                    <span>Case Study</span>
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                    </svg>
                                </a>

                                <div class="flex items-center gap-3">
                                    @if($project->github_url)
                                        <a href="{{ $project->github_url }}" target="_blank" rel="noopener noreferrer"
                                            aria-label="GitHub source for {{ $project->title }}"
                                            class="text-[var(--theme-text-muted)] hover:text-brand transition-colors" title="View Source Code">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"/>
                                            </svg>
                                        </a>
                                    @endif
                                    @if($project->public_demo_url)
                                        <a href="{{ $project->public_demo_url }}" target="_blank" rel="noopener noreferrer"
                                            aria-label="Live preview of {{ $project->title }}"
                                            class="text-[var(--theme-text-muted)] hover:text-brand transition-colors" title="Live Preview">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                            </svg>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-16 bg-[var(--theme-bg-card)] rounded-3xl border border-[var(--theme-border)]">
                        <h3 class="text-lg font-semibold text-[var(--theme-text-heading)] mb-1">No Projects Found</h3>
                        <p class="text-[var(--theme-text-muted)] text-sm">Check back soon for new case studies and project demonstrations.</p>
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
