@extends('public.layouts.app')

@section('title', ($project->seo_title ?: $project->title) . ' - ' . $websiteName)
@section('meta_description', $project->seo_description ?: ($project->short_description ?? Str::limit(strip_tags($project->description), 160)))
@section('og_title', $project->og_title ?: $project->title)
@section('og_description', $project->og_description ?: ($project->short_description ?? Str::limit(strip_tags($project->description), 160)))
@section('og_image', $project->og_image_url ?: $project->thumbnail_url)
@section('canonical', $project->canonical_url ?: url()->current())
@section('meta_robots', $project->no_index ? 'noindex, nofollow' : 'index, follow')

@section('content')
<section class="min-h-screen pt-28 sm:pt-36 pb-24 bg-[var(--theme-bg-canvas)] text-[var(--theme-text-heading)] relative overflow-hidden transition-colors duration-200">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10 max-w-7xl 2xl:max-w-[1400px]">
        <div class="max-w-4xl mx-auto">
            <!-- Top Navigation & Breadcrumbs -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-8 pb-4 border-b border-[var(--theme-border)]">
                <a href="{{ route('projects') }}" class="text-brand hover:underline font-semibold text-xs sm:text-sm inline-flex items-center gap-2 group transition-colors">
                    <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    <span>Back to All Projects</span>
                </a>

                <nav class="flex items-center gap-2 text-xs font-mono text-[var(--theme-text-muted)]" aria-label="Breadcrumb">
                    <a href="{{ route('home') }}" class="hover:text-brand transition-colors">Home</a>
                    <span>/</span>
                    <a href="{{ route('projects') }}" class="hover:text-brand transition-colors">Projects</a>
                    <span>/</span>
                    <span class="text-brand font-semibold truncate max-w-[180px] sm:max-w-xs">{{ $project->title }}</span>
                </nav>
            </div>

            <!-- Category & Status Badges -->
            <div class="flex flex-wrap items-center gap-2.5 mb-4">
                <span class="text-xs px-3.5 py-1 badge-brand text-brand font-bold rounded-full shadow-2xs">
                    {{ $project->category ?? 'Case Study' }}
                </span>
                @if($project->is_featured)
                    <span class="text-xs px-3.5 py-1 badge-brand text-brand font-bold rounded-full shadow-2xs">
                        ★ Featured Engineering Case Study
                    </span>
                @endif
                <span class="text-xs px-3 py-1 bg-[var(--theme-bg-alt)] border border-[var(--theme-border)] text-[var(--theme-text-muted)] rounded-full font-mono">
                    Production Architecture
                </span>
            </div>

            <!-- Project Title & Subtitle -->
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-[var(--theme-text-heading)] tracking-tight mb-4">
                {{ $project->title }}
            </h1>

            @if($project->short_description)
                <p class="text-base sm:text-lg text-[var(--theme-text-body)] leading-relaxed mb-8">{{ $project->short_description }}</p>
            @endif

            <!-- Live Demo & Code Actions -->
            <div class="flex flex-wrap items-center gap-3.5 mb-10">
                @if($project->public_demo_url)
                    <a href="{{ $project->public_demo_url }}" target="_blank" rel="noopener noreferrer"
                        class="theme-btn-primary inline-flex items-center gap-2 px-6 py-3 rounded-full font-semibold text-xs sm:text-sm shadow-sm transition-all hover:scale-[1.02]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                        </svg>
                        <span>Live Demo ↗</span>
                    </a>
                @endif

                @if($project->github_url)
                    <a href="{{ $project->github_url }}" target="_blank" rel="noopener noreferrer"
                        class="theme-btn-secondary inline-flex items-center gap-2 px-6 py-3 rounded-full font-semibold text-xs sm:text-sm border transition-all">
                        <svg class="w-4 h-4 text-brand" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"/>
                        </svg>
                        <span>View Source Code ↗</span>
                    </a>
                @endif

                <a href="{{ route('contact', ['project' => $project->slug]) }}"
                    class="theme-btn-secondary inline-flex items-center gap-2 px-6 py-3 rounded-full font-semibold text-xs sm:text-sm border transition-all">
                    <span>Inquire About Similar Architecture</span>
                    <svg class="w-4 h-4 ml-0.5 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
            </div>

            <!-- Featured Thumbnail / Mockup Window -->
            @if($project->thumbnail_url)
                <div class="mb-10 rounded-3xl overflow-hidden border border-[var(--theme-border)] shadow-xs bg-[var(--theme-bg-alt)]">
                    <div class="px-4 py-3 bg-[var(--theme-bg-card)] border-b border-[var(--theme-border)] flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-red-500/80"></span>
                            <span class="w-3 h-3 rounded-full bg-amber-500/80"></span>
                            <span class="w-3 h-3 rounded-full bg-emerald-500/80"></span>
                            <span class="text-xs font-mono text-[var(--theme-text-muted)] ml-2 truncate">{{ $project->title }}</span>
                        </div>
                        <div class="text-[11px] font-mono text-brand font-bold hidden sm:inline">
                            ● 200 OK
                        </div>
                    </div>
                    <img src="{{ $project->thumbnail_url }}" alt="{{ $project->title }}"
                        class="w-full h-auto aspect-video object-cover">
                </div>
            @endif

            <!-- Quick Specs Matrix -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-10">
                <div class="p-4 rounded-2xl bg-[var(--theme-bg-card)] border border-[var(--theme-border)] shadow-xs">
                    <span class="text-[11px] font-mono uppercase tracking-wider text-[var(--theme-text-muted)] block mb-1">Engineering Role</span>
                    <span class="text-sm font-bold text-[var(--theme-text-heading)]">{{ $project->role ?: 'Lead Full Stack' }}</span>
                </div>
                <div class="p-4 rounded-2xl bg-[var(--theme-bg-card)] border border-[var(--theme-border)] shadow-xs">
                    <span class="text-[11px] font-mono uppercase tracking-wider text-[var(--theme-text-muted)] block mb-1">Domain &amp; Field</span>
                    <span class="text-sm font-bold text-brand">{{ $project->category ?? 'Web Application' }}</span>
                </div>
                <div class="p-4 rounded-2xl bg-[var(--theme-bg-card)] border border-[var(--theme-border)] shadow-xs">
                    <span class="text-[11px] font-mono uppercase tracking-wider text-[var(--theme-text-muted)] block mb-1">Architecture</span>
                    <span class="text-sm font-bold text-brand">Clean MVC / REST</span>
                </div>
                <div class="p-4 rounded-2xl bg-[var(--theme-bg-card)] border border-[var(--theme-border)] shadow-xs">
                    <span class="text-[11px] font-mono uppercase tracking-wider text-[var(--theme-text-muted)] block mb-1">Delivery Status</span>
                    <span class="text-sm font-bold text-[var(--theme-text-heading)] flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        Production
                    </span>
                </div>
            </div>

            <!-- Technologies & Architecture Stack -->
            @if($project->tech_stack && is_array($project->tech_stack))
                <div class="mb-10 bg-[var(--theme-bg-card)] rounded-3xl border border-[var(--theme-border)] p-6 sm:p-7 shadow-xs">
                    <h3 class="text-xs font-mono font-bold text-brand mb-3.5 uppercase tracking-wider flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
                        <span>Core Technologies &amp; Production Tooling</span>
                    </h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($project->tech_stack as $tech)
                            <span class="px-3.5 py-1.5 bg-[var(--theme-bg-alt)] text-[var(--theme-text-heading)] border border-[var(--theme-border)] rounded-xl text-xs sm:text-sm font-mono font-medium">
                                {{ $tech }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Problem Solved & Purpose -->
            @if($project->purpose)
                <div class="mb-10 bg-[var(--theme-bg-card)] rounded-3xl border border-[var(--theme-border)] p-6 sm:p-8 shadow-xs">
                    <h3 class="text-xl font-bold text-[var(--theme-text-heading)] mb-3 flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-xl bg-brand/10 text-brand flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <span>Problem Solved &amp; Project Purpose</span>
                    </h3>
                    <div class="text-[var(--theme-text-body)] text-sm sm:text-base leading-relaxed pl-0 sm:pl-10 space-y-2">
                        {!! nl2br(e($project->purpose)) !!}
                    </div>
                </div>
            @endif

            <!-- Role & Contribution -->
            @if($project->role)
                <div class="mb-10 bg-[var(--theme-bg-card)] rounded-3xl border border-[var(--theme-border)] p-6 sm:p-8 shadow-xs">
                    <h3 class="text-xl font-bold text-[var(--theme-text-heading)] mb-3 flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-xl bg-brand/10 text-brand flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <span>My Role &amp; Key Responsibilities</span>
                    </h3>
                    <div class="text-[var(--theme-text-body)] text-sm sm:text-base leading-relaxed pl-0 sm:pl-10 space-y-2">
                        {!! nl2br(e($project->role)) !!}
                    </div>
                </div>
            @endif

            <!-- Key Features Grid -->
            @if($project->key_features)
                <div class="mb-10 bg-[var(--theme-bg-card)] rounded-3xl border border-[var(--theme-border)] p-6 sm:p-8 shadow-xs">
                    <h3 class="text-xl font-bold text-[var(--theme-text-heading)] mb-5 flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-xl bg-brand/10 text-brand flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <span>Key Engineered Features</span>
                    </h3>
                    @php
                        $features = is_string($project->key_features) ? (str_contains($project->key_features, "\n") ? explode("\n", $project->key_features) : explode('|', $project->key_features)) : (is_array($project->key_features) ? $project->key_features : []);
                    @endphp
                    <ul class="grid grid-cols-1 md:grid-cols-2 gap-3.5">
                        @foreach($features as $feature)
                            @if(trim($feature))
                                <li class="flex items-start gap-3 p-3.5 rounded-2xl bg-[var(--theme-bg-alt)] border border-[var(--theme-border)]">
                                    <div class="w-5 h-5 rounded-full bg-brand/10 text-brand flex items-center justify-center shrink-0 mt-0.5">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                    <span class="text-[var(--theme-text-heading)] text-xs sm:text-sm font-medium leading-relaxed">{{ trim($feature) }}</span>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Challenges & Solutions Side-by-Side Comparison -->
            @if($project->challenges || $project->solutions)
                <div class="mb-10 grid grid-cols-1 md:grid-cols-2 gap-6">
                    @if($project->challenges)
                        <div class="bg-[var(--theme-bg-card)] border border-amber-500/30 rounded-3xl p-6 sm:p-7 shadow-xs">
                            <div class="flex items-center gap-2 mb-3.5">
                                <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>
                                <h3 class="text-base sm:text-lg font-bold text-[var(--theme-text-heading)]">Technical Bottlenecks</h3>
                            </div>
                            <div class="text-[var(--theme-text-body)] text-sm leading-relaxed space-y-2">
                                {!! nl2br(e($project->challenges)) !!}
                            </div>
                        </div>
                    @endif
                    @if($project->solutions)
                        <div class="bg-[var(--theme-bg-card)] border border-brand/30 rounded-3xl p-6 sm:p-7 shadow-xs">
                            <div class="flex items-center gap-2 mb-3.5">
                                <span class="w-2.5 h-2.5 rounded-full bg-brand"></span>
                                <h3 class="text-base sm:text-lg font-bold text-[var(--theme-text-heading)]">Architectural Solutions</h3>
                            </div>
                            <div class="text-[var(--theme-text-body)] text-sm leading-relaxed space-y-2">
                                {!! nl2br(e($project->solutions)) !!}
                            </div>
                        </div>
                    @endif
                </div>
            @endif

            <!-- Detailed Description / Implementation -->
            @if($project->description)
                <div class="mb-10 bg-[var(--theme-bg-card)] rounded-3xl border border-[var(--theme-border)] p-6 sm:p-8 shadow-xs">
                    <h3 class="text-xl font-bold text-[var(--theme-text-heading)] mb-4">Implementation Overview</h3>
                    <div class="text-[var(--theme-text-body)] text-sm sm:text-base leading-relaxed space-y-3">
                        {!! nl2br(e($project->description)) !!}
                    </div>
                </div>
            @endif

            <!-- Screenshots Gallery with Interactive Lightbox -->
            @if($project->screenshots && $project->screenshots->isNotEmpty())
                <div x-data="{
                    activeImage: null,
                    activeCaption: '',
                    openModal(url, caption) {
                        this.activeImage = url;
                        this.activeCaption = caption;
                    },
                    closeModal() {
                        this.activeImage = null;
                        this.activeCaption = '';
                    }
                }" class="mb-12">
                    <h3 class="text-xl font-bold text-[var(--theme-text-heading)] mb-6 flex items-center justify-between">
                        <span>Production Interface Gallery</span>
                        <span class="text-xs font-mono text-[var(--theme-text-muted)] font-normal">Click to enlarge</span>
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        @foreach($project->screenshots as $screenshot)
                            <div @click="openModal('{{ $screenshot->image_url }}', '{{ $screenshot->caption ?? $project->title }}')"
                                class="group relative rounded-2xl overflow-hidden border border-[var(--theme-border)] bg-[var(--theme-bg-alt)] cursor-pointer shadow-xs">
                                <div class="aspect-[16/10] overflow-hidden">
                                    <img src="{{ $screenshot->image_url }}" alt="{{ $screenshot->caption ?? $project->title }}" loading="lazy" decoding="async"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                </div>
                                @if($screenshot->caption)
                                    <div class="p-3 bg-[var(--theme-bg-card)] border-t border-[var(--theme-border)] text-xs text-[var(--theme-text-muted)] truncate">
                                        {{ $screenshot->caption }}
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <!-- Modal Lightbox -->
                    <div x-cloak x-show="activeImage" @click="closeModal()" x-transition.opacity
                        class="fixed inset-0 z-50 bg-black/85 backdrop-blur-md flex items-center justify-center p-4">
                        <div @click.stop class="max-w-5xl max-h-[90vh] flex flex-col items-center">
                            <img :src="activeImage" :alt="activeCaption" class="max-w-full max-h-[80vh] object-contain rounded-2xl shadow-2xl border border-white/10">
                            <p x-show="activeCaption" x-text="activeCaption" class="mt-3 text-xs sm:text-sm text-white font-medium text-center bg-black/80 px-4 py-1.5 rounded-full border border-white/10 shadow-lg"></p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Explore Other Case Studies -->
            @if(isset($relatedProjects) && $relatedProjects->isNotEmpty())
                <div class="mb-14 pt-10 border-t border-[var(--theme-border)]">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg sm:text-xl font-bold text-[var(--theme-text-heading)]">More Engineering Case Studies</h3>
                        <a href="{{ route('projects') }}" class="text-xs sm:text-sm font-semibold text-brand hover:underline transition-colors">View All &rarr;</a>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        @foreach($relatedProjects as $rel)
                            <a href="{{ route('projects.show', $rel->slug) }}" class="group bg-[var(--theme-bg-card)] rounded-3xl p-5 sm:p-6 border border-[var(--theme-border)] hover:border-brand/40 transition-all flex flex-col justify-between shadow-xs">
                                <div>
                                    <span class="text-[10px] font-mono font-bold uppercase tracking-wider text-brand badge-brand px-2 py-0.5 rounded-full mb-2 inline-block">
                                        {{ $rel->category ?? 'Project' }}
                                    </span>
                                    <h4 class="text-base font-bold text-[var(--theme-text-heading)] group-hover:text-brand transition-colors mb-2">{{ $rel->title }}</h4>
                                    <p class="text-[var(--theme-text-muted)] text-xs line-clamp-2">{{ $rel->short_description ?? Str::limit(strip_tags($rel->description), 100) }}</p>
                                </div>
                                <div class="mt-4 pt-3 border-t border-[var(--theme-border)] flex items-center justify-between text-xs font-semibold text-brand">
                                    <span>Read Case Study</span>
                                    <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Inquire CTA Box -->
            <div class="p-8 sm:p-12 rounded-3xl bg-[var(--theme-bg-card)] border border-[var(--theme-border)] shadow-xs text-center relative overflow-hidden">
                <span class="inline-block text-xs font-bold uppercase tracking-wider text-brand badge-brand px-3.5 py-1 rounded-full mb-3 shadow-2xs">Need Similar Engineering?</span>
                <h3 class="text-2xl sm:text-3xl font-bold text-[var(--theme-text-heading)] mb-3">Have a project with similar technical requirements?</h3>
                <p class="text-[var(--theme-text-body)] text-sm sm:text-base max-w-xl mx-auto mb-6 leading-relaxed">Let's discuss how we can build a scalable, reliable web application tailored to your business needs.</p>
                <div class="flex flex-wrap gap-3.5 justify-center">
                    <a href="{{ route('contact') }}"
                        class="theme-btn-primary inline-flex items-center gap-2 px-7 py-3.5 rounded-full font-semibold text-xs sm:text-sm transition-all shadow-sm hover:scale-[1.02]">
                        <span>Hire Me For Your Project</span>
                        <svg class="w-4 h-4 ml-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
