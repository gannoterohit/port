@extends('public.layouts.app')

@section('title', ($homepageSettings->hero_heading ? $homepageSettings->hero_heading . ' - ' : ($profile->full_name . ' - ')) . $websiteName)
@section('meta_description', $homepageSettings->hero_description ?? (strip_tags($profile->bio) ?? ($profile->intro ?? 'Senior PHP & Laravel Backend Developer specializing in scalable REST APIs, MySQL query optimization, Redis queues, and resilient system architecture.')))

@php
    $heroPreloadImg = $homepageSettings->hero_image_url ?: ($profile->profile_photo_url ?? null);
@endphp

@if($heroPreloadImg)
@push('meta')
    <link rel="preload" as="image" href="{{ $heroPreloadImg }}" fetchpriority="high">
@endpush
@endif

@section('content')
@php
    // Strategic High-Converting Sequence for an Elite Backend Engineer
    $order = ['hero', 'skills_marquee', 'tech_stack_grid', 'projects', 'about', 'services', 'work_process', 'testimonials', 'contact_cta'];
@endphp

@foreach($order as $section)
    {{-- ========================================================
         HERO SECTION — MINIMALIST & MODERN EDITORIAL (LINEAR / APPLE STYLE)
         ======================================================== --}}
    @if($section === 'hero' && $homepageSettings->hero_section_enabled)
        @php
            $isAvailable = \App\Models\Setting::get('available_for_freelance', '1') === '1'
                || \App\Models\Setting::get('available_for_freelance', true) === true;
            $rawYears = \App\Models\Setting::get('years_experience') ?: '3+';
            $yearsDisplay = str_ends_with(trim($rawYears), '+') ? trim($rawYears) : trim($rawYears) . '+';
            $heroImg = $homepageSettings->hero_image_url ?: $profile->profile_photo_url;
            $contactEmail = $profile->contact_email ?: ($profile->email ?: null);
            $cvUrl = ($profile->resume_url && $profile->resume_button_visible) ? $profile->resume_url : '#contact';
        @endphp

        <section id="hero" class="relative pt-32 sm:pt-40 pb-20 sm:pb-28 bg-[var(--theme-bg-canvas)] border-b border-[var(--theme-border)] overflow-hidden transition-colors duration-200 min-h-[640px] lg:min-h-[720px] flex items-center">
            <!-- Ambient Spotlight Glow -->
            <div class="absolute top-1/4 right-1/4 w-[460px] h-[460px] rounded-full bg-brand/10 dark:bg-brand/15 blur-[130px] pointer-events-none"></div>

            <!-- Background Cinematic Workspace Image with High-Definition Sharpness -->
            <div class="absolute inset-y-0 right-0 w-full lg:w-[52%] xl:w-[55%] pointer-events-none overflow-hidden">
                <div class="w-full h-full animate-float">
                    <img src="{{ $homepageSettings->hero_image_url ?: (asset('images/hero-workspace.jpg') . '?v=' . (file_exists(public_path('images/hero-workspace.jpg')) ? filemtime(public_path('images/hero-workspace.jpg')) : time())) }}" 
                         alt="{{ $profile->name ?: 'Rohit Gannote' }} Workspace" 
                         class="w-full h-full object-cover object-center select-none brightness-[1.0] contrast-[1.02] dark:brightness-[0.82] dark:contrast-[1.08]">
                </div>
                
                <!-- Gentle Left Feather: seamlessly merges into background canvas without hazing the laptop -->
                <div class="hidden lg:block absolute inset-y-0 left-0 w-44 xl:w-60 bg-gradient-to-r from-[var(--theme-bg-canvas)] via-[var(--theme-bg-canvas)]/75 to-transparent"></div>
                
                <!-- Gentle Top & Bottom Edge Feathers for seamless header and section borders -->
                <div class="absolute inset-x-0 top-0 h-12 bg-gradient-to-b from-[var(--theme-bg-canvas)]/80 to-transparent"></div>
                <div class="absolute inset-x-0 bottom-0 h-10 bg-gradient-to-t from-[var(--theme-bg-canvas)]/80 to-transparent"></div>

                <!-- Mobile & Tablet Overlay to guarantee crisp text legibility -->
                <div class="lg:hidden absolute inset-0 bg-[var(--theme-bg-canvas)]/88"></div>
            </div>

            <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10 max-w-7xl 2xl:max-w-[1400px]">
                <div class="max-w-2xl text-left">
                    <!-- Greeting Pill Badge & Live Availability -->
                    <div class="flex items-center gap-2.5 mb-6 flex-wrap">
                        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-black/[0.04] dark:bg-white/10 border border-black/10 dark:border-white/15 text-xs sm:text-sm font-medium text-[var(--theme-text-heading)] shadow-2xs">
                            <span>Hello, I'm</span>
                            <span>👋</span>
                        </div>
                        @if($isAvailable)
                        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20 text-xs font-semibold tracking-wide shadow-2xs">
                            <span class="relative flex h-2 w-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                            </span>
                            <span>{{ \App\Models\Setting::get('terminal_status_text') ?: 'Available for Work & Remote Roles' }}</span>
                        </div>
                        @endif
                    </div>

                    @php
                        $profileName = $profile->name ?: 'Rohit Gannote';
                        $nameParts = explode(' ', $profileName, 2);
                        $firstName = $nameParts[0];
                        $lastName = $nameParts[1] ?? '';
                        $completedProjectsCount = \App\Models\Setting::get('projects_completed_count') ?: ((\App\Models\Project::where('status', 'published')->count() > 5) ? \App\Models\Project::where('status', 'published')->count() : 12);
                        $satisfactionRate = \App\Models\Setting::get('client_satisfaction_percentage', '100');
                    @endphp

                    <!-- Main Name Headline with Accent Color -->
                    <h1 class="text-3xl sm:text-5xl lg:text-6xl xl:text-[72px] font-extrabold tracking-tight text-[var(--theme-text-heading)] leading-[1.06] mb-2 sm:mb-3">
                        {{ $firstName }} @if($lastName)<span class="text-brand">{{ $lastName }}</span>@endif
                    </h1>

                    <!-- Role Subtitle (Sharp Backend Position) with Snappy Typewriter Animation -->
                    <div x-data="{
                            words: [
                                '{{ addslashes($profile->title ?: 'PHP / Laravel Backend Developer') }}',
                                'Scalable REST API Architect',
                                'MySQL & Database Optimization Specialist',
                                'Distributed Queues & Redis Engineer'
                            ],
                            part: '',
                            i: 0,
                            offset: 0,
                            forwards: true,
                            skipCount: 0,
                            skipDelay: 22,
                            speed: 55,
                            init() {
                                setInterval(() => {
                                    if (this.forwards) {
                                        if (this.offset >= this.words[this.i].length) {
                                            ++this.skipCount;
                                            if (this.skipCount === this.skipDelay) {
                                                this.forwards = false;
                                                this.skipCount = 0;
                                            }
                                        }
                                    } else {
                                        if (this.offset === 0) {
                                            this.forwards = true;
                                            this.i = (this.i + 1) % this.words.length;
                                            this.skipCount = 0;
                                        }
                                    }
                                    this.part = this.words[this.i].substring(0, this.offset);
                                    if (this.skipCount === 0) {
                                        if (this.forwards) {
                                            this.offset++;
                                        } else {
                                            this.offset--;
                                        }
                                    }
                                }, this.speed);
                            }
                        }"
                        class="text-xl sm:text-2xl lg:text-3xl xl:text-4xl font-bold text-[var(--theme-text-heading)] mb-2 tracking-tight flex items-center min-h-[44px]">
                        <span x-text="part || '{{ addslashes($profile->title ?: 'PHP / Laravel Backend Developer') }}'">{{ $profile->title ?: 'PHP / Laravel Backend Developer' }}</span>
                        <span class="inline-block w-0.5 h-6 sm:h-8 bg-brand ml-1.5 animate-pulse"></span>
                    </div>

                    @if($homepageSettings->hero_title || $profile->subtitle)
                        <div class="text-xs sm:text-sm lg:text-base font-mono text-brand font-semibold mb-4 sm:mb-6 tracking-wide">
                            {{ $homepageSettings->hero_title ?: $profile->subtitle }}
                        </div>
                    @endif

                    <!-- Description -->
                    <p class="text-sm sm:text-base lg:text-lg text-[var(--theme-text-body)] max-w-xl lg:max-w-[520px] xl:max-w-xl leading-relaxed mb-8 sm:mb-10 font-normal">
                        {{ $homepageSettings->hero_description ?: 'Engineering scalable, high-performance web backends using Laravel 11, PHP 8+, MySQL, and Redis. Specializing in query optimization, robust REST API architectures, asynchronous queues, and production reliability.' }}
                    </p>

                    @php
                        $formatCtaUrl = function (?string $rawUrl, string $fallback = '#') {
                            if (blank($rawUrl)) {
                                return $fallback;
                            }
                            $rawUrl = trim($rawUrl);
                            if (str_starts_with($rawUrl, '#') || str_starts_with($rawUrl, 'http://') || str_starts_with($rawUrl, 'https://')) {
                                return $rawUrl;
                            }
                            return url(ltrim($rawUrl, '/'));
                        };

                        $primaryCtaText = $homepageSettings->primary_cta_text ?: 'Hire Me';
                        $primaryCtaUrl = $formatCtaUrl($homepageSettings->primary_cta_url, '#contact');

                        $secondaryCtaText = $homepageSettings->secondary_cta_text ?: 'View My Projects';
                        $secondaryCtaUrl = $formatCtaUrl($homepageSettings->secondary_cta_url, '#projects');
                        $isResumeCta = Str::contains(strtolower($secondaryCtaText), ['resume', 'cv']);
                    @endphp

                    <!-- Action Buttons (100% Dynamic from Admin Panel) -->
                    <div class="flex flex-wrap items-center gap-2.5 sm:gap-4 mb-10 sm:mb-14">
                        <a href="{{ $primaryCtaUrl }}"
                            class="theme-btn-primary inline-flex items-center justify-center gap-2 px-5 sm:px-7 py-3 sm:py-3.5 font-semibold rounded-full hover:scale-[1.02] shadow-md transition-all duration-200 text-xs sm:text-sm lg:text-base">
                            <span>{{ $primaryCtaText }}</span>
                            <svg class="w-4 h-4 ml-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>

                        <a href="{{ $secondaryCtaUrl }}"
                            class="theme-btn-secondary inline-flex items-center justify-center gap-2 px-4 sm:px-6 py-3 sm:py-3.5 font-medium rounded-full border transition-all duration-200 text-xs sm:text-sm lg:text-base group"
                            title="{{ $secondaryCtaText }}">
                            @if($isResumeCta)
                                <svg class="w-4 h-4 text-brand transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            @else
                                <svg class="w-4 h-4 text-brand transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                                </svg>
                            @endif
                            <span>{{ $secondaryCtaText }}</span>
                        </a>

                        <a href="#contact"
                            class="theme-btn-secondary inline-flex items-center justify-center gap-2 px-4 sm:px-6 py-3 sm:py-3.5 font-medium rounded-full border transition-all duration-200 text-xs sm:text-sm lg:text-base">
                            <span>Get In Touch</span>
                            <svg class="w-4 h-4 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </a>
                    </div>

                    <!-- 3-Metric Row with Clean Standards -->
                    <div class="flex items-center gap-3.5 sm:gap-6 lg:gap-8 text-left pt-2 flex-wrap sm:flex-nowrap">
                        <div>
                            <div class="text-xl sm:text-2xl lg:text-3xl font-extrabold text-[var(--theme-text-heading)] tracking-tight">
                                <span class="stat-counter" data-target="{{ is_numeric(rtrim($yearsDisplay, '+')) ? rtrim($yearsDisplay, '+') : '3' }}" data-suffix="+">{{ $yearsDisplay }}</span>
                            </div>
                            <div class="text-[11px] sm:text-xs text-[var(--theme-text-muted)] mt-0.5 font-medium">Years Experience</div>
                        </div>
                        <div class="h-8 sm:h-9 w-px bg-[var(--theme-border)]"></div>
                        <div>
                            <div class="text-xl sm:text-2xl lg:text-3xl font-extrabold text-[var(--theme-text-heading)] tracking-tight">
                                <span class="stat-counter" data-target="{{ $completedProjectsCount }}" data-suffix="+">{{ $completedProjectsCount }}+</span>
                            </div>
                            <div class="text-[11px] sm:text-xs text-[var(--theme-text-muted)] mt-0.5 font-medium">Projects Completed</div>
                        </div>
                        <div class="h-8 sm:h-9 w-px bg-[var(--theme-border)]"></div>
                        <div>
                            <div class="text-xl sm:text-2xl lg:text-3xl font-extrabold text-[var(--theme-text-heading)] tracking-tight">
                                <span class="stat-counter" data-target="{{ $satisfactionRate }}" data-suffix="%">{{ $satisfactionRate }}%</span>
                            </div>
                            <div class="text-[11px] sm:text-xs text-[var(--theme-text-muted)] mt-0.5 font-medium">Production Reliability</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- ========================================================
         TECH STACK MARQUEE — QUIET & CLEAN
         ======================================================== --}}
    @if($section === 'skills_marquee' && isset($skills) && $skills->isNotEmpty())
        <section class="py-5 bg-[var(--theme-bg-alt)] border-b border-[var(--theme-border)] overflow-hidden" aria-label="Core Technologies">
            <div class="marquee-mask relative w-full overflow-hidden">
                <div class="animate-marquee hover:[animation-play-state:paused] flex items-center gap-4 sm:gap-6">
                    @for($repeat = 0; $repeat < 2; $repeat++)
                        @foreach($skills as $skill)
                            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-[var(--theme-bg-card)] border border-[var(--theme-border)] text-xs font-medium text-[var(--theme-text-body)] hover:text-[var(--theme-text-heading)] hover:border-brand/40 transition-all shrink-0">
                                <span class="w-1.5 h-1.5 rounded-full bg-brand"></span>
                                <span class="text-[var(--theme-text-heading)] font-semibold">{{ $skill->name }}</span>
                            </div>
                        @endforeach
                    @endfor
                </div>
            </div>
        </section>
    @endif

    {{-- ========================================================
         CORE BACKEND ARCHITECTURE & TECH STACK GRID (HIGH-IMPACT)
         ======================================================== --}}
    @if($section === 'tech_stack_grid' && $homepageSettings->skills_section_enabled)
        <section id="tech-stack" class="py-20 sm:py-24 bg-[var(--theme-bg-canvas)] border-b border-[var(--theme-border)] relative">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl 2xl:max-w-[1400px]">
                <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-14">
                    <div>
                        <span class="text-xs font-mono uppercase tracking-widest text-brand font-semibold mb-2 block">
                            01 / Technical Competencies
                        </span>
                        <h2 class="text-3xl sm:text-4xl font-extrabold text-[var(--theme-text-heading)] tracking-tight">
                            Core Backend Architecture &amp; Stack
                        </h2>
                        <p class="text-[var(--theme-text-muted)] text-base mt-2 max-w-xl">
                            Curated tools and engineering practices applied to build resilient APIs, high-throughput database layers, and scalable cloud systems.
                        </p>
                    </div>
                    <div class="mt-4 sm:mt-0">
                        <a href="{{ route('skills') }}"
                            class="theme-btn-secondary inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs sm:text-sm font-medium border transition-all">
                            <span>Browse Comprehensive Matrix ({{ \App\Models\Skill::where('is_enabled', true)->count() }} Skills)</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    </div>
                </div>

                <!-- 100% Dynamic Backend Matrix from Admin (Skill Categories & Skills) -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @forelse($skillCategories as $cat)
                        @if($cat->skills->isNotEmpty())
                            <div class="p-6 sm:p-7 rounded-3xl bg-[var(--theme-bg-card)] border border-[var(--theme-border)] hover:border-brand/40 shadow-xs hover:shadow-lg hover:-translate-y-1.5 transition-all duration-300 flex flex-col justify-between">
                                <div>
                                    <div class="w-10 h-10 rounded-2xl bg-brand/10 text-brand flex items-center justify-center font-mono font-bold text-sm mb-4">
                                        0{{ $loop->iteration }}
                                    </div>
                                    <h3 class="text-lg font-bold text-[var(--theme-text-heading)] mb-2">{{ $cat->name }}</h3>
                                    <p class="text-xs text-[var(--theme-text-body)] leading-relaxed mb-5">
                                        {{ $cat->description ?: 'Core engineering tools, frameworks, and architecture patterns applied across production.' }}
                                    </p>
                                    <div class="flex flex-wrap gap-1.5 mb-4">
                                        @foreach($cat->skills as $sk)
                                            <span class="text-[11px] font-mono px-2.5 py-1 rounded-md bg-[var(--theme-bg-alt)] border border-[var(--theme-border)] hover:border-brand/40 hover:scale-105 transition-all duration-150 cursor-default {{ $sk->is_featured ? 'font-semibold text-[var(--theme-text-heading)]' : 'text-[var(--theme-text-body)]' }}">
                                                {{ $sk->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="pt-4 border-t border-[var(--theme-border)] text-[11px] font-mono text-[var(--theme-text-muted)] flex items-center justify-between">
                                    <span>{{ $cat->skills->count() }} {{ Str::plural('Skill', $cat->skills->count()) }}</span>
                                    <span class="text-brand font-medium">Active Stack</span>
                                </div>
                            </div>
                        @endif
                    @empty
                        <div class="col-span-full text-center py-10 bg-[var(--theme-bg-card)] rounded-3xl border border-[var(--theme-border)]">
                            <p class="text-sm text-[var(--theme-text-muted)]">No skills published yet. Manage them via Admin Panel ➔ Skills.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>
    @endif

    {{-- ========================================================
         PROJECTS SECTION — CLEAN 2-COLUMN EDITORIAL SHOWCASE
         ======================================================== --}}
    @if($section === 'projects' && $homepageSettings->projects_section_enabled && $featuredProjects->isNotEmpty())
        <section id="projects" class="py-20 sm:py-28 bg-[var(--theme-bg-canvas)] border-b border-[var(--theme-border)] relative">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl 2xl:max-w-[1400px]">
                
                <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-14">
                    <div>
                        <span class="text-xs font-mono uppercase tracking-widest text-brand font-semibold mb-2 block">
                            02 / Featured Case Studies
                        </span>
                        <h2 class="text-3xl sm:text-4xl font-extrabold text-[var(--theme-text-heading)] tracking-tight">
                            Commercial Backend Systems
                        </h2>
                        <p class="text-[var(--theme-text-muted)] text-base mt-2 max-w-xl">
                            Real-world web backends, API platforms, and SaaS databases engineered for high concurrency, security, and low latency.
                        </p>
                    </div>
                    <div class="mt-4 sm:mt-0">
                        <a href="{{ route('projects') }}"
                            class="theme-btn-secondary inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs sm:text-sm font-medium border transition-all">
                            <span>Browse All Projects ({{ \App\Models\Project::where('status', 'published')->count() }})</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    </div>
                </div>

                <!-- Clean 2-Column Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 sm:gap-10">
                    @foreach($featuredProjects as $project)
                        <article class="tilt-card reveal-on-scroll group flex flex-col justify-between rounded-3xl bg-[var(--theme-bg-card)] border border-[var(--theme-border)] hover:border-brand/40 shadow-sm hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 overflow-hidden p-6 sm:p-7"
                            style="transition-delay: {{ $loop->index * 120 }}ms;">
                            <div>
                                <!-- Project Preview Image -->
                                <a href="{{ route('projects.show', $project->slug) }}" class="block aspect-[16/10] w-full rounded-2xl overflow-hidden bg-[var(--theme-bg-alt)] border border-[var(--theme-border)] mb-6 relative">
                                    @if($project->thumbnail_url)
                                        <img src="{{ $project->thumbnail_url }}" alt="{{ $project->title }}" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out"
                                             onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'w-full h-full flex flex-col items-center justify-center p-6 text-center bg-gradient-to-br from-brand/10 to-[var(--theme-bg-alt)]\'><span class=\'text-base font-bold text-[var(--theme-text-heading)] mb-1\'>{{ addslashes($project->title) }}</span><span class=\'text-xs font-mono text-brand\'>{{ addslashes($project->category ?? 'Web Application') }}</span></div>';">
                                    @else
                                        <div class="w-full h-full flex flex-col items-center justify-center text-[var(--theme-text-muted)] p-6 text-center bg-gradient-to-br from-brand/10 to-[var(--theme-bg-alt)]">
                                            <span class="text-base font-bold text-[var(--theme-text-heading)] mb-1">{{ $project->title }}</span>
                                            <span class="text-xs font-mono text-brand">{{ $project->category ?? 'Web Application' }}</span>
                                        </div>
                                    @endif
                                </a>

                                <!-- Metadata & Category -->
                                <div class="flex items-center gap-2 mb-3">
                                    <span class="text-[11px] font-mono uppercase tracking-wider text-brand font-semibold">
                                        {{ $project->category ?? 'Backend System' }}
                                    </span>
                                    <span class="text-[var(--theme-text-muted)]">•</span>
                                    <span class="text-[11px] text-[var(--theme-text-muted)] font-medium">
                                        {{ $project->role ?: 'Lead Backend Engineer' }}
                                    </span>
                                </div>

                                <!-- Title -->
                                <h3 class="text-xl sm:text-2xl font-bold text-[var(--theme-text-heading)] mb-3 leading-snug">
                                    <a href="{{ route('projects.show', $project->slug) }}" class="group-hover:text-brand transition-colors">
                                        {{ $project->title }}
                                    </a>
                                </h3>

                                <!-- Description -->
                                <p class="text-[var(--theme-text-body)] text-sm leading-relaxed mb-6 font-normal">
                                    {{ Str::limit($project->short_description ?: strip_tags($project->description), 110) }}
                                </p>

                                @if($project->challenges || $project->solutions)
                                    <div class="mb-5 p-3.5 rounded-xl bg-[var(--theme-bg-alt)] border border-[var(--theme-border)] text-xs space-y-1.5">
                                        @if($project->challenges)
                                            <div class="text-[var(--theme-text-muted)]">
                                                <strong class="text-[var(--theme-text-heading)] font-semibold">Challenge:</strong> {{ Str::limit($project->challenges, 80) }}
                                            </div>
                                        @endif
                                        @if($project->solutions)
                                            <div class="text-emerald-600 dark:text-emerald-400">
                                                <strong class="font-semibold">Architecture:</strong> {{ Str::limit($project->solutions, 80) }}
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            <!-- Tech Stack & Action Links -->
                            <div>
                                @if($project->tech_stack && is_array($project->tech_stack))
                                    <div class="flex flex-wrap gap-1.5 mb-6">
                                        @foreach(array_slice($project->tech_stack, 0, 4) as $tech)
                                            <span class="text-[11px] font-mono px-2.5 py-1 rounded-md bg-[var(--theme-bg-alt)] text-[var(--theme-text-body)] border border-[var(--theme-border)] font-medium">
                                                {{ $tech }}
                                            </span>
                                        @endforeach
                                    </div>
                                @endif

                                <div class="pt-4 border-t border-[var(--theme-border)] flex items-center justify-between text-xs font-medium">
                                    <a href="{{ route('projects.show', $project->slug) }}" class="text-[var(--theme-text-heading)] hover:text-brand transition-colors inline-flex items-center gap-1.5 font-semibold group/btn">
                                        <span>Read Case Study</span>
                                        <svg class="w-3.5 h-3.5 transition-transform duration-200 group-hover/btn:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                    </a>

                                    <div class="flex items-center gap-3 text-[var(--theme-text-muted)]">
                                        @if($project->public_demo_url)
                                            <a href="{{ $project->public_demo_url }}" target="_blank" rel="noopener noreferrer" class="hover:text-brand transition-colors">
                                                Live ↗
                                            </a>
                                        @endif
                                        @if($project->github_url)
                                            <a href="{{ $project->github_url }}" target="_blank" rel="noopener noreferrer" class="hover:text-brand transition-colors">
                                                Code ↗
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

            </div>
        </section>
    @endif

    {{-- ========================================================
         ABOUT & WORK EXPERIENCE TIMELINE — HIGH-TRUST EDITORIAL
         ======================================================== --}}
    @if($section === 'about' && $homepageSettings->about_section_enabled)
        <section id="about" class="py-20 sm:py-28 bg-[var(--theme-bg-alt)] border-b border-[var(--theme-border)] relative">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl 2xl:max-w-[1400px]">
                
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-14 items-start">
                    <!-- Left: Narrative & Background -->
                    <div class="lg:col-span-5">
                        <span class="text-xs font-mono uppercase tracking-widest text-brand font-semibold mb-3 block">
                            03 / Engineering Journey &amp; Milestones
                        </span>
                        <h2 class="text-3xl sm:text-4xl font-extrabold text-[var(--theme-text-heading)] tracking-tight leading-tight mb-6">
                            Engineering resilient backend architectures with production reliability.
                        </h2>
                        <div class="text-[var(--theme-text-body)] text-base leading-relaxed space-y-4 font-normal mb-8">
                            <p>
                                {{ $profile->intro ? strip_tags($profile->intro) : 'Backend Engineer with ' . $yearsDisplay . ' of commercial software engineering experience. I specialize in designing scalable database architectures, high-performance RESTful APIs, and custom enterprise backend platforms.' }}
                            </p>
                            @if($profile->experience_text)
                                <p class="text-[var(--theme-text-muted)] text-sm font-medium">
                                    {{ $profile->experience_text }}
                                </p>
                            @else
                                <p class="text-[var(--theme-text-muted)] text-sm">
                                    Every system I build adheres to strict type safety, modular domain separation, and comprehensive indexing — ensuring your application runs fast today and remains painless to maintain years down the line.
                                </p>
                            @endif
                        </div>

                        <div class="flex flex-wrap gap-3">
                            @if($profile->resume_url && $profile->resume_button_visible)
                            <a href="{{ route('resume') }}" class="theme-btn-primary inline-flex items-center gap-2 px-5 py-3 rounded-xl text-sm font-semibold shadow-sm transition-all hover:scale-[1.02]">
                                <svg class="w-4 h-4 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <span>Download Resume &amp; CV</span>
                            </a>
                            @endif
                            <a href="{{ route('about') }}" class="theme-btn-secondary inline-flex items-center gap-2 px-5 py-3 rounded-xl border text-sm font-semibold transition-all">
                                <span>Read Full Journey</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                        </div>
                    </div>

                    <!-- Right: Work Experience Timeline & Proven Milestones -->
                    <div class="lg:col-span-7 space-y-4">
                        <!-- Timeline Card 1 -->
                        <div class="p-6 sm:p-7 rounded-3xl bg-[var(--theme-bg-card)] border border-[var(--theme-border)] hover:border-brand/40 transition-all shadow-xs">
                            <div class="flex items-center justify-between gap-4 mb-2">
                                <span class="text-xs font-mono font-bold text-brand uppercase tracking-wider">2023 — Present</span>
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20">Active Role</span>
                            </div>
                            <h3 class="text-lg sm:text-xl font-bold text-[var(--theme-text-heading)] mb-2">
                                {{ $profile->title ?: 'Senior PHP & Laravel Backend Developer' }}
                            </h3>
                            <p class="text-xs sm:text-sm text-[var(--theme-text-body)] leading-relaxed font-normal mb-3">
                                Architecting and maintaining scalable commercial web platforms and API gateways using PHP 8.2+, Laravel 11, and MySQL. Engineering asynchronous queue workers, Redis caching, webhook pipelines, and role-based access control.
                            </p>
                            <div class="flex flex-wrap gap-1.5">
                                <span class="text-[11px] font-mono px-2 py-0.5 rounded bg-[var(--theme-bg-alt)] text-[var(--theme-text-muted)] font-medium">Laravel 11</span>
                                <span class="text-[11px] font-mono px-2 py-0.5 rounded bg-[var(--theme-bg-alt)] text-[var(--theme-text-muted)] font-medium">PHP 8.2+</span>
                                <span class="text-[11px] font-mono px-2 py-0.5 rounded bg-[var(--theme-bg-alt)] text-[var(--theme-text-muted)] font-medium">MySQL Indexing</span>
                                <span class="text-[11px] font-mono px-2 py-0.5 rounded bg-[var(--theme-bg-alt)] text-[var(--theme-text-muted)] font-medium">Redis Queues</span>
                                <span class="text-[11px] font-mono px-2 py-0.5 rounded bg-[var(--theme-bg-alt)] text-[var(--theme-text-muted)] font-medium">REST APIs</span>
                            </div>
                        </div>

                        <!-- Timeline Card 2 -->
                        <div class="p-6 sm:p-7 rounded-3xl bg-[var(--theme-bg-card)] border border-[var(--theme-border)] hover:border-brand/40 transition-all shadow-xs">
                            <div class="flex items-center justify-between gap-4 mb-2">
                                <span class="text-xs font-mono font-bold text-brand uppercase tracking-wider">2022 — 2023</span>
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-black/5 dark:bg-white/10 text-[var(--theme-text-muted)]">Commercial Delivery</span>
                            </div>
                            <h3 class="text-lg sm:text-xl font-bold text-[var(--theme-text-heading)] mb-2">
                                Backend Systems &amp; Database Specialist
                            </h3>
                            <p class="text-xs sm:text-sm text-[var(--theme-text-body)] leading-relaxed font-normal mb-3">
                                Designed 3NF relational schemas, tuned SQL queries with composite B-Tree indexes, and eliminated N+1 query bottlenecks. Implemented secure token-based Sanctum authentication and rate-limited API endpoints.
                            </p>
                            <div class="flex flex-wrap gap-1.5">
                                <span class="text-[11px] font-mono px-2 py-0.5 rounded bg-[var(--theme-bg-alt)] text-[var(--theme-text-muted)] font-medium">Schema Design</span>
                                <span class="text-[11px] font-mono px-2 py-0.5 rounded bg-[var(--theme-bg-alt)] text-[var(--theme-text-muted)] font-medium">Sanctum Auth</span>
                                <span class="text-[11px] font-mono px-2 py-0.5 rounded bg-[var(--theme-bg-alt)] text-[var(--theme-text-muted)] font-medium">Query Optimization</span>
                                <span class="text-[11px] font-mono px-2 py-0.5 rounded bg-[var(--theme-bg-alt)] text-[var(--theme-text-muted)] font-medium">Postman Testing</span>
                            </div>
                        </div>

                        <!-- Timeline Card 3 -->
                        <div class="p-6 sm:p-7 rounded-3xl bg-[var(--theme-bg-card)] border border-[var(--theme-border)] hover:border-brand/40 transition-all shadow-xs">
                            <div class="flex items-center justify-between gap-4 mb-2">
                                <span class="text-xs font-mono font-bold text-brand uppercase tracking-wider">2022</span>
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-brand/10 text-brand">Foundation</span>
                            </div>
                            <h3 class="text-lg sm:text-xl font-bold text-[var(--theme-text-heading)] mb-2">
                                {{ \App\Models\Setting::get('training_text') ? 'Intensive Backend Engineering & Architecture Training (' . ltrim(\App\Models\Setting::get('training_text'), '+ ') . ')' : 'Intensive Backend Engineering & Architecture Training (6 Months)' }}
                            </h3>
                            <p class="text-xs sm:text-sm text-[var(--theme-text-body)] leading-relaxed font-normal mb-3">
                                Completed rigorous full-time software engineering training covering MVC design patterns, object-oriented PHP, PSR-12 coding standards, database normalization, Git version control, and web security principles.
                            </p>
                            <div class="flex flex-wrap gap-1.5">
                                <span class="text-[11px] font-mono px-2 py-0.5 rounded bg-[var(--theme-bg-alt)] text-[var(--theme-text-muted)] font-medium">OOP PHP</span>
                                <span class="text-[11px] font-mono px-2 py-0.5 rounded bg-[var(--theme-bg-alt)] text-[var(--theme-text-muted)] font-medium">Design Patterns</span>
                                <span class="text-[11px] font-mono px-2 py-0.5 rounded bg-[var(--theme-bg-alt)] text-[var(--theme-text-muted)] font-medium">PSR-12 Standards</span>
                                <span class="text-[11px] font-mono px-2 py-0.5 rounded bg-[var(--theme-bg-alt)] text-[var(--theme-text-muted)] font-medium">Git &amp; GitHub</span>
                            </div>
                        </div>

                        <!-- Highlights Banner -->
                        @php
                            $hl1 = \App\Models\Setting::get('about_highlight_1');
                            $hl2 = \App\Models\Setting::get('about_highlight_2');
                        @endphp
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                            <div class="p-4 rounded-2xl bg-[var(--theme-bg-card)] border border-[var(--theme-border)] flex items-center gap-3">
                                <div class="w-8 h-8 rounded-xl bg-brand/10 text-brand flex items-center justify-center font-bold text-sm shrink-0">✓</div>
                                <div class="text-xs font-bold text-[var(--theme-text-heading)]">{{ $hl1 ?: ($completedProjectsCount . '+ Commercial Deliveries') }}</div>
                            </div>
                            <div class="p-4 rounded-2xl bg-[var(--theme-bg-card)] border border-[var(--theme-border)] flex items-center gap-3">
                                <div class="w-8 h-8 rounded-xl bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 flex items-center justify-center font-bold text-sm shrink-0">★</div>
                                <div class="text-xs font-bold text-[var(--theme-text-heading)]">{{ $hl2 ?: ($satisfactionRate . '% Production Quality Guarantee') }}</div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    @endif

    {{-- ========================================================
         SERVICES SECTION — CLEAN SOLUTIONS LIST
         ======================================================== --}}
    @if($section === 'services' && $homepageSettings->services_section_enabled && $featuredServices->isNotEmpty())
        <section id="services" class="py-20 sm:py-28 bg-[var(--theme-bg-canvas)] border-b border-[var(--theme-border)]">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl 2xl:max-w-[1400px]">
                
                <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-14">
                    <div>
                        <span class="text-xs font-mono uppercase tracking-widest text-brand font-semibold mb-2 block">
                            04 / Core Engineering Solutions
                        </span>
                        <h2 class="text-3xl sm:text-4xl font-extrabold text-[var(--theme-text-heading)] tracking-tight">
                            Specialized Full-Stack Services
                        </h2>
                        <p class="text-[var(--theme-text-muted)] text-base mt-2 max-w-xl">
                            Targeted capabilities to architect new software products, engineer high-throughput APIs, or optimize database bottlenecks.
                        </p>
                    </div>
                    <div class="mt-4 sm:mt-0">
                        <a href="{{ route('services') }}"
                            class="theme-btn-secondary inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs sm:text-sm font-medium border transition-all">
                            <span>Browse All Services ({{ \App\Models\Service::where('is_enabled', true)->count() }})</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 sm:gap-8">
                    @foreach($featuredServices as $service)
                        <div class="tilt-card reveal-on-scroll p-7 rounded-3xl bg-[var(--theme-bg-card)] border border-[var(--theme-border)] hover:border-brand/40 transition-all flex flex-col justify-between"
                            style="transition-delay: {{ $loop->index * 120 }}ms;">
                            <div>
                                <span class="text-xs font-mono text-brand font-semibold block mb-2">Service 0{{ $loop->iteration }}</span>
                                <h3 class="text-xl font-bold text-[var(--theme-text-heading)] mb-3">
                                    <a href="{{ route('services.show', $service->slug) }}" class="hover:text-brand transition-colors">
                                        {{ $service->name }}
                                    </a>
                                </h3>
                                <p class="text-[var(--theme-text-body)] text-sm leading-relaxed mb-6 font-normal">
                                    {{ Str::limit($service->short_description ?: strip_tags($service->description), 110) }}
                                </p>

                                @if($service->features && is_array($service->features))
                                    <ul class="space-y-2 mb-6 text-xs text-[var(--theme-text-body)]">
                                        @foreach(array_slice($service->features, 0, 3) as $feat)
                                            <li class="flex items-center gap-2">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                <span>{{ $feat }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>

                            <div class="pt-4 border-t border-[var(--theme-border)] flex items-center justify-between text-xs">
                                <span class="text-[var(--theme-text-muted)] font-mono">{{ $service->price ? 'Starting at ' . $service->price : 'Scope & Architecture' }}</span>
                                <a href="{{ $service->cta_url ?: route('contact', ['service' => $service->slug]) }}" class="font-semibold text-[var(--theme-text-heading)] hover:text-brand transition-colors inline-flex items-center gap-1">
                                    <span>{{ $service->cta_text ?: 'Inquire ↗' }}</span>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </section>
    @endif

    {{-- ========================================================
         WORK PROCESS — CLEAN ROADMAP
         ======================================================== --}}
    @if($section === 'work_process' && $homepageSettings->work_process_section_enabled && $workProcesses->isNotEmpty())
        <section class="py-20 sm:py-28 bg-[var(--theme-bg-alt)] border-b border-[var(--theme-border)]">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl 2xl:max-w-[1400px]">
                
                <div class="max-w-2xl mb-14">
                    <span class="text-xs font-mono uppercase tracking-widest text-brand font-semibold mb-2 block">
                        05 / Delivery Standards
                    </span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-[var(--theme-text-heading)] tracking-tight">
                        Predictable, Reliable Delivery
                    </h2>
                    <p class="text-[var(--theme-text-muted)] text-base mt-2">
                        How backend projects move from architectural specifications to smooth production deployment.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($workProcesses as $index => $process)
                        <div class="border-t border-[var(--theme-border)] pt-6">
                            <span class="text-xs font-mono text-brand block mb-2 font-semibold">
                                Step 0{{ $index + 1 }}
                            </span>
                            <h3 class="text-lg font-bold text-[var(--theme-text-heading)] mb-2">{{ $process->title }}</h3>
                            <p class="text-sm text-[var(--theme-text-body)] leading-relaxed font-normal">{{ $process->description }}</p>
                        </div>
                    @endforeach
                </div>

            </div>
        </section>
    @endif

    {{-- ========================================================
         TESTIMONIALS SECTION — SOCIAL PROOF & CLIENT TRUST
         ======================================================== --}}
    @if($section === 'testimonials' && $homepageSettings->testimonials_section_enabled && isset($testimonials) && $testimonials->isNotEmpty())
        <section id="testimonials" class="py-20 sm:py-28 bg-[var(--theme-bg-canvas)] border-b border-[var(--theme-border)] relative">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl 2xl:max-w-[1400px]">
                
                <div class="max-w-2xl mb-14">
                    <span class="text-xs font-mono uppercase tracking-widest text-brand font-semibold mb-2 block">
                        06 / Client Feedback
                    </span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-[var(--theme-text-heading)] tracking-tight">
                        Trusted by Founders &amp; Engineering Teams
                    </h2>
                    <p class="text-[var(--theme-text-muted)] text-base mt-2">
                        Real testimonials from business founders, product leads, and technical collaborators.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8">
                    @foreach($testimonials as $testimonial)
                        <div class="p-7 sm:p-8 rounded-3xl bg-[var(--theme-bg-card)] border border-[var(--theme-border)] shadow-xs hover:border-brand/40 transition-all flex flex-col justify-between">
                            <div>
                                <!-- Star Rating -->
                                <div class="flex items-center gap-1 text-amber-500 mb-5">
                                    @for($i = 0; $i < 5; $i++)
                                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    @endfor
                                </div>
                                <blockquote class="text-[var(--theme-text-body)] text-sm sm:text-base leading-relaxed mb-6 font-normal italic">
                                    "{{ $testimonial->feedback }}"
                                </blockquote>
                            </div>
                            <div class="pt-5 border-t border-[var(--theme-border)] flex items-center gap-3">
                                @if($testimonial->image_url)
                                    <img src="{{ $testimonial->image_url }}" alt="{{ $testimonial->name }}" class="w-10 h-10 rounded-full object-cover border border-[var(--theme-border)] shrink-0">
                                @else
                                    <div class="w-10 h-10 rounded-full bg-brand/10 text-brand flex items-center justify-center font-bold text-sm shrink-0">
                                        {{ substr($testimonial->name, 0, 1) }}
                                    </div>
                                @endif
                                <div>
                                    <h4 class="text-sm font-bold text-[var(--theme-text-heading)]">{{ $testimonial->name }}</h4>
                                    <p class="text-xs text-[var(--theme-text-muted)]">{{ $testimonial->role_company }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </section>
    @endif

    {{-- ========================================================
         CONTACT SECTION — HIGH-CONVERTING DIRECT INQUIRY FORM
         ======================================================== --}}
    @if($section === 'contact_cta' && $homepageSettings->contact_cta_section_enabled)
        @php
            $contactDirectEmail = $profile->contact_email ?: ($profile->email ?: \App\Models\Setting::get('contact_email'));
            $contactPhone = $profile->contact_phone ?: ($profile->phone ?: \App\Models\Setting::get('contact_phone'));
            $contactWhatsapp = $profile->whatsapp_url ?: (\App\Models\Setting::get('contact_whatsapp') ? 'https://wa.me/' . preg_replace('/\D+/', '', \App\Models\Setting::get('contact_whatsapp')) : null);
        @endphp

        <section id="contact" class="py-20 sm:py-28 bg-[var(--theme-bg-alt)] text-[var(--theme-text-heading)] relative overflow-hidden border-b border-[var(--theme-border)]">
            <div class="absolute -top-12 left-1/2 -translate-x-1/2 w-[550px] h-[350px] bg-brand/5 dark:bg-brand/10 rounded-full blur-[140px] pointer-events-none"></div>

            <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10 max-w-5xl">
                <!-- Section Header -->
                <div class="text-center max-w-2xl mx-auto mb-14">
                    <span class="text-xs font-mono uppercase tracking-widest text-brand font-semibold mb-3 block">
                        07 / Direct Collaboration
                    </span>
                    <h2 class="text-3xl sm:text-5xl font-extrabold tracking-tight text-[var(--theme-text-heading)] mb-4 leading-tight">
                        {{ $homepageSettings->contact_cta_heading ?: 'Have a complex system or project in mind?' }}
                    </h2>
                    <p class="text-base sm:text-lg text-[var(--theme-text-body)] leading-relaxed font-normal">
                        {{ $homepageSettings->contact_cta_description ?: "Send your project scope or architectural requirements directly. I will review and respond within 24 hours." }}
                    </p>
                </div>

                @if(session('success'))
                    <div class="mb-8 p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-700 dark:text-emerald-300 text-sm text-center font-medium shadow-xs">
                        ✓ {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-8 p-4 rounded-2xl bg-rose-500/10 border border-rose-500/30 text-rose-700 dark:text-rose-300 text-sm text-center font-medium shadow-xs">
                        ⚠ {{ session('error') }}
                    </div>
                @endif

                <!-- Contact Grid: Form on Left, Direct Contact on Right -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                    
                    <!-- Direct Form Card -->
                    <div class="lg:col-span-7 p-7 sm:p-9 rounded-3xl bg-[var(--theme-bg-card)] border border-[var(--theme-border)] shadow-xs">
                        <div class="mb-6">
                            <h3 class="text-lg font-bold text-[var(--theme-text-heading)]">Send a Direct Project Inquiry</h3>
                            <p class="text-xs text-[var(--theme-text-muted)] mt-1">Fill out the quick details below and I'll review your project scope.</p>
                        </div>

                        <form action="{{ route('contact.submit') }}" method="POST" class="space-y-4">
                            @csrf
                            <!-- Honeypot Anti-spam -->
                            <input type="text" name="website_hp" style="display:none" tabindex="-1" autocomplete="off">

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--theme-text-muted)] mb-1.5">Your Name *</label>
                                    <input type="text" name="name" required
                                        placeholder="e.g. John Doe"
                                        class="w-full px-4 py-3 rounded-xl bg-[var(--theme-bg-alt)] border border-[var(--theme-border)] text-sm text-[var(--theme-text-heading)] placeholder-[var(--theme-text-muted)] focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand transition-colors">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--theme-text-muted)] mb-1.5">Your Email *</label>
                                    <input type="email" name="email" required
                                        placeholder="e.g. john@company.com"
                                        class="w-full px-4 py-3 rounded-xl bg-[var(--theme-bg-alt)] border border-[var(--theme-border)] text-sm text-[var(--theme-text-heading)] placeholder-[var(--theme-text-muted)] focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand transition-colors">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--theme-text-muted)] mb-1.5">Service / Interest</label>
                                    <select name="service_type"
                                        class="w-full px-4 py-3 rounded-xl bg-[var(--theme-bg-alt)] border border-[var(--theme-border)] text-sm text-[var(--theme-text-heading)] focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand transition-colors">
                                        <option value="Custom Backend &amp; APIs">Custom Backend &amp; REST APIs</option>
                                        <option value="Laravel Application Development">Laravel Application Development</option>
                                        <option value="Database Tuning &amp; Schema Optimization">Database Tuning &amp; Schema Optimization</option>
                                        <option value="Queues, Redis &amp; Background Workers">Queues, Redis &amp; Background Workers</option>
                                        <option value="Codebase Audit &amp; Bug Fixing">Codebase Audit &amp; Bug Fixing</option>
                                        <option value="Full-Time / Contract Backend Role">Full-Time / Contract Backend Role</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--theme-text-muted)] mb-1.5">Phone / WhatsApp (Optional)</label>
                                    <input type="text" name="phone"
                                        placeholder="+91 98765 43210"
                                        class="w-full px-4 py-3 rounded-xl bg-[var(--theme-bg-alt)] border border-[var(--theme-border)] text-sm text-[var(--theme-text-heading)] placeholder-[var(--theme-text-muted)] focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand transition-colors">
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--theme-text-muted)] mb-1.5">Project Overview &amp; Requirements *</label>
                                <textarea name="message" rows="4" required minlength="10"
                                    placeholder="Briefly describe what you are looking to build, optimize, or resolve..."
                                    class="w-full px-4 py-3 rounded-xl bg-[var(--theme-bg-alt)] border border-[var(--theme-border)] text-sm text-[var(--theme-text-heading)] placeholder-[var(--theme-text-muted)] focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand transition-colors"></textarea>
                            </div>

                            <button type="submit"
                                class="theme-btn-primary w-full inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-xl font-semibold text-sm transition-all hover:scale-[1.01] shadow-sm">
                                <span>Send Project Inquiry</span>
                                <svg class="w-4 h-4 ml-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </button>
                        </form>
                    </div>

                    <!-- Direct Contact & Trust Sidebar -->
                    <div class="lg:col-span-5 space-y-5">
                        
                        <!-- Response SLA Card -->
                        <div class="p-6 rounded-3xl bg-[var(--theme-bg-card)] border border-[var(--theme-border)] shadow-xs">
                            <div class="flex items-center gap-3 mb-3">
                                <span class="relative flex h-3 w-3">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                                </span>
                                <span class="text-xs font-mono font-bold uppercase tracking-wider text-emerald-600 dark:text-emerald-400">Response Commitment</span>
                            </div>
                            <h4 class="text-base font-bold text-[var(--theme-text-heading)] mb-1">Direct Technical Consultation</h4>
                            <p class="text-xs text-[var(--theme-text-body)] leading-relaxed">
                                I personally review all technical inquiries. Guaranteed SLA: <strong class="text-[var(--theme-text-heading)]">{{ \App\Models\Setting::get('terminal_sla_text') ?: '< 24 Hours Response' }}</strong>.
                            </p>
                        </div>

                        <!-- Direct Channels Card -->
                        <div class="p-6 rounded-3xl bg-[var(--theme-bg-card)] border border-[var(--theme-border)] shadow-xs space-y-4">
                            <h4 class="text-xs font-mono uppercase tracking-wider text-[var(--theme-text-muted)] font-bold">Fast Communication Channels</h4>
                            
                            @if($contactDirectEmail)
                                <div class="flex items-center justify-between p-3.5 rounded-2xl bg-[var(--theme-bg-alt)] border border-[var(--theme-border)]">
                                    <div class="min-w-0 pr-2">
                                        <span class="text-[11px] text-[var(--theme-text-muted)] block">Email</span>
                                        <span class="text-xs sm:text-sm font-semibold text-[var(--theme-text-heading)] truncate block">{{ $contactDirectEmail }}</span>
                                    </div>
                                    <div x-data="{ copied: false }" class="shrink-0">
                                        <button type="button"
                                            @click="window.copyPortfolioEmail('{{ $contactDirectEmail }}', $event); copied = true; setTimeout(() => copied = false, 2000)"
                                            class="theme-btn-secondary px-3 py-1.5 rounded-lg text-xs font-medium border inline-flex items-center gap-1.5 transition-all duration-200"
                                            :class="copied ? 'bg-emerald-500/15 border-emerald-500/40 text-emerald-600 dark:text-emerald-400 font-semibold' : ''"
                                            title="Copy direct email address">
                                            <template x-if="!copied">
                                                <svg class="w-3.5 h-3.5 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                            </template>
                                            <template x-if="copied">
                                                <svg class="w-3.5 h-3.5 text-emerald-500 animate-scale-in" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                            </template>
                                            <span x-text="copied ? 'Copied! ✓' : 'Copy'">Copy</span>
                                        </button>
                                    </div>
                                </div>
                            @endif

                            @if($contactWhatsapp)
                                <a href="{{ $contactWhatsapp }}" target="_blank" rel="noopener noreferrer"
                                    class="flex items-center justify-between p-3.5 rounded-2xl bg-[var(--theme-bg-alt)] border border-[var(--theme-border)] hover:border-emerald-500/50 transition-colors">
                                    <div>
                                        <span class="text-[11px] text-[var(--theme-text-muted)] block">WhatsApp</span>
                                        <span class="text-xs sm:text-sm font-semibold text-[var(--theme-text-heading)]">Direct Chat &amp; Voice</span>
                                    </div>
                                    <span class="text-xs text-emerald-600 dark:text-emerald-400 font-semibold flex items-center gap-1">
                                        Open ↗
                                    </span>
                                </a>
                            @endif

                            @php
                                $contactDirectLocation = ($profile->location_visible && $profile->location) ? $profile->location : \App\Models\Setting::get('website_address');
                            @endphp
                            @if($contactDirectLocation)
                                <!-- Location & Timezone -->
                                <div class="p-3.5 rounded-2xl bg-[var(--theme-bg-alt)] border border-[var(--theme-border)] flex items-center gap-3 text-xs">
                                    <span class="text-lg">📍</span>
                                    <div>
                                        <span class="font-bold text-[var(--theme-text-heading)]">{{ $contactDirectLocation }}</span>
                                        <span class="text-[var(--theme-text-muted)] block">IST (UTC+5:30) • Open for Global Remote Roles</span>
                                    </div>
                                </div>
                            @endif
                        </div>

                    </div>

                </div>

            </div>
        </section>
    @endif
@endforeach

@endsection
