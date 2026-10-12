@extends('public.layouts.app')

@section('title', ($homepageSettings->hero_heading ? $homepageSettings->hero_heading . ' - ' : ($profile->full_name . ' - ')) . $websiteName)
@section('meta_description', $homepageSettings->hero_description ?? ($profile->bio ?? 'Full Stack Web Developer portfolio'))

@section('content')
@php
    $order = $homepageSettings->section_order;
    if (is_string($order)) {
        $order = json_decode($order, true);
    }
    if (!is_array($order) || empty($order)) {
        $order = ['hero', 'about', 'skills', 'projects', 'services', 'work_process', 'testimonials', 'contact_cta'];
    }
@endphp

@foreach($order as $section)
    @if($section === 'hero' && $homepageSettings->hero_section_enabled)
        <!-- Hero Section -->
        <section class="relative pt-28 sm:pt-36 pb-16 sm:pb-24 overflow-hidden">
            <div class="absolute inset-0 -z-10 overflow-hidden">
                <div class="absolute -top-40 -right-40 w-96 h-96 bg-primary/10 rounded-full blur-3xl pointer-events-none"></div>
                <div class="absolute top-1/2 -left-40 w-96 h-96 bg-blue-400/10 dark:bg-blue-600/10 rounded-full blur-3xl pointer-events-none"></div>
            </div>

            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-4xl mx-auto text-center">
                    @php
                        $heroImg = $homepageSettings->hero_image_url ?: $profile->profile_photo_url;
                    @endphp

                    @if($heroImg)
                        <div class="relative inline-block mb-8 group">
                            <div class="w-32 h-32 sm:w-36 sm:h-36 rounded-full overflow-hidden border-4 border-white dark:border-slate-800 shadow-2xl mx-auto ring-4 ring-primary/20 transition-transform duration-300 group-hover:scale-105">
                                <img src="{{ $heroImg }}" alt="{{ $profile->full_name }}" class="w-full h-full object-cover">
                            </div>
                            <span class="absolute bottom-1 right-2 inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-500 text-white shadow-md">
                                <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span>
                                Available
                            </span>
                        </div>
                    @endif

                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-primary/10 text-primary font-medium text-xs sm:text-sm mb-6 border border-primary/20">
                        <span>🚀</span> {{ $homepageSettings->hero_heading ?: 'Full Stack Web Developer' }}
                    </div>

                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-slate-900 dark:text-white mb-6">
                        {{ $homepageSettings->hero_title ?: ($profile->name ? "Hi, I'm " . $profile->name : 'Building Scalable Web Applications') }}
                    </h1>

                    <p class="text-lg sm:text-xl text-slate-600 dark:text-slate-300 mb-10 max-w-2xl mx-auto leading-relaxed">
                        {{ $homepageSettings->hero_description ?: ($profile->bio ?: 'I craft clean, efficient, and scalable web applications using modern technologies.') }}
                    </p>

                    <div class="flex flex-wrap gap-4 justify-center items-center">
                        <a href="{{ $homepageSettings->primary_cta_url ?: route('projects') }}"
                            class="btn btn-primary text-base shadow-lg hover:shadow-primary/25">
                            {{ $homepageSettings->primary_cta_text ?: 'View My Work' }}
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                        <a href="{{ $homepageSettings->secondary_cta_url ?: route('contact') }}"
                            class="btn btn-secondary text-base">
                            {{ $homepageSettings->secondary_cta_text ?: 'Contact Me' }}
                        </a>
                    </div>

                    @if($profile->experience_text)
                        <div class="mt-12 pt-8 border-t border-slate-200/80 dark:border-slate-800/80 flex flex-wrap items-center justify-center gap-6 text-sm text-slate-500 dark:text-slate-400">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.27V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2h12.59l-2.7 2.7a1 1 0 00.7 1.7h3.07a2 2 0 002-2v-4.73"></path></svg>
                                <span class="font-medium text-slate-700 dark:text-slate-200">{{ $profile->experience_text }}</span>
                            </div>
                            @if($profile->location && $profile->location_visible)
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.982 18.724A7.481 7.481 0 0112 20a7.481 7.481 0 01-5.982-2.276m11.964 0A10.954 10.954 0 0012 22c-2.648 0-5.145-.97-7.024-2.545A7.478 7.478 0 0112 17.5a7.478 7.478 0 015.982 2.276z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    <span>{{ $profile->location }}</span>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </section>
    @endif

    @if($section === 'about' && $homepageSettings->about_section_enabled)
        <!-- About Section -->
        <section class="py-16 sm:py-24 bg-white dark:bg-slate-900 border-y border-slate-200/60 dark:border-slate-800">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-4xl mx-auto">
                    <div class="text-center mb-12">
                        <span class="text-xs font-bold uppercase tracking-wider text-primary">Get To Know Me</span>
                        <h2 class="text-3xl sm:text-4xl font-bold text-slate-900 dark:text-white mt-1">About Me</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-center">
                        <div class="md:col-span-1 text-center md:text-left">
                            <div class="p-6 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 shadow-sm">
                                <div class="text-3xl font-extrabold text-primary mb-1">2.5+</div>
                                <div class="text-sm font-semibold text-slate-900 dark:text-white">Years Professional Experience</div>
                                <div class="text-xs text-slate-500 dark:text-slate-400 mt-1">+ 6 Months Intensive Training</div>
                                <div class="mt-4 pt-4 border-t border-slate-200 dark:border-slate-700 text-xs text-slate-600 dark:text-slate-300">
                                    Specialized in Laravel, MySQL & Modern Web Development
                                </div>
                            </div>
                        </div>

                        <div class="md:col-span-2 space-y-4 text-slate-600 dark:text-slate-300">
                            <h3 class="text-xl font-bold text-slate-900 dark:text-white">{{ $profile->title }}</h3>
                            <div class="prose dark:prose-invert max-w-none text-sm sm:text-base">
                                {!! $profile->intro ? nl2br(e($profile->intro)) : ($profile->biography ? Str::limit(strip_tags($profile->biography), 280) : 'Passionate full-stack web developer dedicated to building responsive, reliable web solutions for growing businesses.') !!}
                            </div>
                            <div class="flex flex-wrap gap-4 pt-2">
                                <a href="{{ route('about') }}" class="text-primary font-semibold text-sm hover:underline inline-flex items-center gap-1">
                                    Read Full Profile
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </a>
                                @if($profile->resume_url && $profile->resume_button_visible)
                                    <a href="{{ $profile->resume_url }}" target="_blank" download class="text-slate-600 dark:text-slate-400 hover:text-primary text-sm font-semibold inline-flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1M12 12V2m0 0l-4 4m4-4l4 4M5 14h14a2 2 0 010 4H5a2 2 0 010-4z"></path></svg>
                                        Download CV
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if($section === 'skills' && $homepageSettings->skills_section_enabled && $skills && $skills->isNotEmpty())
        <!-- Skills Section -->
        <section class="py-16 sm:py-24 bg-slate-50 dark:bg-slate-950">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-4xl mx-auto">
                    <div class="text-center mb-12">
                        <span class="text-xs font-bold uppercase tracking-wider text-primary">Core Expertise</span>
                        <h2 class="text-3xl sm:text-4xl font-bold text-slate-900 dark:text-white mt-1">Skills & Technologies</h2>
                        <p class="text-slate-600 dark:text-slate-400 text-sm sm:text-base mt-2 max-w-xl mx-auto">
                            Modern tools and frameworks I leverage to engineer high-performance web products
                        </p>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                        @foreach($skills as $skill)
                            <div class="bg-white dark:bg-slate-900 rounded-xl p-4 text-center border border-slate-200/80 dark:border-slate-800 shadow-sm hover:shadow-md hover:border-primary/40 transition-all duration-200 group">
                                <div class="text-slate-900 dark:text-white font-bold text-base mb-1 group-hover:text-primary transition-colors">{{ $skill->name }}</div>
                                <span class="inline-block text-[11px] px-2 py-0.5 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400">
                                    {{ $skill->category->name ?? 'General' }}
                                </span>
                            </div>
                        @endforeach
                    </div>

                    <div class="text-center mt-10">
                        <a href="{{ route('skills') }}" class="text-primary font-semibold text-sm hover:underline inline-flex items-center gap-1.5">
                            Explore all technical skills
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if($section === 'projects' && $homepageSettings->projects_section_enabled && $featuredProjects->isNotEmpty())
        <!-- Featured Projects Section -->
        <section class="py-16 sm:py-24 bg-white dark:bg-slate-900 border-y border-slate-200/60 dark:border-slate-800">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-6xl mx-auto">
                    <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-12">
                        <div>
                            <span class="text-xs font-bold uppercase tracking-wider text-primary">Portfolio Showcase</span>
                            <h2 class="text-3xl sm:text-4xl font-bold text-slate-900 dark:text-white mt-1">Featured Projects</h2>
                            <p class="text-slate-600 dark:text-slate-400 text-sm sm:text-base mt-2">
                                Genuine web applications built for reliability and real-world clients
                            </p>
                        </div>
                        <div class="mt-4 sm:mt-0">
                            <a href="{{ route('projects') }}" class="btn btn-secondary text-sm">
                                View All Projects
                            </a>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach($featuredProjects as $project)
                            <div class="bg-slate-50 dark:bg-slate-800/80 rounded-2xl border border-slate-200/80 dark:border-slate-700/80 shadow-sm overflow-hidden flex flex-col hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                                @if($project->thumbnail_url)
                                    <div class="overflow-hidden h-48 bg-slate-200 dark:bg-slate-700">
                                        <img src="{{ $project->thumbnail_url }}" alt="{{ $project->title }}"
                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                    </div>
                                @endif
                                <div class="p-6 flex-1 flex flex-col">
                                    <div class="flex items-center justify-between gap-2 mb-2">
                                        <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full bg-primary/10 text-primary">
                                            {{ $project->category ?? 'Web App' }}
                                        </span>
                                    </div>
                                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2 group-hover:text-primary transition-colors">
                                        <a href="{{ route('projects.show', $project->slug) }}">{{ $project->title }}</a>
                                    </h3>
                                    <p class="text-slate-600 dark:text-slate-300 text-sm mb-4 flex-1">
                                        {{ $project->short_description ?? Str::limit(strip_tags($project->description), 110) }}
                                    </p>
                                    @if($project->tech_stack && is_array($project->tech_stack))
                                        <div class="flex flex-wrap gap-1.5 mb-5">
                                            @foreach(array_slice($project->tech_stack, 0, 4) as $tech)
                                                <span class="text-xs px-2 py-0.5 rounded bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-400 border border-slate-200 dark:border-slate-700">
                                                    {{ $tech }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @endif
                                    <div class="pt-4 border-t border-slate-200/80 dark:border-slate-700 flex items-center justify-between">
                                        <a href="{{ route('projects.show', $project->slug) }}" class="text-primary font-semibold text-sm inline-flex items-center gap-1 hover:underline">
                                            Case Study
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                        </a>
                                        <div class="flex items-center gap-2">
                                            @if($project->demo_url)
                                                <a href="{{ $project->demo_url }}" target="_blank" class="text-slate-500 hover:text-primary text-xs" title="Live Demo">Live Demo ↗</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if($section === 'services' && $homepageSettings->services_section_enabled && $featuredServices->isNotEmpty())
        <!-- Services Section -->
        <section class="py-16 sm:py-24 bg-slate-50 dark:bg-slate-950">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-6xl mx-auto">
                    <div class="text-center mb-12">
                        <span class="text-xs font-bold uppercase tracking-wider text-primary">What I Do</span>
                        <h2 class="text-3xl sm:text-4xl font-bold text-slate-900 dark:text-white mt-1">Services & Solutions</h2>
                        <p class="text-slate-600 dark:text-slate-400 text-sm sm:text-base mt-2 max-w-xl mx-auto">
                            Custom full-stack web solutions built to help you grow your business
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach($featuredServices as $service)
                            <div class="bg-white dark:bg-slate-900 rounded-2xl p-6 sm:p-8 border border-slate-200/80 dark:border-slate-800 shadow-sm hover:shadow-lg transition-all duration-300 flex flex-col group">
                                @if($service->icon_url)
                                    <div class="w-14 h-14 rounded-xl bg-primary/10 flex items-center justify-center mb-6 overflow-hidden p-2">
                                        <img src="{{ $service->icon_url }}" alt="{{ $service->name }}" class="w-full h-full object-contain">
                                    </div>
                                @else
                                    <div class="w-14 h-14 rounded-xl bg-primary/10 flex items-center justify-center mb-6 text-primary font-bold text-xl">
                                        {{ substr($service->name, 0, 1) }}
                                    </div>
                                @endif
                                <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3 group-hover:text-primary transition-colors">
                                    <a href="{{ route('services.show', $service->slug) }}">{{ $service->name }}</a>
                                </h3>
                                <p class="text-slate-600 dark:text-slate-300 text-sm mb-6 flex-1">
                                    {{ $service->short_description ?? Str::limit(strip_tags($service->description), 120) }}
                                </p>
                                <div class="pt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between">
                                    @if($service->price_formatted)
                                        <span class="text-base font-bold text-primary">{{ $service->price_formatted }}</span>
                                    @else
                                        <span class="text-xs font-medium text-slate-400">Custom Quote</span>
                                    @endif
                                    <a href="{{ route('services.show', $service->slug) }}" class="text-primary font-semibold text-sm inline-flex items-center gap-1 hover:underline">
                                        Details
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if($section === 'work_process' && $homepageSettings->work_process_section_enabled && $workProcesses->isNotEmpty())
        <!-- Work Process Section -->
        <section class="py-16 sm:py-24 bg-white dark:bg-slate-900 border-y border-slate-200/60 dark:border-slate-800">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-5xl mx-auto">
                    <div class="text-center mb-14">
                        <span class="text-xs font-bold uppercase tracking-wider text-primary">How I Work</span>
                        <h2 class="text-3xl sm:text-4xl font-bold text-slate-900 dark:text-white mt-1">My Work Process</h2>
                        <p class="text-slate-600 dark:text-slate-400 text-sm sm:text-base mt-2 max-w-xl mx-auto">
                            A structured, transparent methodology delivering predictable and high-quality results
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach($workProcesses as $index => $process)
                            <div class="bg-slate-50 dark:bg-slate-800/60 rounded-2xl p-6 text-center border border-slate-200/70 dark:border-slate-700/60 relative shadow-sm">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-primary text-white font-bold text-xs mb-4">
                                    {{ $index + 1 }}
                                </span>
                                @if($process->icon_url)
                                    <div class="w-12 h-12 mx-auto mb-3">
                                        <img src="{{ $process->icon_url }}" alt="{{ $process->title }}" class="w-full h-full object-contain">
                                    </div>
                                @endif
                                <h3 class="font-bold text-base text-slate-900 dark:text-white mb-2">{{ $process->title }}</h3>
                                <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed">{{ Str::limit(strip_tags($process->description), 100) }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if($section === 'testimonials' && $homepageSettings->testimonials_section_enabled && $testimonials->isNotEmpty())
        <!-- Testimonials Section -->
        <section class="py-16 sm:py-24 bg-slate-50 dark:bg-slate-950">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-5xl mx-auto">
                    <div class="text-center mb-12">
                        <span class="text-xs font-bold uppercase tracking-wider text-primary">Client Feedback</span>
                        <h2 class="text-3xl sm:text-4xl font-bold text-slate-900 dark:text-white mt-1">What Clients Say</h2>
                        <p class="text-slate-600 dark:text-slate-400 text-sm sm:text-base mt-2">
                            Genuine endorsements from past projects and team collaborations
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($testimonials as $testimonial)
                            <div class="bg-white dark:bg-slate-900 rounded-2xl p-6 border border-slate-200/80 dark:border-slate-800 shadow-sm flex flex-col justify-between">
                                <p class="text-slate-600 dark:text-slate-300 text-sm italic mb-6">
                                    "{{ Str::limit(strip_tags($testimonial->feedback), 180) }}"
                                </p>
                                <div class="flex items-center gap-3 pt-4 border-t border-slate-100 dark:border-slate-800">
                                    @if($testimonial->image_url)
                                        <img src="{{ $testimonial->image_url }}" alt="{{ $testimonial->name }}" class="w-10 h-10 rounded-full object-cover">
                                    @else
                                        <div class="w-10 h-10 rounded-full bg-primary/10 text-primary font-bold text-sm flex items-center justify-center">
                                            {{ substr($testimonial->name, 0, 1) }}
                                        </div>
                                    @endif
                                    <div>
                                        <div class="font-bold text-sm text-slate-900 dark:text-white">{{ $testimonial->name }}</div>
                                        <div class="text-xs text-slate-500 dark:text-slate-400">{{ $testimonial->role_company }}</div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if($section === 'contact_cta' && $homepageSettings->contact_cta_section_enabled)
        <!-- Contact CTA Section -->
        <section class="py-16 sm:py-24 bg-gradient-to-tr from-slate-900 via-blue-950 to-slate-900 text-white relative overflow-hidden">
            <div class="absolute inset-0 -z-0 opacity-20 bg-[radial-gradient(#3b82f6_1px,transparent_1px)] [background-size:16px_16px]"></div>
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="max-w-3xl mx-auto text-center">
                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight mb-4">
                        {{ $homepageSettings->contact_cta_heading ?: 'Ready to work together?' }}
                    </h2>
                    <p class="text-base sm:text-lg text-blue-200 mb-8 max-w-xl mx-auto">
                        {{ $homepageSettings->contact_cta_description ?: "Let's discuss your next project. I'm available for freelance work and technical consulting." }}
                    </p>
                    <div class="flex flex-wrap gap-4 justify-center">
                        <a href="{{ route('contact') }}" class="btn btn-primary bg-white text-blue-700 hover:bg-blue-50 text-base shadow-lg hover:shadow-xl font-bold">
                            Get In Touch Now
                        </a>
                    </div>
                </div>
            </div>
        </section>
    @endif
@endforeach

@endsection
