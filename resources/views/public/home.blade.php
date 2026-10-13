@extends('public.layouts.app')

@section('title', ($homepageSettings->hero_heading ? $homepageSettings->hero_heading . ' - ' : ($profile->full_name . ' - ')) . $websiteName)
@section('meta_description', $homepageSettings->hero_description ?? (strip_tags($profile->bio) ?? ($profile->intro ?? 'Full Stack Web Developer portfolio specializing in Laravel, PHP, MySQL, and REST APIs.')))

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
        <!-- Hero Section (Two-Column Layout) -->
        <section class="relative pt-28 sm:pt-36 pb-20 sm:pb-28 bg-white border-b border-[#E5E7EB]">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-8 items-center max-w-7xl mx-auto">
                    <!-- Left Column: Introduction & Primary CTAs -->
                    <div class="lg:col-span-7 text-left">
                        @php
                            $isAvailable = \App\Models\Setting::get('available_for_freelance', '1') === '1'
                                || \App\Models\Setting::get('available_for_freelance', true) === true;
                            $yearsExp = \App\Models\Setting::get('years_experience') ?: '2.5+';
                            $trainingText = \App\Models\Setting::get('training_text') ?: '+ 6 Months Intensive Training';
                            $specialization = \App\Models\Setting::get('specialization_text') ?: 'Laravel & MySQL Specialist';
                        @endphp

                        @if($isAvailable)
                            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-[#DCE8D6] text-[#1B560B] font-semibold text-xs sm:text-sm mb-6 shadow-xs">
                                <span class="w-2 h-2 rounded-full bg-[#1B560B] animate-pulse"></span>
                                <span>Available for Freelance Projects</span>
                            </div>
                        @endif

                        <h1 class="text-4xl sm:text-5xl lg:text-[56px] font-extrabold tracking-tight text-[#1F2937] leading-[1.15] mb-3">
                            {{ $homepageSettings->hero_heading ?: ($profile->title ?: 'Full Stack Web Developer') }}
                        </h1>

                        @if($homepageSettings->hero_title)
                            <p class="text-lg sm:text-xl font-semibold text-[#1B560B] mb-4">
                                {{ $homepageSettings->hero_title }}
                            </p>
                        @endif

                        <p class="text-base sm:text-lg text-[#667085] mb-8 leading-relaxed max-w-2xl">
                            {{ $homepageSettings->hero_description ?: 'Specializing in Laravel, PHP, MySQL, and RESTful APIs to build secure, robust, and scalable custom web applications, ERPs, and administrative dashboards.' }}
                        </p>

                        <div class="flex flex-wrap gap-4 items-center mb-10">
                            <a href="{{ $homepageSettings->primary_cta_url ?: route('contact') }}"
                                class="inline-flex items-center justify-center gap-2 px-6 py-3.5 font-medium rounded-lg bg-[#1B560B] text-white hover:bg-[#144208] shadow-sm hover:shadow transition-all duration-200 text-base">
                                {{ $homepageSettings->primary_cta_text ?: 'Hire Me' }}
                                <svg class="w-4 h-4 ml-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                            <a href="{{ $homepageSettings->secondary_cta_url ?: route('projects') }}"
                                class="inline-flex items-center justify-center gap-2 px-6 py-3.5 font-medium rounded-lg bg-white text-[#1F2937] hover:bg-[#F5F7F2] border border-[#E5E7EB] hover:border-[#D1D5DB] transition-all duration-200 text-base">
                                {{ $homepageSettings->secondary_cta_text ?: 'View My Projects' }}
                            </a>
                        </div>

                        <div class="pt-6 border-t border-[#E5E7EB] flex flex-wrap items-center gap-6 text-xs sm:text-sm text-[#667085]">
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-[#1B560B]"></span>
                                <span class="font-medium text-[#1F2937]">{{ $yearsExp }} Years Professional Experience</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-[#1B560B]"></span>
                                <span class="font-medium text-[#1F2937]">{{ ltrim($trainingText, '+ ') }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-[#1B560B]"></span>
                                <span class="font-medium text-[#1F2937]">{{ $specialization }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Clean Code Preview Card / Visual -->
                    <div class="lg:col-span-5">
                        @php
                            $heroImg = $homepageSettings->hero_image_url ?: $profile->profile_photo_url;
                        @endphp

                        @if($heroImg)
                            <div class="relative max-w-sm mx-auto group">
                                <div class="rounded-2xl overflow-hidden border-4 border-white shadow-xl ring-1 ring-[#E5E7EB] transition-transform duration-300 group-hover:scale-[1.02]">
                                    <img src="{{ $heroImg }}" alt="{{ $profile->full_name }}" class="w-full h-auto aspect-square object-cover">
                                </div>
                                <div class="absolute -bottom-4 -left-4 bg-white p-3 rounded-xl border border-[#E5E7EB] shadow-md flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-[#DCE8D6] text-[#1B560B] flex items-center justify-center font-bold text-sm">
                                        PHP
                                    </div>
                                    <div>
                                        <div class="text-xs font-bold text-[#1F2937]">Clean Architecture</div>
                                        <div class="text-[11px] text-[#667085]">Tested &amp; Maintainable</div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="bg-white rounded-2xl border border-[#E5E7EB] shadow-lg overflow-hidden transition-all duration-300 hover:shadow-xl">
                                <!-- Card Header Window -->
                                <div class="bg-[#F5F7F2] px-4 py-3 border-b border-[#E5E7EB] flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <div class="w-3 h-3 rounded-full bg-red-400"></div>
                                        <div class="w-3 h-3 rounded-full bg-amber-400"></div>
                                        <div class="w-3 h-3 rounded-full bg-emerald-400"></div>
                                    </div>
                                    <div class="text-xs font-mono text-[#667085] flex items-center gap-1.5">
                                        <span>ProjectController.php</span>
                                    </div>
                                    <div class="text-[11px] font-semibold text-[#1B560B] bg-[#DCE8D6] px-2 py-0.5 rounded-full">
                                        Production
                                    </div>
                                </div>
                                <!-- Card Content -->
                                <div class="p-6 font-mono text-xs sm:text-[13px] leading-relaxed bg-[#FFFFFF] text-[#1F2937] overflow-x-auto">
                                    <div class="text-purple-700 font-semibold mb-1">namespace <span class="text-[#1F2937]">App\Http\Controllers;</span></div>
                                    <div class="text-[#667085] mb-2">// Full Stack Architecture</div>
                                    <div><span class="text-blue-700 font-bold">class</span> <span class="text-emerald-700 font-bold">ProjectController</span> <span class="text-blue-700 font-bold">extends</span> Controller</div>
                                    <div>{</div>
                                    <div class="pl-4 text-[#667085]">// Deliver high-performance apps</div>
                                    <div class="pl-4"><span class="text-blue-700 font-bold">public function</span> <span class="text-amber-700 font-bold">deploy</span>(Client $client): WebApp</div>
                                    <div class="pl-4">{</div>
                                    <div class="pl-8"><span class="text-blue-700 font-bold">return</span> $this->projects->build([</div>
                                    <div class="pl-12 text-[#1B560B] font-semibold">'backend' => 'Laravel & PHP',</div>
                                    <div class="pl-12 text-[#1B560B] font-semibold">'database' => 'Optimized MySQL',</div>
                                    <div class="pl-12 text-[#1B560B] font-semibold">'apis' => 'Secure RESTful APIs',</div>
                                    <div class="pl-12 text-[#1B560B] font-semibold">'frontend' => 'Responsive UI',</div>
                                    <div class="pl-8">]);</div>
                                    <div class="pl-4">}</div>
                                    <div>}</div>
                                </div>
                                <!-- Card Footer Status -->
                                <div class="px-5 py-3 bg-[#F5F7F2] border-t border-[#E5E7EB] flex items-center justify-between text-xs text-[#667085]">
                                    <span class="flex items-center gap-1.5 text-[#1B560B] font-medium">
                                        <svg class="w-4 h-4 text-[#1B560B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        Tested &amp; Production-Ready
                                    </span>
                                    <span>{{ \App\Models\Setting::get('years_experience') ?: '2.5+' }} Years Experience</span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if($section === 'about' && $homepageSettings->about_section_enabled)
        <!-- About & Experience Section -->
        <section class="py-20 sm:py-28 bg-[#F5F7F2] border-b border-[#E5E7EB]">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-6xl mx-auto">
                    <div class="text-center mb-14">
                        <span class="inline-block text-xs font-bold uppercase tracking-wider text-[#1B560B] bg-[#DCE8D6] px-3 py-1 rounded-full mb-3">Professional Background</span>
                        <h2 class="text-3xl sm:text-4xl font-bold text-[#1F2937] tracking-tight">About &amp; Experience</h2>
                        <p class="text-[#667085] text-base mt-2 max-w-xl mx-auto">
                            Committed to building scalable software, dependable backend architecture, and intuitive user experiences.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                        <!-- Left Experience Card -->
                        <div class="lg:col-span-5 bg-white rounded-2xl p-7 border border-[#E5E7EB] shadow-sm">
                            <div class="text-4xl font-extrabold text-[#1B560B] mb-1">
                                {{ \App\Models\Setting::get('years_experience') ?: '2.5+' }}
                            </div>
                            <div class="text-base font-bold text-[#1F2937]">Years of Professional Experience</div>
                            <div class="text-sm font-semibold text-[#1B560B] bg-[#DCE8D6]/60 px-2.5 py-1 rounded-md inline-block mt-2">
                                {{ \App\Models\Setting::get('training_text') ?: '+ 6 Months Intensive Training' }}
                            </div>

                            <div class="mt-6 pt-6 border-t border-[#E5E7EB] space-y-4 text-sm text-[#667085]">
                                <div class="flex items-start gap-3">
                                    <div class="w-5 h-5 rounded-full bg-[#DCE8D6] text-[#1B560B] flex items-center justify-center shrink-0 mt-0.5">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                    <span>Specialized in <strong>Laravel, PHP &amp; MySQL</strong> database optimization</span>
                                </div>
                                <div class="flex items-start gap-3">
                                    <div class="w-5 h-5 rounded-full bg-[#DCE8D6] text-[#1B560B] flex items-center justify-center shrink-0 mt-0.5">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                    <span>Robust <strong>REST API</strong> architecture and third-party integrations</span>
                                </div>
                                <div class="flex items-start gap-3">
                                    <div class="w-5 h-5 rounded-full bg-[#DCE8D6] text-[#1B560B] flex items-center justify-center shrink-0 mt-0.5">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                    <span>Clean code standards with reliable delivery and transparent communication</span>
                                </div>
                            </div>
                        </div>

                        <!-- Right Details -->
                        <div class="lg:col-span-7 bg-white rounded-2xl p-7 sm:p-9 border border-[#E5E7EB] shadow-sm space-y-5">
                            <h3 class="text-2xl font-bold text-[#1F2937]">{{ $profile->title ?: 'Full Stack Web Developer' }}</h3>
                            <div class="prose max-w-none text-[#667085] text-base leading-relaxed">
                                {!! $profile->intro ? nl2br(e($profile->intro)) : ($profile->biography ? Str::limit(strip_tags($profile->biography), 350) : 'With 2.5 years of commercial software development and 6 months of comprehensive training, I solve real business challenges by building robust backend architectures, custom web applications, and seamless administrative panels.') !!}
                            </div>

                            <div class="pt-4 border-t border-[#E5E7EB] flex flex-wrap gap-4 items-center">
                                <a href="{{ route('about') }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-[#1B560B] hover:text-[#144208] hover:underline">
                                    Read Detailed Background
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </a>

                                @if($profile->resume_url && $profile->resume_button_visible)
                                    <a href="{{ $profile->resume_url }}" target="_blank" download
                                        class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg text-sm font-medium text-[#1F2937] bg-[#F5F7F2] hover:bg-[#E5E7EB] border border-[#E5E7EB] transition-colors">
                                        <svg class="w-4 h-4 text-[#1B560B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1M12 12V2m0 0l-4 4m4-4l4 4M5 14h14a2 2 0 010 4H5a2 2 0 010-4z"></path></svg>
                                        Download Resume
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
        <section class="py-20 sm:py-28 bg-white border-b border-[#E5E7EB]">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-6xl mx-auto">
                    <div class="text-center mb-14">
                        <span class="inline-block text-xs font-bold uppercase tracking-wider text-[#1B560B] bg-[#DCE8D6] px-3 py-1 rounded-full mb-3">Core Expertise</span>
                        <h2 class="text-3xl sm:text-4xl font-bold text-[#1F2937] tracking-tight">Skills &amp; Technologies</h2>
                        <p class="text-[#667085] text-base mt-2 max-w-xl mx-auto">
                            Modern stack and tools applied in commercial web application engineering.
                        </p>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                        @foreach($skills as $skill)
                            <div class="bg-[#F5F7F2] rounded-xl p-4 text-center border border-[#E5E7EB] hover:border-[#1B560B] transition-all duration-200 group">
                                <div class="text-[#1F2937] font-bold text-base mb-1 group-hover:text-[#1B560B] transition-colors">
                                    {{ $skill->name }}
                                </div>
                                <span class="inline-block text-[11px] px-2.5 py-0.5 rounded-full bg-white text-[#667085] border border-[#E5E7EB]">
                                    {{ $skill->category->name ?? 'General' }}
                                </span>
                            </div>
                        @endforeach
                    </div>

                    <div class="text-center mt-12">
                        <a href="{{ route('skills') }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-[#1B560B] hover:text-[#144208] hover:underline">
                            Explore full skill matrix &amp; tools
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if($section === 'projects' && $homepageSettings->projects_section_enabled && $featuredProjects->isNotEmpty())
        <!-- Projects Section — Highest Priority -->
        <section class="py-20 sm:py-28 bg-[#F5F7F2] border-b border-[#E5E7EB]">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-7xl mx-auto">
                    <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-14">
                        <div>
                            <span class="inline-block text-xs font-bold uppercase tracking-wider text-[#1B560B] bg-[#DCE8D6] px-3 py-1 rounded-full mb-3">Portfolio Showcase</span>
                            <h2 class="text-3xl sm:text-4xl font-bold text-[#1F2937] tracking-tight">Featured Projects</h2>
                            <p class="text-[#667085] text-base mt-2 max-w-xl">
                                Real web applications, APIs, and business platforms built for genuine clients.
                            </p>
                        </div>
                        <div class="mt-4 sm:mt-0">
                            <a href="{{ route('projects') }}"
                                class="inline-flex items-center gap-1 px-4 py-2.5 rounded-lg text-sm font-medium bg-white text-[#1F2937] border border-[#E5E7EB] hover:bg-[#F5F7F2] transition-colors">
                                View All Projects
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </a>
                        </div>
                    </div>

                    <!-- 3-Column Responsive Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach($featuredProjects as $project)
                            <div class="bg-white rounded-2xl border border-[#E5E7EB] shadow-xs hover:shadow-lg transition-all duration-300 flex flex-col overflow-hidden group">
                                <a href="{{ route('projects.show', $project->slug) }}" class="relative block aspect-[16/9] overflow-hidden bg-[#F5F7F2]">
                                    @if($project->thumbnail_url)
                                        <img src="{{ $project->thumbnail_url }}" alt="{{ $project->title }}"
                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-[#667085]">
                                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                    @endif
                                    <div class="absolute top-3 right-3 flex gap-2">
                                        <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-[#DCE8D6] text-[#1B560B]">
                                            {{ $project->category ?? 'Web Application' }}
                                        </span>
                                    </div>
                                </a>

                                <div class="p-6 flex-1 flex flex-col">
                                    <h3 class="text-xl font-bold text-[#1F2937] mb-2 group-hover:text-[#1B560B] transition-colors">
                                        <a href="{{ route('projects.show', $project->slug) }}">{{ $project->title }}</a>
                                    </h3>

                                    <p class="text-[#667085] text-sm mb-4 line-clamp-2 flex-1">
                                        {{ $project->short_description ?? Str::limit(strip_tags($project->description), 110) }}
                                    </p>

                                    @if($project->role)
                                        <div class="mb-3">
                                            <span class="inline-block text-[11px] font-medium text-[#1B560B] bg-[#DCE8D6]/60 px-2 py-0.5 rounded">
                                                Role: {{ $project->role }}
                                            </span>
                                        </div>
                                    @endif

                                    @if($project->tech_stack && is_array($project->tech_stack))
                                        <div class="flex flex-wrap gap-1.5 mb-5">
                                            @foreach(array_slice($project->tech_stack, 0, 4) as $tech)
                                                <span class="text-xs px-2.5 py-0.5 rounded bg-[#F5F7F2] text-[#1F2937] border border-[#E5E7EB]">
                                                    {{ $tech }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @endif

                                    <div class="pt-4 border-t border-[#E5E7EB] flex items-center justify-between mt-auto">
                                        <a href="{{ route('projects.show', $project->slug) }}" class="text-[#1B560B] hover:text-[#144208] font-semibold text-sm inline-flex items-center gap-1 hover:underline">
                                            View Details
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                        </a>

                                        <div class="flex items-center gap-3">
                                            @if($project->github_url)
                                                <a href="{{ $project->github_url }}" target="_blank" class="text-[#667085] hover:text-[#1B560B] text-xs font-medium" title="GitHub Source">GitHub ↗</a>
                                            @endif
                                            @if($project->demo_url)
                                                <a href="{{ $project->demo_url }}" target="_blank" class="text-[#667085] hover:text-[#1B560B] text-xs font-medium" title="Live Demo">Live Demo ↗</a>
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
        <section class="py-20 sm:py-28 bg-white border-b border-[#E5E7EB]">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-7xl mx-auto">
                    <div class="text-center mb-14">
                        <span class="inline-block text-xs font-bold uppercase tracking-wider text-[#1B560B] bg-[#DCE8D6] px-3 py-1 rounded-full mb-3">What I Offer</span>
                        <h2 class="text-3xl sm:text-4xl font-bold text-[#1F2937] tracking-tight">Services &amp; Solutions</h2>
                        <p class="text-[#667085] text-base mt-2 max-w-xl mx-auto">
                            Custom software engineering tailored to solve real technical and operational bottlenecks.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach($featuredServices as $service)
                            <div class="bg-white rounded-2xl p-7 border border-[#E5E7EB] shadow-xs hover:shadow-lg transition-all duration-300 flex flex-col group">
                                <div class="w-12 h-12 rounded-xl bg-[#DCE8D6] text-[#1B560B] flex items-center justify-center mb-5 font-bold text-lg">
                                    @if($service->icon_url)
                                        <img src="{{ $service->icon_url }}" alt="{{ $service->name }}" class="w-7 h-7 object-contain">
                                    @else
                                        {{ substr($service->name, 0, 1) }}
                                    @endif
                                </div>

                                <h3 class="text-xl font-bold text-[#1F2937] mb-2 group-hover:text-[#1B560B] transition-colors">
                                    <a href="{{ route('services.show', $service->slug) }}">{{ $service->name }}</a>
                                </h3>

                                <p class="text-[#667085] text-sm mb-6 flex-1 leading-relaxed">
                                    {{ $service->short_description ?? Str::limit(strip_tags($service->description), 130) }}
                                </p>

                                <div class="pt-4 border-t border-[#E5E7EB] flex items-center justify-between mt-auto">
                                    <span class="text-xs text-[#667085]">Free estimate on request</span>

                                    <a href="{{ route('contact', ['service' => $service->slug]) }}"
                                        class="inline-flex items-center gap-1 text-sm font-semibold text-[#1B560B] hover:text-[#144208] hover:underline">
                                        Get a Quote
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
        <section class="py-20 sm:py-28 bg-[#F5F7F2] border-b border-[#E5E7EB]">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-6xl mx-auto">
                    <div class="text-center mb-14">
                        <span class="inline-block text-xs font-bold uppercase tracking-wider text-[#1B560B] bg-[#DCE8D6] px-3 py-1 rounded-full mb-3">Structured Methodology</span>
                        <h2 class="text-3xl sm:text-4xl font-bold text-[#1F2937] tracking-tight">How I Work</h2>
                        <p class="text-[#667085] text-base mt-2 max-w-xl mx-auto">
                            A clear, predictable process focused on communication, quality, and on-time delivery.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($workProcesses as $index => $process)
                            <div class="bg-white rounded-2xl p-6 text-center border border-[#E5E7EB] shadow-xs relative">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-[#1B560B] text-white font-bold text-xs mb-4">
                                    {{ $index + 1 }}
                                </span>
                                <h3 class="font-bold text-base text-[#1F2937] mb-2">{{ $process->title }}</h3>
                                <p class="text-xs text-[#667085] leading-relaxed">{{ Str::limit(strip_tags($process->description), 110) }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if($section === 'testimonials' && $homepageSettings->testimonials_section_enabled && $testimonials->isNotEmpty())
        <!-- Testimonials Section -->
        <section class="py-20 sm:py-28 bg-white border-b border-[#E5E7EB]">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-6xl mx-auto">
                    <div class="text-center mb-14">
                        <span class="inline-block text-xs font-bold uppercase tracking-wider text-[#1B560B] bg-[#DCE8D6] px-3 py-1 rounded-full mb-3">Client Feedback</span>
                        <h2 class="text-3xl sm:text-4xl font-bold text-[#1F2937] tracking-tight">Testimonials</h2>
                        <p class="text-[#667085] text-base mt-2 max-w-xl mx-auto">
                            Endorsements from clients and engineering partners.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($testimonials as $testimonial)
                            <div class="bg-[#F5F7F2] rounded-2xl p-6 border border-[#E5E7EB] flex flex-col justify-between">
                                <p class="text-[#1F2937] text-sm italic mb-6 leading-relaxed">
                                    "{{ Str::limit(strip_tags($testimonial->feedback), 190) }}"
                                </p>
                                <div class="flex items-center gap-3 pt-4 border-t border-[#E5E7EB]">
                                    @if($testimonial->image_url)
                                        <img src="{{ $testimonial->image_url }}" alt="{{ $testimonial->name }}" class="w-10 h-10 rounded-full object-cover">
                                    @else
                                        <div class="w-10 h-10 rounded-full bg-[#DCE8D6] text-[#1B560B] font-bold text-sm flex items-center justify-center">
                                            {{ substr($testimonial->name, 0, 1) }}
                                        </div>
                                    @endif
                                    <div>
                                        <div class="font-bold text-sm text-[#1F2937]">{{ $testimonial->name }}</div>
                                        <div class="text-xs text-[#667085]">{{ $testimonial->role_company }}</div>
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
        <section class="py-20 sm:py-28 bg-[#142018] text-white relative overflow-hidden">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="max-w-3xl mx-auto text-center">
                    <span class="inline-block text-xs font-bold uppercase tracking-wider text-[#DCE8D6] bg-[#1B560B] px-3.5 py-1 rounded-full mb-4">Let's Connect</span>
                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-[#F9FAFB] mb-4">
                        {{ $homepageSettings->contact_cta_heading ?: 'Have a Project in Mind?' }}
                    </h2>
                    <p class="text-base sm:text-lg text-gray-300 mb-8 max-w-xl mx-auto leading-relaxed">
                        {{ $homepageSettings->contact_cta_description ?: "Let's discuss your technical requirements. I am available for freelance web development and software consulting." }}
                    </p>
                    <div class="flex flex-wrap gap-4 justify-center">
                        <a href="{{ route('contact') }}"
                            class="inline-flex items-center justify-center gap-2 px-7 py-3.5 rounded-lg bg-[#1B560B] hover:bg-[#144208] text-white text-base font-semibold shadow-md transition-all">
                            Send Project Enquiry
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    @endif
@endforeach

@endsection
