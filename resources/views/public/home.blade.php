@extends('public.layouts.app')

@section('title', ($homepageSettings->hero_heading ? $homepageSettings->hero_heading . ' - ' : ($profile->full_name . ' - ')) . $websiteName)
@section('meta_description', $homepageSettings->hero_description ?? (strip_tags($profile->bio) ?? ($profile->intro ?? 'Senior Full Stack Software Engineer portfolio specializing in Laravel, PHP, MySQL, and high-performance REST APIs.')))

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
    // High-converting sequence: Hero -> Marquee -> Projects -> About & Experience -> Services -> Delivery -> CTA
    $order = ['hero', 'skills_marquee', 'projects', 'about', 'services', 'work_process', 'contact_cta'];
@endphp

@foreach($order as $section)
    {{-- ========================================================
         HERO SECTION — MINIMALIST & MODERN EDITORIAL (LINEAR / APPLE STYLE)
         ======================================================== --}}
    @if($section === 'hero' && $homepageSettings->hero_section_enabled)
        @php
            $isAvailable = \App\Models\Setting::get('available_for_freelance', '1') === '1'
                || \App\Models\Setting::get('available_for_freelance', true) === true;
            $rawYears = \App\Models\Setting::get('years_experience') ?: '2.5';
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
                <img src="{{ asset('images/hero-workspace.jpg') }}?v={{ filemtime(public_path('images/hero-workspace.jpg')) }}" 
                     alt="Rohit Gannote Workspace" 
                     class="w-full h-full object-cover object-center select-none brightness-[1.0] contrast-[1.02] dark:brightness-[0.82] dark:contrast-[1.08]">
                
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
                        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20 text-xs font-semibold tracking-wide shadow-2xs">
                            <span class="relative flex h-2 w-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                            </span>
                            <span>Available for Work</span>
                        </div>
                    </div>

                    @php
                        $profileName = $profile->name ?: 'Rohit Gannote';
                        $nameParts = explode(' ', $profileName, 2);
                        $firstName = $nameParts[0];
                        $lastName = $nameParts[1] ?? '';
                        $completedProjectsCount = \App\Models\Setting::get('projects_completed_count') ?: ((\App\Models\Project::where('status', 'published')->count() > 5) ? \App\Models\Project::where('status', 'published')->count() : 12);
                        $satisfactionRate = \App\Models\Setting::get('client_satisfaction_percentage', '100');
                    @endphp

                    <!-- Main Name Headline with Accent Color (100% Dynamic) -->
                    <h1 class="text-3xl sm:text-5xl lg:text-6xl xl:text-[72px] font-extrabold tracking-tight text-[var(--theme-text-heading)] leading-[1.06] mb-2 sm:mb-3">
                        {{ $firstName }} @if($lastName)<span class="text-brand">{{ $lastName }}</span>@endif
                    </h1>

                    <!-- Role Subtitle -->
                    <div class="text-xl sm:text-2xl lg:text-3xl xl:text-4xl font-bold text-[var(--theme-text-heading)] mb-4 sm:mb-6 tracking-tight">
                        {{ $profile->title ?: 'Full Stack Web Developer' }}
                    </div>

                    <!-- Description -->
                    <p class="text-sm sm:text-base lg:text-lg text-[var(--theme-text-body)] max-w-xl lg:max-w-[500px] xl:max-w-xl leading-relaxed mb-8 sm:mb-10 font-normal">
                        {{ $homepageSettings->hero_description ?: 'I build modern, scalable and user-friendly web applications using Laravel, PHP, MySQL and modern technologies. I love turning ideas into real products and solving complex problems with clean code.' }}
                    </p>

                    <!-- Action Buttons (Pill-shaped, exactly like reference) -->
                    <div class="flex flex-wrap items-center gap-2.5 sm:gap-4 mb-10 sm:mb-14">
                        <a href="#projects"
                            class="theme-btn-primary inline-flex items-center justify-center gap-2 px-5 sm:px-7 py-3 sm:py-3.5 font-semibold rounded-full hover:scale-[1.02] shadow-md transition-all duration-200 text-xs sm:text-sm lg:text-base">
                            <span>View My Projects</span>
                            <svg class="w-4 h-4 ml-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>

                        <a href="{{ route('resume') }}"
                            class="theme-btn-secondary inline-flex items-center justify-center gap-2 px-4 sm:px-6 py-3 sm:py-3.5 font-medium rounded-full border transition-all duration-200 text-xs sm:text-sm lg:text-base group"
                            title="View Resume &amp; Curriculum Vitae">
                            <svg class="w-4 h-4 text-brand transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span>Resume</span>
                        </a>

                        <a href="#contact"
                            class="theme-btn-secondary inline-flex items-center justify-center gap-2 px-4 sm:px-6 py-3 sm:py-3.5 font-medium rounded-full border transition-all duration-200 text-xs sm:text-sm lg:text-base">
                            <span>Get In Touch</span>
                            <svg class="w-4 h-4 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </a>
                    </div>

                    <!-- Exact 3-Metric Row with Vertical Separators -->
                    <div class="flex items-center gap-3.5 sm:gap-6 lg:gap-8 text-left pt-2 flex-wrap sm:flex-nowrap">
                        <div>
                            <div class="text-xl sm:text-2xl lg:text-3xl font-extrabold text-[var(--theme-text-heading)] tracking-tight">
                                <span class="stat-counter" data-target="{{ is_numeric(rtrim($yearsDisplay, '+')) ? rtrim($yearsDisplay, '+') : '2.5' }}" data-suffix="+">{{ $yearsDisplay }}</span>
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
                            <div class="text-[11px] sm:text-xs text-[var(--theme-text-muted)] mt-0.5 font-medium">Client Satisfaction</div>
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
         PROJECTS SECTION — CLEAN 2-COLUMN EDITORIAL SHOWCASE
         ======================================================== --}}
    @if($section === 'projects' && $homepageSettings->projects_section_enabled && $featuredProjects->isNotEmpty())
        <section id="projects" class="py-20 sm:py-28 bg-[var(--theme-bg-canvas)] border-b border-[var(--theme-border)] relative">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl 2xl:max-w-[1400px]">
                
                <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-14">
                    <div>
                        <span class="text-xs font-mono uppercase tracking-widest text-brand font-semibold mb-2 block">
                            01 / Selected Work
                        </span>
                        <h2 class="text-3xl sm:text-4xl font-extrabold text-[var(--theme-text-heading)] tracking-tight">
                            Featured Commercial Projects
                        </h2>
                        <p class="text-[var(--theme-text-muted)] text-base mt-2 max-w-xl">
                            Real-world web applications and API platforms engineered for speed, reliability, and business impact.
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

                <!-- Clean 2-Column Grid (No heavy nested mockup frames) -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 sm:gap-10">
                    @foreach($featuredProjects as $project)
                        <article class="tilt-card reveal-on-scroll group flex flex-col justify-between rounded-3xl bg-[var(--theme-bg-card)] border border-[var(--theme-border)] hover:border-brand/40 shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden p-6 sm:p-7"
                            style="transition-delay: {{ $loop->index * 120 }}ms;">
                            <div>
                                <!-- Project Preview Image -->
                                <a href="{{ route('projects.show', $project->slug) }}" class="block aspect-[16/10] w-full rounded-2xl overflow-hidden bg-[var(--theme-bg-alt)] border border-[var(--theme-border)] mb-6 relative">
                                    @if($project->thumbnail_url)
                                        <img src="{{ $project->thumbnail_url }}" alt="{{ $project->title }}" loading="lazy" class="w-full h-full object-cover group-hover:scale-[1.025] transition-transform duration-500 ease-out"
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
                                        {{ $project->category ?? 'Web Application' }}
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
                                    <a href="{{ route('projects.show', $project->slug) }}" class="text-[var(--theme-text-heading)] hover:text-brand transition-colors inline-flex items-center gap-1 font-semibold">
                                        <span>Case Study</span>
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
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
                            02 / Experience &amp; Track Record
                        </span>
                        <h2 class="text-3xl sm:text-4xl font-extrabold text-[var(--theme-text-heading)] tracking-tight leading-tight mb-6">
                            Engineering robust web applications with production reliability.
                        </h2>
                        <div class="text-[var(--theme-text-body)] text-base leading-relaxed space-y-4 font-normal mb-8">
                            <p>
                                {{ $profile->intro ? strip_tags($profile->intro) : 'Full Stack Developer with ' . $yearsDisplay . ' of commercial software engineering experience. I specialize in designing scalable database architectures, high-performance RESTful APIs, and custom enterprise web applications.' }}
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
                            <a href="{{ route('resume') }}" class="theme-btn-primary inline-flex items-center gap-2 px-5 py-3 rounded-xl text-sm font-semibold shadow-sm transition-all hover:scale-[1.02]">
                                <svg class="w-4 h-4 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <span>View Resume &amp; CV</span>
                            </a>
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
                                Full Stack Commercial Web Developer
                            </h3>
                            <p class="text-xs sm:text-sm text-[var(--theme-text-body)] leading-relaxed font-normal mb-3">
                                Architecting and maintaining commercial web platforms using Laravel, PHP 8+, and MySQL. Engineering custom admin control panels, dynamic content management, and role-based access control systems.
                            </p>
                            <div class="flex flex-wrap gap-1.5">
                                <span class="text-[11px] font-mono px-2 py-0.5 rounded bg-[var(--theme-bg-alt)] text-[var(--theme-text-muted)] font-medium">Laravel 11</span>
                                <span class="text-[11px] font-mono px-2 py-0.5 rounded bg-[var(--theme-bg-alt)] text-[var(--theme-text-muted)] font-medium">MySQL Optimization</span>
                                <span class="text-[11px] font-mono px-2 py-0.5 rounded bg-[var(--theme-bg-alt)] text-[var(--theme-text-muted)] font-medium">REST APIs</span>
                                <span class="text-[11px] font-mono px-2 py-0.5 rounded bg-[var(--theme-bg-alt)] text-[var(--theme-text-muted)] font-medium">Tailwind CSS</span>
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
                                Designed 3NF relational schemas, tuned queries with composite B-Tree indexes, and eliminated N+1 query bottlenecks. Implemented secure token-based Sanctum authentication and rate-limited API endpoints.
                            </p>
                            <div class="flex flex-wrap gap-1.5">
                                <span class="text-[11px] font-mono px-2 py-0.5 rounded bg-[var(--theme-bg-alt)] text-[var(--theme-text-muted)] font-medium">Schema Design</span>
                                <span class="text-[11px] font-mono px-2 py-0.5 rounded bg-[var(--theme-bg-alt)] text-[var(--theme-text-muted)] font-medium">Sanctum Auth</span>
                                <span class="text-[11px] font-mono px-2 py-0.5 rounded bg-[var(--theme-bg-alt)] text-[var(--theme-text-muted)] font-medium">Redis Caching</span>
                                <span class="text-[11px] font-mono px-2 py-0.5 rounded bg-[var(--theme-bg-alt)] text-[var(--theme-text-muted)] font-medium">Blade Architecture</span>
                            </div>
                        </div>

                        <!-- Timeline Card 3 -->
                        <div class="p-6 sm:p-7 rounded-3xl bg-[var(--theme-bg-card)] border border-[var(--theme-border)] hover:border-brand/40 transition-all shadow-xs">
                            <div class="flex items-center justify-between gap-4 mb-2">
                                <span class="text-xs font-mono font-bold text-brand uppercase tracking-wider">2022</span>
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-brand/10 text-brand">Foundation</span>
                            </div>
                            <h3 class="text-lg sm:text-xl font-bold text-[var(--theme-text-heading)] mb-2">
                                Intensive Software Engineering Training (6 Months)
                            </h3>
                            <p class="text-xs sm:text-sm text-[var(--theme-text-body)] leading-relaxed font-normal mb-3">
                                Completed rigorous full-time software engineering training covering MVC design patterns, object-oriented PHP, PSR coding standards, database normalization, Git version control, and web security principles.
                            </p>
                            <div class="flex flex-wrap gap-1.5">
                                <span class="text-[11px] font-mono px-2 py-0.5 rounded bg-[var(--theme-bg-alt)] text-[var(--theme-text-muted)] font-medium">OOP PHP</span>
                                <span class="text-[11px] font-mono px-2 py-0.5 rounded bg-[var(--theme-bg-alt)] text-[var(--theme-text-muted)] font-medium">MVC Patterns</span>
                                <span class="text-[11px] font-mono px-2 py-0.5 rounded bg-[var(--theme-bg-alt)] text-[var(--theme-text-muted)] font-medium">PSR-12 Standards</span>
                                <span class="text-[11px] font-mono px-2 py-0.5 rounded bg-[var(--theme-bg-alt)] text-[var(--theme-text-muted)] font-medium">Git &amp; GitHub</span>
                            </div>
                        </div>

                        <!-- Highlights Banner (Dynamic) -->
                        <div class="grid grid-cols-2 gap-4 pt-2">
                            <div class="p-4 rounded-2xl bg-[var(--theme-bg-card)] border border-[var(--theme-border)] flex items-center gap-3">
                                <div class="w-8 h-8 rounded-xl bg-brand/10 text-brand flex items-center justify-center font-bold text-sm shrink-0">✓</div>
                                <div class="text-xs font-bold text-[var(--theme-text-heading)]">{{ $completedProjectsCount }}+ Commercial Projects Delivered</div>
                            </div>
                            <div class="p-4 rounded-2xl bg-[var(--theme-bg-card)] border border-[var(--theme-border)] flex items-center gap-3">
                                <div class="w-8 h-8 rounded-xl bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 flex items-center justify-center font-bold text-sm shrink-0">★</div>
                                <div class="text-xs font-bold text-[var(--theme-text-heading)]">{{ $satisfactionRate }}% Production Quality &amp; Clean Code</div>
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
        <section id="services" class="py-20 sm:py-28 bg-[var(--theme-bg-alt)] border-b border-[var(--theme-border)]">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl 2xl:max-w-[1400px]">
                
                <div class="max-w-2xl mb-14">
                    <span class="text-xs font-mono uppercase tracking-widest text-brand font-semibold mb-2 block">
                        03 / Core Engineering Solutions
                    </span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-[var(--theme-text-heading)] tracking-tight">
                        Specialized Full-Stack Services
                    </h2>
                    <p class="text-[var(--theme-text-muted)] text-base mt-2">
                        Targeted capabilities to architect new software products, engineer high-throughput APIs, or optimize database bottlenecks.
                    </p>
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
                                <span class="text-[var(--theme-text-muted)] font-mono">Scope &amp; Architecture</span>
                                <a href="{{ route('contact', ['service' => $service->slug]) }}" class="font-semibold text-[var(--theme-text-heading)] hover:text-brand transition-colors inline-flex items-center gap-1">
                                    <span>Inquire ↗</span>
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
        <section class="py-20 sm:py-28 bg-[var(--theme-bg-canvas)] border-b border-[var(--theme-border)]">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl 2xl:max-w-[1400px]">
                
                <div class="max-w-2xl mb-14">
                    <span class="text-xs font-mono uppercase tracking-widest text-brand font-semibold mb-2 block">
                        04 / Delivery Standards
                    </span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-[var(--theme-text-heading)] tracking-tight">
                        Predictable, Reliable Delivery
                    </h2>
                    <p class="text-[var(--theme-text-muted)] text-base mt-2">
                        How projects move from technical specifications to smooth production deployment.
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
         CONTACT CTA — CLEAN & COMPELLING INVITATION
         ======================================================== --}}
    @if($section === 'contact_cta' && $homepageSettings->contact_cta_section_enabled)
        <section id="contact" class="py-24 sm:py-32 bg-[var(--theme-bg-alt)] text-[var(--theme-text-heading)] relative overflow-hidden border-b border-[var(--theme-border)]">
            <div class="absolute -top-12 left-1/2 -translate-x-1/2 w-[550px] h-[350px] bg-brand/5 dark:bg-brand/10 rounded-full blur-[140px] pointer-events-none"></div>

            <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10 max-w-3xl text-center">
                <span class="text-xs font-mono uppercase tracking-widest text-brand font-semibold mb-4 block">
                    05 / Let's Connect
                </span>
                <h2 class="text-3xl sm:text-5xl font-extrabold tracking-tight text-[var(--theme-text-heading)] mb-4 leading-tight">
                    {{ $homepageSettings->contact_cta_heading ?: 'Have a complex system or project in mind?' }}
                </h2>
                <p class="text-base sm:text-lg text-[var(--theme-text-body)] mb-10 max-w-xl mx-auto leading-relaxed font-normal">
                    {{ $homepageSettings->contact_cta_description ?: "Let's review your requirements. I am open for commercial web development, backend engineering, and system optimizations." }}
                </p>

                <div class="flex flex-wrap gap-4 justify-center items-center">
                    <a href="{{ route('contact') }}"
                        class="theme-btn-primary inline-flex items-center justify-center gap-2 px-8 py-4 rounded-xl text-sm sm:text-base font-semibold shadow-sm transition-all hover:scale-[1.02]">
                        <span>Initiate Project Inquiry</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>

                    @php
                        $contactDirectEmail = $profile->contact_email ?: ($profile->email ?: \App\Models\Setting::get('contact_email'));
                    @endphp
                    @if($contactDirectEmail)
                        <button type="button"
                            @click="window.copyPortfolioEmail('{{ $contactDirectEmail }}', $event)"
                            class="theme-btn-secondary inline-flex items-center justify-center gap-2 px-6 py-4 rounded-xl border text-sm sm:text-base font-medium transition-all"
                            title="Copy email: {{ $contactDirectEmail }}">
                            <svg class="w-4 h-4 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                            <span>Copy Direct Email</span>
                        </button>
                    @endif
                </div>
            </div>
        </section>
    @endif
@endforeach

@endsection
