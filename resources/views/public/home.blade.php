@extends('public.layouts.app')

@section('title', ($homepageSettings->hero_heading ? $homepageSettings->hero_heading . ' - ' : ($profile->full_name . ' - ')) . $websiteName)
@section('meta_description', $homepageSettings->hero_description ?? (strip_tags($profile->bio) ?? ($profile->intro ?? 'Full Stack Web Developer portfolio specializing in Laravel, PHP, MySQL, and REST APIs.')))

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
        <!-- Hero Section (Dynamic, Animated & Dark Tech Aesthetic) -->
        <section id="hero" class="relative pt-28 sm:pt-36 pb-20 sm:pb-32 bg-[#080C14] border-b border-slate-800/80 overflow-hidden">
            <!-- Ambient Glowing Lighting & Dot Grid Background -->
            <div class="absolute inset-0 bg-grid-dots-dark opacity-40 pointer-events-none"></div>
            <div class="absolute -top-32 -left-20 w-[550px] h-[550px] bg-emerald-500/15 rounded-full blur-3xl pointer-events-none animate-pulse-glow"></div>
            <div class="absolute top-1/4 -right-20 w-[480px] h-[480px] bg-teal-500/10 rounded-full blur-3xl pointer-events-none animate-float-delayed"></div>
            <div class="absolute bottom-10 left-1/3 w-[350px] h-[350px] bg-cyan-500/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
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
                            <div class="inline-flex items-center gap-2.5 px-4 py-1.5 rounded-full bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 font-semibold text-xs sm:text-sm mb-6 shadow-xs backdrop-blur-md animate-fade-in">
                                <span class="relative flex h-2.5 w-2.5">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                                </span>
                                <span>Available for Freelance &amp; Contract Projects</span>
                            </div>
                        @endif

                        <h1 class="text-4xl sm:text-5xl lg:text-[58px] font-extrabold tracking-tight text-white leading-[1.12] mb-3">
                            {{ $homepageSettings->hero_heading ?: ($profile->title ?: 'Full Stack Web Developer') }}
                        </h1>

                        <!-- Dynamic Animated Typing Specialty (Locked height & zero layout shift) -->
                        <div x-data="{
                            roles: [
                                '{{ $homepageSettings->hero_title ?: 'Laravel & PHP Specialist' }}',
                                'High-Performance REST APIs',
                                'MySQL Database Optimization',
                                'Custom Web Apps & ERP Panels'
                            ],
                            roleIndex: 0,
                            text: '{{ $homepageSettings->hero_title ?: 'Laravel & PHP Specialist' }}',
                            isDeleting: true,
                            init() {
                                setTimeout(() => this.type(), 2200);
                            },
                            type() {
                                const current = this.roles[this.roleIndex];
                                if (this.isDeleting) {
                                    this.text = current.substring(0, this.text.length - 1);
                                } else {
                                    this.text = current.substring(0, this.text.length + 1);
                                }

                                let delta = this.isDeleting ? 40 : 85;

                                if (!this.isDeleting && this.text === current) {
                                    delta = 2200;
                                    this.isDeleting = true;
                                } else if (this.isDeleting && this.text === '') {
                                    this.isDeleting = false;
                                    this.roleIndex = (this.roleIndex + 1) % this.roles.length;
                                    delta = 400;
                                }

                                setTimeout(() => this.type(), delta);
                            }
                        }" class="h-10 sm:h-12 flex items-center mb-4 overflow-hidden">
                            <span class="text-xl sm:text-2xl lg:text-3xl font-extrabold bg-gradient-to-r from-emerald-400 via-teal-300 to-cyan-400 bg-clip-text text-transparent animate-text-shimmer leading-none"
                                  x-text="text">
                                {{ $homepageSettings->hero_title ?: 'Laravel & PHP Specialist' }}
                            </span>
                            <span class="inline-block w-[3px] h-6 sm:h-7 bg-emerald-400 ml-1.5 rounded-full cursor-blink shrink-0"></span>
                        </div>

                        <p class="text-base sm:text-lg text-slate-300 mb-8 leading-relaxed max-w-2xl font-normal">
                            {{ $homepageSettings->hero_description ?: 'Specializing in Laravel, PHP, MySQL, and RESTful APIs to build secure, robust, and scalable custom web applications, ERPs, and administrative dashboards.' }}
                        </p>

                        <div class="flex flex-wrap gap-4 items-center mb-10">
                            <a href="#contact"
                                class="btn-shimmer-effect inline-flex items-center justify-center gap-2 px-7 py-3.5 font-semibold rounded-xl bg-gradient-to-r from-emerald-600 to-teal-500 hover:from-emerald-500 hover:to-teal-400 text-white shadow-lg shadow-emerald-500/25 hover:shadow-emerald-500/40 hover:-translate-y-0.5 transition-all duration-200 text-base">
                                <span>Get in Touch</span>
                                <svg class="w-4 h-4 ml-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                            <a href="#projects"
                                class="inline-flex items-center justify-center gap-2 px-7 py-3.5 font-medium rounded-xl bg-slate-900/90 text-slate-200 hover:text-white hover:bg-slate-800 border border-slate-700/80 hover:border-emerald-500/50 hover:-translate-y-0.5 shadow-md transition-all duration-200 text-base backdrop-blur-md">
                                View Projects
                            </a>
                            @if($profile->resume_url && $profile->resume_button_visible)
                                <a href="{{ $profile->resume_url }}" target="_blank" rel="noopener noreferrer" download
                                    class="inline-flex items-center justify-center gap-2 px-5 py-3.5 font-medium rounded-xl text-slate-300 hover:text-emerald-400 bg-slate-900/50 hover:bg-slate-900 border border-slate-800 hover:border-emerald-500/30 transition-all duration-200 text-sm">
                                    <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1M12 12V2m0 0l-4 4m4-4l4 4M5 14h14a2 2 0 010 4H5a2 2 0 010-4z"></path></svg>
                                    Download CV
                                </a>
                            @endif

                            @php
                                $contactEmail = $profile->contact_email ?: ($profile->email ?: null);
                            @endphp
                            @if($contactEmail)
                                <button type="button"
                                    x-data="{ copied: false }"
                                    @click="navigator.clipboard.writeText('{{ $contactEmail }}'); copied = true; setTimeout(() => copied = false, 2500)"
                                    class="inline-flex items-center justify-center gap-2 px-4 py-3.5 rounded-xl bg-slate-900/60 hover:bg-slate-900 text-slate-300 hover:text-white border border-slate-800 hover:border-emerald-500/40 transition-all duration-200 text-sm group"
                                    title="Click to copy email">
                                    <svg x-show="!copied" class="w-4 h-4 text-emerald-400 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                    <svg x-show="copied" x-cloak class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                    <span x-text="copied ? 'Email Copied! ✓' : 'Copy Email'">Copy Email</span>
                                </button>
                            @endif
                        </div>

                        <!-- 3 Sleek Stat Cards with Spotlight & Count-Up -->
                        <div class="pt-6 border-t border-slate-800/80 grid grid-cols-1 sm:grid-cols-3 gap-3.5 text-left">
                            <div class="p-4 rounded-xl bg-[#0D1526]/80 border border-slate-800/80 hover:border-emerald-500/40 hover:bg-[#111A2E] card-glow-hover card-spotlight transition-all duration-200 group">
                                <div class="stat-counter text-2xl sm:text-3xl font-extrabold text-emerald-400 mb-0.5 group-hover:scale-105 transition-transform origin-left"
                                     data-target="{{ floatval($yearsExp) ?: 2.5 }}" data-suffix="+ Years">{{ $yearsExp }} Years</div>
                                <div class="text-xs font-semibold text-white">Commercial Exp</div>
                                <div class="text-[11px] text-slate-400">Production software</div>
                            </div>
                            <div class="p-4 rounded-xl bg-[#0D1526]/80 border border-slate-800/80 hover:border-emerald-500/40 hover:bg-[#111A2E] card-glow-hover card-spotlight transition-all duration-200 group">
                                <div class="stat-counter text-2xl sm:text-3xl font-extrabold text-teal-400 mb-0.5 group-hover:scale-105 transition-transform origin-left"
                                     data-target="6" data-suffix=" Months">6 Months</div>
                                <div class="text-xs font-semibold text-white">Intensive Training</div>
                                <div class="text-[11px] text-slate-400">Advanced PHP &amp; DB</div>
                            </div>
                            <div class="p-4 rounded-xl bg-[#0D1526]/80 border border-slate-800/80 hover:border-emerald-500/40 hover:bg-[#111A2E] card-glow-hover card-spotlight transition-all duration-200 group">
                                <div class="stat-counter text-2xl sm:text-3xl font-extrabold text-cyan-400 mb-0.5 group-hover:scale-105 transition-transform origin-left"
                                     data-target="100" data-suffix="% Ready">Full Stack</div>
                                <div class="text-xs font-semibold text-white">Laravel &amp; MySQL</div>
                                <div class="text-[11px] text-slate-400">REST APIs &amp; Dashboards</div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Interactive Artisan Terminal & Developer Visual -->
                    <div x-data="{
                        viewMode: 'terminal',
                        activeCmd: 'about',
                        cmdInput: 'php artisan about',
                        isTyping: false,
                        displayedOutput: 'about',
                        run(cmdKey, cmdName) {
                            if (this.isTyping || this.activeCmd === cmdKey) return;
                            this.activeCmd = cmdKey;
                            this.isTyping = true;
                            this.cmdInput = '';
                            const full = 'php artisan ' + cmdName;
                            let i = 0;
                            const timer = setInterval(() => {
                                if (i < full.length) {
                                    this.cmdInput += full.charAt(i);
                                    i++;
                                } else {
                                    clearInterval(timer);
                                    this.isTyping = false;
                                    this.displayedOutput = cmdKey;
                                }
                            }, 24);
                        }
                    }" class="lg:col-span-5 relative">
                        <!-- Floating Pill 1: Laravel -->
                        <div class="hidden sm:flex absolute -top-5 -right-2 z-20 items-center gap-2 px-3.5 py-1.5 rounded-xl bg-[#0D1526]/95 border border-slate-700 shadow-xl shadow-black/50 animate-float-slow">
                            <span class="w-2.5 h-2.5 rounded-full bg-red-500 animate-pulse"></span>
                            <span class="text-xs font-bold text-white">Laravel 12 &amp; PHP 8.2+</span>
                        </div>

                        <!-- Floating Pill 2: MySQL -->
                        <div class="hidden sm:flex absolute -bottom-5 -left-4 z-20 items-center gap-2 px-3.5 py-1.5 rounded-xl bg-[#0D1526]/95 border border-slate-700 shadow-xl shadow-black/50 animate-float-delayed">
                            <span class="w-2.5 h-2.5 rounded-full bg-blue-400"></span>
                            <span class="text-xs font-bold text-white">MySQL 8.0 Optimized</span>
                        </div>

                        @php
                            $heroImg = $homepageSettings->hero_image_url ?: $profile->profile_photo_url;
                        @endphp

                        <!-- Terminal Container -->
                        <div x-show="viewMode === 'terminal'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" class="relative group">
                            <div class="absolute -inset-1 bg-gradient-to-r from-emerald-500/25 via-teal-500/20 to-cyan-500/25 rounded-3xl blur-lg group-hover:blur-xl transition-all duration-300"></div>
                            <div class="relative bg-[#0A0F1D] rounded-2xl border border-slate-800 shadow-2xl overflow-hidden transition-all duration-300 group-hover:border-emerald-500/40">
                                <!-- Terminal Top Window Header -->
                                <div class="bg-slate-900/90 px-4 py-3 border-b border-slate-800 flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <span class="w-3 h-3 rounded-full bg-red-500/90 inline-block"></span>
                                        <span class="w-3 h-3 rounded-full bg-amber-500/90 inline-block"></span>
                                        <span class="w-3 h-3 rounded-full bg-emerald-500/90 inline-block"></span>
                                        <span class="text-[11px] font-mono text-slate-400 ml-1.5 hidden sm:inline">rohit@srv: ~/portfolio</span>
                                    </div>

                                    @if($heroImg)
                                        <div class="flex items-center gap-1 bg-slate-950 p-1 rounded-lg border border-slate-800 text-[11px]">
                                            <button type="button" @click="viewMode = 'terminal'" :class="viewMode === 'terminal' ? 'bg-emerald-500/20 text-emerald-400 font-bold' : 'text-slate-400 hover:text-white'" class="px-2.5 py-0.5 rounded transition-colors flex items-center gap-1">
                                                <span>💻</span> Terminal
                                            </button>
                                            <button type="button" @click="viewMode = 'photo'" :class="viewMode === 'photo' ? 'bg-emerald-500/20 text-emerald-400 font-bold' : 'text-slate-400 hover:text-white'" class="px-2.5 py-0.5 rounded transition-colors flex items-center gap-1">
                                                <span>👤</span> Photo
                                            </button>
                                        </div>
                                    @else
                                        <div class="text-[11px] font-semibold text-emerald-300 bg-emerald-500/15 border border-emerald-500/30 px-2.5 py-0.5 rounded-full flex items-center gap-1">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                            Artisan v12
                                        </div>
                                    @endif
                                </div>

                                <!-- Terminal Quick Command Actions -->
                                <div class="px-4 py-2.5 bg-[#0D1424] border-b border-slate-800/80 flex items-center gap-1.5 overflow-x-auto text-xs font-mono">
                                    <span class="text-slate-400 text-[11px] mr-1 hidden sm:inline">Run:</span>
                                    <button type="button" @click="run('about', 'about')" :class="activeCmd === 'about' ? 'bg-emerald-500/20 text-emerald-300 border-emerald-500/40' : 'bg-slate-900 text-slate-400 border-slate-800 hover:text-white'" class="px-2.5 py-1 rounded-md border text-[11px] font-medium transition-all whitespace-nowrap">
                                        $ about
                                    </button>
                                    <button type="button" @click="run('test', 'test --pest')" :class="activeCmd === 'test' ? 'bg-emerald-500/20 text-emerald-300 border-emerald-500/40' : 'bg-slate-900 text-slate-400 border-slate-800 hover:text-white'" class="px-2.5 py-1 rounded-md border text-[11px] font-medium transition-all whitespace-nowrap">
                                        $ test:run
                                    </button>
                                    <button type="button" @click="run('routes', 'route:list --path=api')" :class="activeCmd === 'routes' ? 'bg-emerald-500/20 text-emerald-300 border-emerald-500/40' : 'bg-slate-900 text-slate-400 border-slate-800 hover:text-white'" class="px-2.5 py-1 rounded-md border text-[11px] font-medium transition-all whitespace-nowrap">
                                        $ routes:api
                                    </button>
                                    <button type="button" @click="run('status', 'developer:status')" :class="activeCmd === 'status' ? 'bg-emerald-500/20 text-emerald-300 border-emerald-500/40' : 'bg-slate-900 text-slate-400 border-slate-800 hover:text-white'" class="px-2.5 py-1 rounded-md border text-[11px] font-medium transition-all whitespace-nowrap">
                                        $ status
                                    </button>
                                </div>

                                <!-- Terminal Screen Output -->
                                <div class="p-5 font-mono text-xs sm:text-[13px] leading-relaxed bg-[#070B14] min-h-[220px] flex flex-col justify-between">
                                    <div>
                                        <!-- Active Command Line -->
                                        <div class="flex items-center gap-2 text-slate-300 mb-3 pb-2 border-b border-slate-900">
                                            <span class="text-emerald-400 font-bold">$</span>
                                            <span class="text-white font-semibold" x-text="cmdInput">php artisan about</span>
                                            <span class="inline-block w-2 h-4 bg-emerald-400 cursor-blink ml-0.5" x-show="isTyping"></span>
                                        </div>

                                        <!-- Command 1: About -->
                                        <div x-show="displayedOutput === 'about'" class="space-y-1.5 text-slate-300 animate-fade-in">
                                            <div class="text-purple-400 font-bold">Laravel Framework <span class="text-emerald-400 font-normal">v12.x</span> • PHP <span class="text-teal-400 font-normal">v8.2+</span></div>
                                            <div class="text-slate-400 text-xs"><span class="text-cyan-400">Environment:</span> Production (Linux x86_64)</div>
                                            <div class="text-slate-400 text-xs"><span class="text-cyan-400">Architecture:</span> Clean Domain-Driven / REST API</div>
                                            <div class="text-slate-400 text-xs"><span class="text-cyan-400">Database:</span> MySQL 8.0 (Indexed, 0 N+1 Queries)</div>
                                            <div class="text-slate-400 text-xs"><span class="text-cyan-400">Performance:</span> <span class="text-emerald-400 font-bold">100/100 Core Web Vitals</span></div>
                                        </div>

                                        <!-- Command 2: Test -->
                                        <div x-show="displayedOutput === 'test'" class="space-y-1 text-slate-300 animate-fade-in text-xs">
                                            <div class="text-emerald-400 font-bold">PASS  Tests\Feature\AuthApiSecurityTest</div>
                                            <div class="text-slate-400 pl-3">✓ rate-limiting, sanitize input &amp; CSRF <span class="text-slate-500">(12ms)</span></div>
                                            <div class="text-emerald-400 font-bold">PASS  Tests\Feature\ProjectServiceTest</div>
                                            <div class="text-slate-400 pl-3">✓ cached query response under 20ms <span class="text-slate-500">(8ms)</span></div>
                                            <div class="text-emerald-400 font-bold">PASS  Tests\Unit\DatabaseSchemaTest</div>
                                            <div class="text-slate-400 pl-3">✓ foreign keys &amp; zero orphaned rows <span class="text-slate-500">(6ms)</span></div>
                                            <div class="pt-1.5 text-[11px] text-slate-400 border-t border-slate-800/80">
                                                <span class="text-emerald-400 font-bold">Tests: 18 passed</span> (48 assertions) • <span class="text-teal-400">Time: 0.26s</span>
                                            </div>
                                        </div>

                                        <!-- Command 3: Routes API -->
                                        <div x-show="displayedOutput === 'routes'" class="space-y-1 font-mono text-[11px] sm:text-xs text-slate-300 animate-fade-in">
                                            <div><span class="text-emerald-400 font-bold">GET|HEAD</span>  api/v1/projects ........ <span class="text-slate-400">ProjectController@index</span></div>
                                            <div><span class="text-blue-400 font-bold">POST</span>      api/v1/projects ........ <span class="text-slate-400">ProjectController@store</span></div>
                                            <div><span class="text-emerald-400 font-bold">GET|HEAD</span>  api/v1/metrics ......... <span class="text-slate-400">MetricController@realtime</span></div>
                                            <div><span class="text-amber-400 font-bold">PUT</span>       api/v1/settings ........ <span class="text-slate-400">SettingController@update</span></div>
                                            <div class="pt-1 text-[11px] text-slate-500">4 protected endpoints [JWT Auth, Throttled: 60/min]</div>
                                        </div>

                                        <!-- Command 4: Developer Status -->
                                        <div x-show="displayedOutput === 'status'" class="space-y-1 text-slate-300 animate-fade-in text-xs">
                                            <div class="text-emerald-400 font-bold">● Service Status: ALL SYSTEMS OPERATIONAL</div>
                                            <div class="text-slate-400">Developer: <span class="text-white font-bold">{{ $profile->full_name }}</span></div>
                                            <div class="text-slate-400">Commercial Experience: <span class="text-white font-bold">{{ \App\Models\Setting::get('years_experience') ?: '2.5+' }} Years</span></div>
                                            <div class="text-slate-400">Status: <span class="text-emerald-400 font-bold">🟢 Open for Freelance &amp; Full-Time</span></div>
                                            <div class="text-slate-400">Response SLA: <span class="text-teal-300 font-bold">&lt; 2 Hours</span></div>
                                        </div>
                                    </div>

                                    <!-- Bottom Terminal Status Bar -->
                                    <div class="mt-4 pt-3 border-t border-slate-900 flex items-center justify-between text-[11px] text-slate-500">
                                        <span class="flex items-center gap-1.5 text-emerald-400">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                            Ready for deployment
                                        </span>
                                        <span class="text-slate-400">utf-8 • bash</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Photo Container (If hero image exists and user selects Photo tab) -->
                        @if($heroImg)
                            <div x-show="viewMode === 'photo'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" class="relative max-w-sm mx-auto group" style="display: none;">
                                <div class="absolute -inset-1.5 bg-gradient-to-r from-emerald-500/30 via-teal-500/20 to-cyan-500/30 rounded-3xl blur-xl group-hover:blur-2xl transition-all duration-300"></div>
                                <div class="relative aspect-square w-full rounded-2xl overflow-hidden border-2 border-emerald-500/40 shadow-2xl shadow-emerald-950/50 bg-[#0D1526] transition-transform duration-300 group-hover:scale-[1.02]">
                                    <img src="{{ $heroImg }}" alt="{{ $profile->full_name }}" width="380" height="380" fetchpriority="high" decoding="async" sizes="(min-width: 1024px) 380px, 100vw" class="w-full h-full object-cover">

                                    <div class="absolute top-3 right-3 z-20">
                                        <button type="button" @click="viewMode = 'terminal'" class="bg-slate-950/90 hover:bg-slate-900 border border-emerald-500/40 text-emerald-400 text-xs px-3 py-1.5 rounded-xl shadow-lg flex items-center gap-1.5 backdrop-blur-md transition-all font-semibold">
                                            <span>💻</span> Switch to Terminal
                                        </button>
                                    </div>
                                </div>
                                <div class="absolute -bottom-4 -left-4 bg-[#0D1526]/95 backdrop-blur-md p-3.5 rounded-xl border border-slate-700 shadow-xl flex items-center gap-3 z-10">
                                    <div class="w-10 h-10 rounded-lg bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 flex items-center justify-center font-bold text-sm shadow-xs">
                                        PHP
                                    </div>
                                    <div>
                                        <div class="text-xs font-bold text-white">Clean Architecture</div>
                                        <div class="text-[11px] text-slate-400">Tested &amp; Scalable Code</div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if($section === 'hero')
    <!-- Infinite Tech Stack Logo Marquee (Pure CSS, 60fps, Zero Render-Blocking) -->
    <section class="py-9 bg-[#070B14] border-b border-slate-800/80 relative overflow-hidden" aria-label="Core Technologies Marquee">
        <div class="container mx-auto px-4 mb-5 text-center">
            <span class="inline-flex items-center gap-2 text-[11px] sm:text-xs font-bold uppercase tracking-wider text-slate-400 bg-slate-900/80 border border-slate-800 px-3.5 py-1 rounded-full shadow-xs">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                Core Tech Stack &amp; Production Tooling
            </span>
        </div>

        <div class="marquee-mask relative w-full overflow-hidden">
            <div class="animate-marquee flex items-center gap-4 sm:gap-6">
                <!-- Group 1 -->
                <div class="inline-flex items-center gap-2.5 px-4 py-2.5 rounded-xl bg-slate-900/90 border border-slate-800 hover:border-emerald-500/40 text-slate-200 transition-colors shrink-0 shadow-sm">
                    <svg class="w-5 h-5 text-red-500 shrink-0" viewBox="0 0 24 24" fill="currentColor"><path d="M23.64 12.2a1 1 0 00-.51-.87L13.8 6.1a1 1 0 00-1 0L3.48 11.45a1 1 0 00-.48.86v7.38a1 1 0 00.5.87l9.32 5.23a1 1 0 001 0l9.32-5.23a1 1 0 00.5-.87v-7.49zm-10.32-4.1l6.73 3.77-3.23 1.81-6.73-3.77 3.23-1.81zm-7.82 5.02l6.82 3.82v6.64l-6.82-3.82v-6.64zm8.82 10.46v-6.64l6.82-3.82v6.64l-6.82 3.82z"/></svg>
                    <span class="text-xs sm:text-sm font-bold text-white">Laravel 12</span>
                    <span class="text-[10px] text-emerald-400 font-semibold bg-emerald-500/10 px-1.5 py-0.5 rounded">MVC Core</span>
                </div>

                <div class="inline-flex items-center gap-2.5 px-4 py-2.5 rounded-xl bg-slate-900/90 border border-slate-800 hover:border-emerald-500/40 text-slate-200 transition-colors shrink-0 shadow-sm">
                    <svg class="w-5 h-5 text-[#8892BF] shrink-0" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1.2 14.5H9.3l.9-4.5h1.5c1.4 0 2.2.6 2 1.8-.2 1.4-1.2 2.7-2.9 2.7zm5.4 0h-1.5l.9-4.5h1.5c1.4 0 2.2.6 2 1.8-.2 1.4-1.2 2.7-2.9 2.7z"/></svg>
                    <span class="text-xs sm:text-sm font-bold text-white">PHP 8.2+</span>
                    <span class="text-[10px] text-teal-400 font-semibold bg-teal-500/10 px-1.5 py-0.5 rounded">Backend</span>
                </div>

                <div class="inline-flex items-center gap-2.5 px-4 py-2.5 rounded-xl bg-slate-900/90 border border-slate-800 hover:border-emerald-500/40 text-slate-200 transition-colors shrink-0 shadow-sm">
                    <svg class="w-5 h-5 text-[#00758F] shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2a10 10 0 1010 10A10 10 0 0012 2zm1 14.93V18h-2v-1.07A6 6 0 017 11h2a4 4 0 008 0h2a6 6 0 01-6 5.93z"/></svg>
                    <span class="text-xs sm:text-sm font-bold text-white">MySQL 8.0</span>
                    <span class="text-[10px] text-blue-400 font-semibold bg-blue-500/10 px-1.5 py-0.5 rounded">Indexed DB</span>
                </div>

                <div class="inline-flex items-center gap-2.5 px-4 py-2.5 rounded-xl bg-slate-900/90 border border-slate-800 hover:border-emerald-500/40 text-slate-200 transition-colors shrink-0 shadow-sm">
                    <svg class="w-5 h-5 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    <span class="text-xs sm:text-sm font-bold text-white">RESTful APIs</span>
                    <span class="text-[10px] text-emerald-300 font-semibold bg-emerald-500/10 px-1.5 py-0.5 rounded">JSON / Auth</span>
                </div>

                <div class="inline-flex items-center gap-2.5 px-4 py-2.5 rounded-xl bg-slate-900/90 border border-slate-800 hover:border-emerald-500/40 text-slate-200 transition-colors shrink-0 shadow-sm">
                    <svg class="w-5 h-5 text-[#DC382D] shrink-0" viewBox="0 0 24 24" fill="currentColor"><path d="M12 3a9 9 0 00-9 9c0 4.97 4.03 9 9 9s9-4.03 9-9a9 9 0 00-9-9zm4 11H8v-2h8v2zm0-4H8V8h8v2z"/></svg>
                    <span class="text-xs sm:text-sm font-bold text-white">Redis</span>
                    <span class="text-[10px] text-rose-400 font-semibold bg-rose-500/10 px-1.5 py-0.5 rounded">Cache &amp; Queues</span>
                </div>

                <div class="inline-flex items-center gap-2.5 px-4 py-2.5 rounded-xl bg-slate-900/90 border border-slate-800 hover:border-emerald-500/40 text-slate-200 transition-colors shrink-0 shadow-sm">
                    <svg class="w-5 h-5 text-[#38BDF8] shrink-0" viewBox="0 0 24 24" fill="currentColor"><path d="M12.001 4.8c-3.2 0-5.2 1.6-6 4.8 1.2-1.6 2.6-2.2 4.2-1.8.913.228 1.565.89 2.288 1.624C13.666 10.618 15.027 12 18.001 12c3.2 0 5.2-1.6 6-4.8-1.2 1.6-2.6 2.2-4.2 1.8-.913-.228-1.565-.89-2.288-1.624C16.336 6.182 14.975 4.8 12.001 4.8zm-6 7.2c-3.2 0-5.2 1.6-6 4.8 1.2-1.6 2.6-2.2 4.2-1.8.913.228 1.565.89 2.288 1.624 1.177 1.194 2.538 2.576 5.512 2.576 3.2 0 5.2-1.6 6-4.8-1.2 1.6-2.6 2.2-4.2 1.8-.913-.228-1.565-.89-2.288-1.624C10.336 13.382 8.975 12 6.001 12z"/></svg>
                    <span class="text-xs sm:text-sm font-bold text-white">Tailwind CSS</span>
                    <span class="text-[10px] text-cyan-400 font-semibold bg-cyan-500/10 px-1.5 py-0.5 rounded">v4.0</span>
                </div>

                <div class="inline-flex items-center gap-2.5 px-4 py-2.5 rounded-xl bg-slate-900/90 border border-slate-800 hover:border-emerald-500/40 text-slate-200 transition-colors shrink-0 shadow-sm">
                    <svg class="w-5 h-5 text-[#77C1D8] shrink-0" viewBox="0 0 24 24" fill="currentColor"><path d="M19.9 12.5L13.8 2 7.7 12.5h12.2zm-12.2 0L1.6 22h12.2l-6.1-9.5zm6.1 0l6.1 9.5H7.7l6.1-9.5z"/></svg>
                    <span class="text-xs sm:text-sm font-bold text-white">Alpine.js</span>
                    <span class="text-[10px] text-teal-300 font-semibold bg-teal-500/10 px-1.5 py-0.5 rounded">Reactive UI</span>
                </div>

                <div class="inline-flex items-center gap-2.5 px-4 py-2.5 rounded-xl bg-slate-900/90 border border-slate-800 hover:border-emerald-500/40 text-slate-200 transition-colors shrink-0 shadow-sm">
                    <svg class="w-5 h-5 text-[#2496ED] shrink-0" viewBox="0 0 24 24" fill="currentColor"><path d="M22.5 10.5c-.3-2.1-1.8-3.7-3.8-4.2-.4-.1-.8-.1-1.2-.1-1 0-1.9.4-2.6 1-.3-.1-.7-.1-1.1-.1-2.3 0-4.2 1.8-4.4 4.1h-.9V9h-2v2.2H5V9H3v2.2H1.5v2h21v-2.7zm-11-2.5h2v2h-2V8zm3 0h2v2h-2V8z"/></svg>
                    <span class="text-xs sm:text-sm font-bold text-white">Docker</span>
                    <span class="text-[10px] text-blue-400 font-semibold bg-blue-500/10 px-1.5 py-0.5 rounded">Containers</span>
                </div>

                <div class="inline-flex items-center gap-2.5 px-4 py-2.5 rounded-xl bg-slate-900/90 border border-slate-800 hover:border-emerald-500/40 text-slate-200 transition-colors shrink-0 shadow-sm">
                    <svg class="w-5 h-5 text-white shrink-0" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"/></svg>
                    <span class="text-xs sm:text-sm font-bold text-white">GitHub Actions</span>
                    <span class="text-[10px] text-slate-300 font-semibold bg-slate-800 px-1.5 py-0.5 rounded">CI / CD</span>
                </div>

                <div class="inline-flex items-center gap-2.5 px-4 py-2.5 rounded-xl bg-slate-900/90 border border-slate-800 hover:border-emerald-500/40 text-slate-200 transition-colors shrink-0 shadow-sm">
                    <svg class="w-5 h-5 text-[#FF6C37] shrink-0" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 14.5h-2v-2h2v2zm0-4h-2V7h2v5.5z"/></svg>
                    <span class="text-xs sm:text-sm font-bold text-white">Postman</span>
                    <span class="text-[10px] text-orange-400 font-semibold bg-orange-500/10 px-1.5 py-0.5 rounded">API Testing</span>
                </div>

                <!-- Group 2 (Duplicate for Seamless Endless Loop) -->
                <div class="inline-flex items-center gap-2.5 px-4 py-2.5 rounded-xl bg-slate-900/90 border border-slate-800 hover:border-emerald-500/40 text-slate-200 transition-colors shrink-0 shadow-sm">
                    <svg class="w-5 h-5 text-red-500 shrink-0" viewBox="0 0 24 24" fill="currentColor"><path d="M23.64 12.2a1 1 0 00-.51-.87L13.8 6.1a1 1 0 00-1 0L3.48 11.45a1 1 0 00-.48.86v7.38a1 1 0 00.5.87l9.32 5.23a1 1 0 001 0l9.32-5.23a1 1 0 00.5-.87v-7.49zm-10.32-4.1l6.73 3.77-3.23 1.81-6.73-3.77 3.23-1.81zm-7.82 5.02l6.82 3.82v6.64l-6.82-3.82v-6.64zm8.82 10.46v-6.64l6.82-3.82v6.64l-6.82 3.82z"/></svg>
                    <span class="text-xs sm:text-sm font-bold text-white">Laravel 12</span>
                    <span class="text-[10px] text-emerald-400 font-semibold bg-emerald-500/10 px-1.5 py-0.5 rounded">MVC Core</span>
                </div>

                <div class="inline-flex items-center gap-2.5 px-4 py-2.5 rounded-xl bg-slate-900/90 border border-slate-800 hover:border-emerald-500/40 text-slate-200 transition-colors shrink-0 shadow-sm">
                    <svg class="w-5 h-5 text-[#8892BF] shrink-0" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1.2 14.5H9.3l.9-4.5h1.5c1.4 0 2.2.6 2 1.8-.2 1.4-1.2 2.7-2.9 2.7zm5.4 0h-1.5l.9-4.5h1.5c1.4 0 2.2.6 2 1.8-.2 1.4-1.2 2.7-2.9 2.7z"/></svg>
                    <span class="text-xs sm:text-sm font-bold text-white">PHP 8.2+</span>
                    <span class="text-[10px] text-teal-400 font-semibold bg-teal-500/10 px-1.5 py-0.5 rounded">Backend</span>
                </div>

                <div class="inline-flex items-center gap-2.5 px-4 py-2.5 rounded-xl bg-slate-900/90 border border-slate-800 hover:border-emerald-500/40 text-slate-200 transition-colors shrink-0 shadow-sm">
                    <svg class="w-5 h-5 text-[#00758F] shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2a10 10 0 1010 10A10 10 0 0012 2zm1 14.93V18h-2v-1.07A6 6 0 017 11h2a4 4 0 008 0h2a6 6 0 01-6 5.93z"/></svg>
                    <span class="text-xs sm:text-sm font-bold text-white">MySQL 8.0</span>
                    <span class="text-[10px] text-blue-400 font-semibold bg-blue-500/10 px-1.5 py-0.5 rounded">Indexed DB</span>
                </div>

                <div class="inline-flex items-center gap-2.5 px-4 py-2.5 rounded-xl bg-slate-900/90 border border-slate-800 hover:border-emerald-500/40 text-slate-200 transition-colors shrink-0 shadow-sm">
                    <svg class="w-5 h-5 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    <span class="text-xs sm:text-sm font-bold text-white">RESTful APIs</span>
                    <span class="text-[10px] text-emerald-300 font-semibold bg-emerald-500/10 px-1.5 py-0.5 rounded">JSON / Auth</span>
                </div>

                <div class="inline-flex items-center gap-2.5 px-4 py-2.5 rounded-xl bg-slate-900/90 border border-slate-800 hover:border-emerald-500/40 text-slate-200 transition-colors shrink-0 shadow-sm">
                    <svg class="w-5 h-5 text-[#DC382D] shrink-0" viewBox="0 0 24 24" fill="currentColor"><path d="M12 3a9 9 0 00-9 9c0 4.97 4.03 9 9 9s9-4.03 9-9a9 9 0 00-9-9zm4 11H8v-2h8v2zm0-4H8V8h8v2z"/></svg>
                    <span class="text-xs sm:text-sm font-bold text-white">Redis</span>
                    <span class="text-[10px] text-rose-400 font-semibold bg-rose-500/10 px-1.5 py-0.5 rounded">Cache &amp; Queues</span>
                </div>

                <div class="inline-flex items-center gap-2.5 px-4 py-2.5 rounded-xl bg-slate-900/90 border border-slate-800 hover:border-emerald-500/40 text-slate-200 transition-colors shrink-0 shadow-sm">
                    <svg class="w-5 h-5 text-[#38BDF8] shrink-0" viewBox="0 0 24 24" fill="currentColor"><path d="M12.001 4.8c-3.2 0-5.2 1.6-6 4.8 1.2-1.6 2.6-2.2 4.2-1.8.913.228 1.565.89 2.288 1.624C13.666 10.618 15.027 12 18.001 12c3.2 0 5.2-1.6 6-4.8-1.2 1.6-2.6 2.2-4.2 1.8-.913-.228-1.565-.89-2.288-1.624C16.336 6.182 14.975 4.8 12.001 4.8zm-6 7.2c-3.2 0-5.2 1.6-6 4.8 1.2-1.6 2.6-2.2 4.2-1.8.913.228 1.565.89 2.288 1.624 1.177 1.194 2.538 2.576 5.512 2.576 3.2 0 5.2-1.6 6-4.8-1.2 1.6-2.6 2.2-4.2 1.8-.913-.228-1.565-.89-2.288-1.624C10.336 13.382 8.975 12 6.001 12z"/></svg>
                    <span class="text-xs sm:text-sm font-bold text-white">Tailwind CSS</span>
                    <span class="text-[10px] text-cyan-400 font-semibold bg-cyan-500/10 px-1.5 py-0.5 rounded">v4.0</span>
                </div>

                <div class="inline-flex items-center gap-2.5 px-4 py-2.5 rounded-xl bg-slate-900/90 border border-slate-800 hover:border-emerald-500/40 text-slate-200 transition-colors shrink-0 shadow-sm">
                    <svg class="w-5 h-5 text-[#77C1D8] shrink-0" viewBox="0 0 24 24" fill="currentColor"><path d="M19.9 12.5L13.8 2 7.7 12.5h12.2zm-12.2 0L1.6 22h12.2l-6.1-9.5zm6.1 0l6.1 9.5H7.7l6.1-9.5z"/></svg>
                    <span class="text-xs sm:text-sm font-bold text-white">Alpine.js</span>
                    <span class="text-[10px] text-teal-300 font-semibold bg-teal-500/10 px-1.5 py-0.5 rounded">Reactive UI</span>
                </div>

                <div class="inline-flex items-center gap-2.5 px-4 py-2.5 rounded-xl bg-slate-900/90 border border-slate-800 hover:border-emerald-500/40 text-slate-200 transition-colors shrink-0 shadow-sm">
                    <svg class="w-5 h-5 text-[#2496ED] shrink-0" viewBox="0 0 24 24" fill="currentColor"><path d="M22.5 10.5c-.3-2.1-1.8-3.7-3.8-4.2-.4-.1-.8-.1-1.2-.1-1 0-1.9.4-2.6 1-.3-.1-.7-.1-1.1-.1-2.3 0-4.2 1.8-4.4 4.1h-.9V9h-2v2.2H5V9H3v2.2H1.5v2h21v-2.7zm-11-2.5h2v2h-2V8zm3 0h2v2h-2V8z"/></svg>
                    <span class="text-xs sm:text-sm font-bold text-white">Docker</span>
                    <span class="text-[10px] text-blue-400 font-semibold bg-blue-500/10 px-1.5 py-0.5 rounded">Containers</span>
                </div>
            </div>
        </div>
    </section>
    @endif

    @if($section === 'about' && $homepageSettings->about_section_enabled)
        <!-- About & Experience Section -->
        <section id="about" class="py-20 sm:py-28 bg-[#0B101D] border-b border-slate-800/80 relative overflow-hidden">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="max-w-6xl mx-auto">
                    <div class="text-center mb-14 reveal-on-scroll">
                        <span class="inline-block text-xs font-bold uppercase tracking-wider text-emerald-400 bg-emerald-500/10 border border-emerald-500/30 px-3.5 py-1 rounded-full mb-3 shadow-xs">Professional Background</span>
                        <h2 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">About &amp; <span class="text-hover-gradient cursor-default">Experience</span></h2>
                        <p class="text-slate-400 text-base mt-2 max-w-xl mx-auto">
                            Committed to building scalable software, dependable backend architecture, and intuitive user experiences.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                        <!-- Left Experience Card -->
                        <div class="reveal-on-scroll stagger-1 lg:col-span-5 bg-[#0F172A]/90 rounded-2xl p-7 sm:p-8 border border-slate-800 shadow-xl card-glow-hover">
                            <div class="text-4xl sm:text-5xl font-extrabold text-emerald-400 mb-1">
                                {{ \App\Models\Setting::get('years_experience') ?: '2.5+' }}
                            </div>
                            <div class="text-base font-bold text-white">Years of Commercial Experience</div>
                            <div class="text-xs font-semibold text-emerald-300 bg-emerald-500/15 border border-emerald-500/30 px-3 py-1 rounded-md inline-block mt-2">
                                {{ \App\Models\Setting::get('training_text') ?: '+ 6 Months Intensive Training' }}
                            </div>

                            <div class="mt-6 pt-6 border-t border-slate-800 space-y-4 text-sm text-slate-300">
                                <div class="flex items-start gap-3">
                                    <div class="w-6 h-6 rounded-full bg-emerald-500/15 text-emerald-400 border border-emerald-500/30 flex items-center justify-center shrink-0 mt-0.5">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                    <span>Specialized in <strong class="text-white">Laravel, PHP &amp; MySQL</strong> database optimization</span>
                                </div>
                                <div class="flex items-start gap-3">
                                    <div class="w-6 h-6 rounded-full bg-emerald-500/15 text-emerald-400 border border-emerald-500/30 flex items-center justify-center shrink-0 mt-0.5">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                    <span>Robust <strong class="text-white">REST API</strong> architecture and third-party integrations</span>
                                </div>
                                <div class="flex items-start gap-3">
                                    <div class="w-6 h-6 rounded-full bg-emerald-500/15 text-emerald-400 border border-emerald-500/30 flex items-center justify-center shrink-0 mt-0.5">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                    <span>Clean code standards with reliable delivery and transparent communication</span>
                                </div>
                            </div>
                        </div>

                        <!-- Right Details -->
                        <div class="reveal-on-scroll stagger-2 lg:col-span-7 bg-[#0F172A]/90 rounded-2xl p-7 sm:p-9 border border-slate-800 shadow-xl card-glow-hover space-y-5">
                            <h3 class="text-2xl font-bold text-white">{{ $profile->title ?: 'Full Stack Web Developer' }}</h3>
                            <div class="prose prose-invert max-w-none text-slate-300 text-base leading-relaxed">
                                {!! $profile->intro ? nl2br(e($profile->intro)) : ($profile->biography ? Str::limit(strip_tags($profile->biography), 350) : 'With 2.5 years of commercial software development and 6 months of comprehensive training, I solve real business challenges by building robust backend architectures, custom web applications, and seamless administrative panels.') !!}
                            </div>

                            <div class="pt-5 border-t border-slate-800 flex flex-wrap gap-4 items-center">
                                <a href="{{ route('about') }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-emerald-400 hover:text-emerald-300 hover:underline group">
                                    <span>Read Detailed Background</span>
                                    <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </a>

                                @if($profile->resume_url && $profile->resume_button_visible)
                                    <a href="{{ $profile->resume_url }}" target="_blank" rel="noopener noreferrer" download
                                        class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg text-sm font-medium text-slate-200 bg-slate-800 hover:bg-slate-700 border border-slate-700 hover:border-emerald-500/40 hover:-translate-y-0.5 transition-all">
                                        <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1M12 12V2m0 0l-4 4m4-4l4 4M5 14h14a2 2 0 010 4H5a2 2 0 010-4z"></path></svg>
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
        <!-- Skills Section with Modern Grid & Glowing Cards -->
        <section id="skills" class="py-20 sm:py-28 bg-[#080C14] border-b border-slate-800/80 relative">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-6xl mx-auto">
                    <div class="text-center mb-14 reveal-on-scroll">
                        <span class="inline-block text-xs font-bold uppercase tracking-wider text-emerald-400 bg-emerald-500/10 border border-emerald-500/30 px-3.5 py-1 rounded-full mb-3 shadow-xs">Core Expertise</span>
                        <h2 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">Skills &amp; <span class="text-hover-gradient cursor-default">Technologies</span></h2>
                        <p class="text-slate-400 text-base mt-2 max-w-xl mx-auto">
                            Modern stack and tools applied in commercial web application engineering.
                        </p>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                        @foreach($skills as $skill)
                            <div class="reveal-on-scroll stagger-{{ ($loop->index % 6) + 1 }} bg-[#0F172A]/80 hover:bg-[#131E35] rounded-xl p-4 text-center border border-slate-800 hover:border-emerald-500/40 card-glow-hover group transition-all">
                                <div class="text-white font-bold text-base mb-1.5 group-hover:text-emerald-400 transition-colors">
                                    {{ $skill->name }}
                                </div>
                                <span class="badge-hover-bounce inline-block text-[11px] px-2.5 py-0.5 rounded-full bg-slate-800 text-slate-300 border border-slate-700/60 group-hover:border-emerald-500/40 group-hover:text-emerald-300 transition-all">
                                    {{ $skill->category->name ?? 'General' }}
                                </span>
                            </div>
                        @endforeach
                    </div>

                    <div class="text-center mt-12">
                        <a href="{{ route('skills') }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-emerald-400 hover:text-emerald-300 hover:underline group">
                            <span>Explore full skill matrix &amp; tools</span>
                            <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if($section === 'projects' && $homepageSettings->projects_section_enabled && $featuredProjects->isNotEmpty())
        <!-- Projects Section — Dynamic Cards with Glowing Hover -->
        <section id="projects" class="py-20 sm:py-28 bg-[#0B101D] border-b border-slate-800/80 relative">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-7xl mx-auto">
                    <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-14 reveal-on-scroll">
                        <div>
                            <span class="inline-block text-xs font-bold uppercase tracking-wider text-emerald-400 bg-emerald-500/10 border border-emerald-500/30 px-3.5 py-1 rounded-full mb-3 shadow-xs">Portfolio Showcase</span>
                            <h2 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">Featured <span class="text-hover-gradient cursor-default">Projects</span></h2>
                            <p class="text-slate-400 text-base mt-2 max-w-xl">
                                Real web applications, APIs, and business platforms built with high reliability.
                            </p>
                        </div>
                        <div class="mt-4 sm:mt-0">
                            <a href="{{ route('projects') }}"
                                class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-lg text-sm font-semibold bg-slate-900 text-white border border-slate-700 hover:border-emerald-500/50 hover:bg-slate-800 hover:-translate-y-0.5 shadow-md transition-all">
                                View All Projects
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </a>
                        </div>
                    </div>

                    <!-- 3-Column Responsive Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach($featuredProjects as $project)
                            <div class="reveal-on-scroll stagger-{{ ($loop->index % 3) + 1 }} bg-[#0F172A]/90 rounded-2xl border border-slate-800 shadow-xl card-glow-hover card-spotlight flex flex-col overflow-hidden group">
                                <a href="{{ route('projects.show', $project->slug) }}" aria-label="View {{ $project->title }} project details" class="relative block aspect-[16/9] overflow-hidden bg-slate-950">
                                    @if($project->thumbnail_url)
                                        <img src="{{ $project->thumbnail_url }}" alt="{{ $project->title }}" width="403" height="227" loading="lazy" decoding="async"
                                            sizes="(min-width: 1024px) 403px, (min-width: 768px) 50vw, 100vw"
                                            class="w-full h-full object-cover group-hover:scale-108 transition-transform duration-500 ease-out">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-slate-400 bg-gradient-to-br from-slate-900 to-slate-950">
                                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                    @endif

                                    <!-- Interactive Hover Preview Glassmorphism Overlay -->
                                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/95 via-slate-950/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-between p-4 z-10 pointer-events-none">
                                        <div class="flex items-center justify-between">
                                            <span class="inline-flex items-center gap-1.5 text-[11px] font-bold text-emerald-400 bg-slate-950/90 px-2.5 py-1 rounded-full border border-emerald-500/30 shadow-md">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                                Interactive Case Study
                                            </span>
                                        </div>

                                        <div class="flex items-center justify-center">
                                            <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-500 text-white font-bold text-xs shadow-xl shadow-emerald-500/30 transform translate-y-3 group-hover:translate-y-0 transition-transform duration-300">
                                                <span>Explore Details</span>
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                            </span>
                                        </div>

                                        <div class="text-[11px] font-mono text-slate-300 truncate">
                                            Role: {{ $project->role ?: 'Lead Developer' }}
                                        </div>
                                    </div>

                                    <div class="absolute top-3 right-3 flex gap-2 z-20">
                                        <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-slate-950/80 backdrop-blur-md text-emerald-400 shadow-sm border border-emerald-500/30">
                                            {{ $project->category ?? 'Web Application' }}
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
                                        <span class="inline-flex items-center gap-1.5 text-[11px] font-bold text-teal-300 bg-teal-500/10 border border-teal-500/30 px-2.5 py-0.5 rounded-md shadow-xs">
                                            {{ $impactBadge }}
                                        </span>
                                    </div>

                                    <h3 class="text-xl font-bold text-white mb-2 text-hover-glow transition-colors">
                                        <a href="{{ route('projects.show', $project->slug) }}">{{ $project->title }}</a>
                                    </h3>

                                    <p class="text-slate-400 text-sm mb-4 line-clamp-2 flex-1 leading-relaxed">
                                        {{ $project->short_description ?? Str::limit(strip_tags($project->description), 110) }}
                                    </p>

                                    @if($project->tech_stack && is_array($project->tech_stack))
                                        <div class="flex flex-wrap gap-1.5 mb-5">
                                            @foreach(array_slice($project->tech_stack, 0, 4) as $tech)
                                                <span class="badge-hover-bounce text-xs px-2.5 py-0.5 rounded bg-slate-800 text-slate-300 border border-slate-700/60 group-hover:border-emerald-500/30 transition-all">
                                                    {{ $tech }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @endif

                                    <div class="pt-4 border-t border-slate-800 flex items-center justify-between mt-auto">
                                        <a href="{{ route('projects.show', $project->slug) }}" aria-label="View details of {{ $project->title }}" class="text-emerald-400 hover:text-emerald-300 font-semibold text-sm inline-flex items-center gap-1 group-hover:underline">
                                            <span>View Details</span>
                                            <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                        </a>

                                        <div class="flex items-center gap-3">
                                            @if($project->github_url)
                                                <a href="{{ $project->github_url }}" target="_blank" rel="noopener noreferrer" aria-label="GitHub source for {{ $project->title }}" class="text-slate-400 hover:text-emerald-400 text-xs font-semibold" title="GitHub Source">GitHub ↗</a>
                                            @endif
                                            @if($project->public_demo_url)
                                                <a href="{{ $project->public_demo_url }}" target="_blank" rel="noopener noreferrer" aria-label="Live demo for {{ $project->title }}" class="text-slate-400 hover:text-emerald-400 text-xs font-semibold" title="Live Demo">Live Demo ↗</a>
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
        <!-- Services Section with Hover Transitions -->
        <section id="services" class="py-20 sm:py-28 bg-[#080C14] border-b border-slate-800/80">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-7xl mx-auto">
                    <div class="text-center mb-14 reveal-on-scroll">
                        <span class="inline-block text-xs font-bold uppercase tracking-wider text-emerald-400 bg-emerald-500/10 border border-emerald-500/30 px-3.5 py-1 rounded-full mb-3 shadow-xs">What I Offer</span>
                        <h2 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">Services &amp; <span class="text-hover-gradient cursor-default">Solutions</span></h2>
                        <p class="text-slate-400 text-base mt-2 max-w-xl mx-auto">
                            Custom software engineering tailored to solve real technical and operational bottlenecks.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach($featuredServices as $service)
                            <div class="reveal-on-scroll stagger-{{ ($loop->index % 4) + 1 }} bg-[#0F172A]/85 hover:bg-[#131E35] rounded-2xl p-6 sm:p-7 border border-slate-800 hover:border-emerald-500/40 shadow-xl card-glow-hover flex flex-col group transition-all">
                                <div class="w-12 h-12 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 group-hover:bg-gradient-to-br group-hover:from-emerald-500 group-hover:to-teal-500 group-hover:text-white group-hover:scale-105 transition-all duration-300 flex items-center justify-center mb-5 font-bold text-lg shadow-sm">
                                    @if($service->icon_url)
                                        <img src="{{ $service->icon_url }}" alt="{{ $service->name }}" width="28" height="28" loading="lazy" decoding="async" class="w-7 h-7 object-contain">
                                    @else
                                        {{ substr($service->name, 0, 1) }}
                                    @endif
                                </div>

                                <h3 class="text-lg font-bold text-white mb-2 group-hover:text-emerald-400 transition-colors">
                                    <a href="{{ route('services.show', $service->slug) }}">{{ $service->name }}</a>
                                </h3>

                                <p class="text-slate-400 text-xs sm:text-sm mb-5 flex-1 leading-relaxed">
                                    {{ $service->short_description ?? Str::limit(strip_tags($service->description), 120) }}
                                </p>

                                @if($service->features && is_array($service->features))
                                    <ul class="mb-5 space-y-1.5 text-xs text-slate-300">
                                        @foreach(array_slice($service->features, 0, 3) as $feat)
                                            <li class="flex items-center gap-2">
                                                <svg class="w-3.5 h-3.5 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                                <span>{{ $feat }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif

                                <div class="pt-4 border-t border-slate-800 flex items-center justify-between mt-auto">
                                    <span class="text-xs text-slate-400">Free estimate</span>

                                    <a href="{{ route('contact', ['service' => $service->slug]) }}"
                                        aria-label="Get a quote for {{ $service->name }}"
                                        class="inline-flex items-center gap-1 text-sm font-semibold text-emerald-400 hover:text-emerald-300 group-hover:underline">
                                        <span>Get a Quote</span>
                                        <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
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
        <section class="py-20 sm:py-28 bg-[#0B101D] border-b border-slate-800/80">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-6xl mx-auto">
                    <div class="text-center mb-14 reveal-on-scroll">
                        <span class="inline-block text-xs font-bold uppercase tracking-wider text-emerald-400 bg-emerald-500/10 border border-emerald-500/30 px-3.5 py-1 rounded-full mb-3 shadow-xs">Structured Methodology</span>
                        <h2 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">How I Work</h2>
                        <p class="text-slate-400 text-base mt-2 max-w-xl mx-auto">
                            A clear, predictable process focused on communication, quality, and on-time delivery.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($workProcesses as $index => $process)
                            <div class="reveal-on-scroll stagger-{{ ($index % 3) + 1 }} bg-[#0F172A]/90 rounded-2xl p-6 text-center border border-slate-800 shadow-xl card-glow-hover relative group">
                                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-gradient-to-br from-emerald-500 to-teal-600 text-white font-bold text-sm mb-4 shadow-md shadow-emerald-500/25 ring-4 ring-emerald-500/15 group-hover:scale-105 transition-all">
                                    {{ $index + 1 }}
                                </span>
                                <h3 class="font-bold text-base text-white mb-2 group-hover:text-emerald-400 transition-colors">{{ $process->title }}</h3>
                                <p class="text-xs sm:text-sm text-slate-400 leading-relaxed">{{ $process->description }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if($section === 'contact_cta' && $homepageSettings->contact_cta_section_enabled)
        <!-- Contact CTA Section with Ambient Glow -->
        <section id="contact" class="py-20 sm:py-28 bg-gradient-to-b from-[#0B101D] via-[#090E1A] to-[#05080E] text-white relative overflow-hidden border-b border-slate-800/80">
            <div class="absolute inset-0 bg-grid-dots-dark opacity-35 pointer-events-none"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[550px] h-[350px] bg-emerald-500/15 rounded-full blur-3xl pointer-events-none animate-pulse-glow"></div>

            <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="max-w-3xl mx-auto text-center reveal-on-scroll">
                    <span class="inline-block text-xs font-bold uppercase tracking-wider text-emerald-400 bg-emerald-500/10 border border-emerald-500/30 px-4 py-1.5 rounded-full mb-4 shadow-sm">Let's Connect</span>
                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-white mb-4">
                        {{ $homepageSettings->contact_cta_heading ?: 'Have a Project in Mind?' }}
                    </h2>
                    <p class="text-base sm:text-lg text-slate-300 mb-8 max-w-xl mx-auto leading-relaxed">
                        {{ $homepageSettings->contact_cta_description ?: "Let's discuss your technical requirements. I am available for freelance web development and software consulting." }}
                    </p>
                    <div class="flex flex-wrap gap-4 justify-center">
                        <a href="{{ route('contact') }}"
                            class="btn-shimmer-effect inline-flex items-center justify-center gap-2 px-8 py-4 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-500 hover:from-emerald-500 hover:to-teal-400 text-white text-base font-semibold shadow-xl shadow-emerald-500/25 hover:shadow-emerald-500/40 hover:-translate-y-0.5 transition-all">
                            <span>Send Project Enquiry</span>
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    @endif
@endforeach

@endsection
