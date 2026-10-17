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
        <!-- ========================================================
             HERO SECTION — ULTRA-PREMIUM ARCHITECTURAL FOCUS
             ======================================================== -->
        <section id="hero" class="relative pt-32 sm:pt-40 pb-20 sm:pb-32 bg-[#06080F] border-b border-white/[0.08] overflow-hidden">
            <!-- Ambient Warm Mesh Glows -->
            <div class="absolute inset-0 bg-grid-dots-dark opacity-20 pointer-events-none"></div>
            <div class="absolute -top-36 left-1/4 w-[600px] h-[450px] bg-[#B85D19]/[0.05] dark:bg-[#E07A5F]/[0.05] rounded-full blur-[140px] pointer-events-none"></div>
            <div class="absolute top-1/4 -right-20 w-[450px] h-[450px] bg-[#B85D19]/[0.03] dark:bg-[#E07A5F]/[0.04] rounded-full blur-[140px] pointer-events-none"></div>

            <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10 max-w-7xl">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-10 items-center">
                    
                    <!-- Left Column: Authority Narrative & CTAs -->
                    <div class="lg:col-span-7 text-left">
                        @php
                            $isAvailable = \App\Models\Setting::get('available_for_freelance', '1') === '1'
                                || \App\Models\Setting::get('available_for_freelance', true) === true;
                            $yearsExp = \App\Models\Setting::get('years_experience') ?: '2.5+';
                        @endphp

                        <!-- Status & Telemetry Pill -->
                        <div class="flex flex-wrap items-center gap-2.5 mb-7">
                            @if($isAvailable)
                                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-500/10 border border-emerald-500/25 text-emerald-600 dark:text-emerald-400 font-medium text-xs tracking-tight shadow-xs">
                                    <span class="relative flex h-2 w-2">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                                    </span>
                                    <span>Available for Commercial Contracts &amp; Roles</span>
                                </div>
                            @endif
                            <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-black/[0.03] dark:bg-white/[0.04] border border-black/10 dark:border-white/[0.08] text-slate-700 dark:text-slate-300 font-mono text-xs">
                                <span class="text-amber-500">⚡</span>
                                <span>IST (UTC+5:30) • Remote Worldwide</span>
                            </div>
                        </div>

                        <!-- Main Authority Headline -->
                        <h1 class="text-4xl sm:text-5xl lg:text-[58px] font-extrabold tracking-tight text-white leading-[1.08] mb-4">
                            {{ $homepageSettings->hero_heading ?: ($profile->title ?: 'Full Stack Software Engineer') }}
                        </h1>

                        <!-- Technical Specialty Eyebrow -->
                        <div class="flex items-center gap-3 mb-6">
                            <span class="text-lg sm:text-xl font-semibold text-brand tracking-tight">
                                {{ $homepageSettings->hero_title ?: 'Laravel, MySQL & High-Throughput REST APIs' }}
                            </span>
                        </div>

                        <p class="text-base sm:text-lg text-slate-300/90 mb-9 leading-relaxed max-w-2xl font-normal">
                            {{ $homepageSettings->hero_description ?: 'Architecting scalable web applications, domain-driven backend services, and database optimizations engineered for speed, structural integrity, and commercial reliability.' }}
                        </p>

                        <!-- Action Controls -->
                        <div class="flex flex-wrap gap-3.5 items-center mb-10">
                            <a href="#contact"
                                class="theme-btn-primary inline-flex items-center justify-center gap-2 px-6 py-3.5 font-semibold rounded-xl hover:scale-[1.02] shadow-sm transition-all duration-200 text-sm sm:text-base">
                                <span>Discuss Your Project</span>
                                <svg class="w-4 h-4 ml-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>

                            <a href="#projects"
                                class="inline-flex items-center justify-center gap-2 px-5 py-3.5 font-medium rounded-xl bg-black/[0.04] dark:bg-white/[0.05] hover:bg-black/[0.07] dark:hover:bg-white/[0.09] text-inherit border border-black/10 dark:border-white/10 transition-all duration-200 text-sm sm:text-base">
                                <span>View Case Studies</span>
                            </a>

                            @php
                                $cvUrl = ($profile->resume_url && $profile->resume_button_visible) ? $profile->resume_url : '#contact';
                            @endphp
                            <a href="{{ $cvUrl }}" @if($profile->resume_url && $profile->resume_button_visible) target="_blank" rel="noopener noreferrer" download @endif
                                class="inline-flex items-center justify-center gap-2 px-4 py-3.5 font-medium rounded-xl bg-black/[0.03] dark:bg-white/[0.03] hover:bg-black/[0.06] dark:hover:bg-white/[0.06] border border-black/10 dark:border-white/10 transition-all duration-200 text-sm"
                                title="Download CV / Resume">
                                <svg class="w-4 h-4 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1M12 12V2m0 0l-4 4m4-4l4 4M5 14h14a2 2 0 010 4H5a2 2 0 010-4z"></path></svg>
                                <span>Resume</span>
                            </a>

                            @php
                                $contactEmail = $profile->contact_email ?: ($profile->email ?: null);
                            @endphp
                            @if($contactEmail)
                                <button type="button"
                                    @click="window.copyPortfolioEmail('{{ $contactEmail }}', $event)"
                                    class="inline-flex items-center justify-center gap-2 px-4 py-3.5 rounded-xl bg-black/[0.03] dark:bg-white/[0.03] hover:bg-black/[0.06] dark:hover:bg-white/[0.06] border border-black/10 dark:border-white/10 transition-all duration-200 text-sm"
                                    title="Copy email: {{ $contactEmail }}">
                                    <svg class="w-4 h-4 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                    <span>Copy Email</span>
                                </button>
                            @endif
                        </div>

                        <!-- Integrated Credentials Strip -->
                        <div class="pt-7 border-t border-white/[0.08] grid grid-cols-3 gap-6 text-left">
                            <div>
                                <div class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight stat-counter"
                                     data-target="{{ floatval($yearsExp) ?: 2.5 }}" data-suffix="+">{{ $yearsExp }}+</div>
                                <div class="text-xs font-semibold text-slate-300 mt-0.5">Years Experience</div>
                                <div class="text-[11px] text-slate-500">Commercial Production</div>
                            </div>
                            <div class="border-l border-white/[0.08] pl-6">
                                <div class="text-2xl sm:text-3xl font-extrabold text-brand tracking-tight">&lt; 50ms</div>
                                <div class="text-xs font-semibold text-slate-300 mt-0.5">API Latency Target</div>
                                <div class="text-[11px] text-slate-500">Indexed &amp; Cached</div>
                            </div>
                            <div class="border-l border-white/[0.08] pl-6">
                                <div class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">100%</div>
                                <div class="text-xs font-semibold text-slate-300 mt-0.5">Architecture Discipline</div>
                                <div class="text-[11px] text-slate-500">Zero N+1 &amp; Strict 3NF</div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Interactive System Telemetry & Live Architecture Playground -->
                    <div x-data="{
                        activeTab: 'flow',
                        activeNode: 'api',
                        apiExecuting: false,
                        apiExecuted: false,
                        runApiTest() {
                            this.apiExecuting = true;
                            setTimeout(() => {
                                this.apiExecuting = false;
                                this.apiExecuted = true;
                            }, 550);
                        }
                    }" class="lg:col-span-5 relative">
                        @php
                            $heroImg = $homepageSettings->hero_image_url ?: $profile->profile_photo_url;
                        @endphp

                        <!-- Interactive Terminal / Architecture Window -->
                        <div class="specular-card relative rounded-2xl bg-[#090C16] border border-white/[0.12] shadow-2xl shadow-black/80 overflow-hidden transition-all duration-300">
                            <!-- Window Header Chrome with Interactive Tabs -->
                            <div class="px-4 py-3 bg-[#06080F] border-b border-white/[0.08] flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="w-2.5 h-2.5 rounded-full bg-red-500/80"></span>
                                    <span class="w-2.5 h-2.5 rounded-full bg-amber-500/80"></span>
                                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500/80"></span>
                                    <span class="text-xs font-mono text-slate-400 ml-2">architecture-telemetry.sys</span>
                                </div>

                                <div class="flex items-center gap-1 bg-white/[0.04] p-1 rounded-lg border border-white/[0.06] text-[11px]">
                                    <button type="button" @click="activeTab = 'flow'"
                                        :class="activeTab === 'flow' ? 'bg-white/10 text-white font-semibold' : 'text-slate-400 hover:text-white'"
                                        class="px-2.5 py-0.5 rounded transition-colors flex items-center gap-1">
                                        <span>⚡</span> Flow
                                    </button>
                                    <button type="button" @click="activeTab = 'api'"
                                        :class="activeTab === 'api' ? 'bg-white/10 text-white font-semibold' : 'text-slate-400 hover:text-white'"
                                        class="px-2.5 py-0.5 rounded transition-colors flex items-center gap-1">
                                        <span>🧪</span> API Test
                                    </button>
                                    @if($heroImg)
                                        <button type="button" @click="activeTab = 'photo'"
                                            :class="activeTab === 'photo' ? 'bg-white/10 text-white font-semibold' : 'text-slate-400 hover:text-white'"
                                            class="px-2.5 py-0.5 rounded transition-colors flex items-center gap-1">
                                            <span>👤</span> Portrait
                                        </button>
                                    @endif
                                </div>
                            </div>

                            <!-- TAB 1: LIVE INTERACTIVE ARCHITECTURE DATA-FLOW -->
                            <div x-show="activeTab === 'flow'" class="p-6 space-y-4">
                                <div class="text-xs font-mono text-slate-400 flex items-center justify-between pb-3 border-b border-white/[0.06]">
                                    <span class="flex items-center gap-1.5 text-emerald-400">
                                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                                        LIVE ARCHITECTURE PIPELINE
                                    </span>
                                    <span class="text-slate-500 text-[10px]">Click any node</span>
                                </div>

                                <!-- Connected Node Steps -->
                                <div class="space-y-2.5 font-mono text-xs">
                                    <!-- Node 1: Edge & Client -->
                                    <div @click="activeNode = 'edge'"
                                        :class="activeNode === 'edge' ? 'bg-white/[0.07] border-emerald-500/40 text-white' : 'bg-white/[0.02] border-white/[0.06] text-slate-400 hover:text-slate-200'"
                                        class="p-3 rounded-xl border flex items-center justify-between cursor-pointer transition-all">
                                        <div class="flex items-center gap-2.5">
                                            <span class="w-2 h-2 rounded-full bg-teal-400"></span>
                                            <span class="font-bold">01. Edge / Reverse Proxy</span>
                                        </div>
                                        <span class="text-[11px] font-sans text-teal-700 dark:text-teal-300 font-medium">Cloudflare • TLS 1.3</span>
                                    </div>

                                    <!-- Connecting Data Pipe Indicator -->
                                    <div class="flex items-center justify-center -my-1 text-slate-600 text-xs select-none">
                                        ↓ <span class="text-[10px] ml-1 text-emerald-700 dark:text-emerald-400/80 font-medium animate-pulse-data">HTTP/2 Handshake (12ms)</span>
                                    </div>

                                    <!-- Node 2: Laravel Core Service Engine -->
                                    <div @click="activeNode = 'api'"
                                        :class="activeNode === 'api' ? 'bg-white/[0.07] border-emerald-500/40 text-white' : 'bg-white/[0.02] border-white/[0.06] text-slate-400 hover:text-slate-200'"
                                        class="p-3 rounded-xl border flex items-center justify-between cursor-pointer transition-all">
                                        <div class="flex items-center gap-2.5">
                                            <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                                            <span class="font-bold">02. Laravel 12 API Engine</span>
                                        </div>
                                        <span class="text-[11px] font-sans text-emerald-700 dark:text-emerald-300 font-medium">Sanctum • DDD Service</span>
                                    </div>

                                    <!-- Connecting Data Pipe Indicator -->
                                    <div class="flex items-center justify-center -my-1 text-slate-600 text-xs select-none">
                                        ↓ <span class="text-[10px] ml-1 text-teal-700 dark:text-teal-400/80 font-medium animate-pulse-data">Dual Persistence Layer</span>
                                    </div>

                                    <!-- Node 3: Storage (Redis & MySQL) -->
                                    <div @click="activeNode = 'db'"
                                        :class="activeNode === 'db' ? 'bg-white/[0.07] border-emerald-500/40 text-white' : 'bg-white/[0.02] border-white/[0.06] text-slate-400 hover:text-slate-200'"
                                        class="p-3 rounded-xl border flex items-center justify-between cursor-pointer transition-all">
                                        <div class="flex items-center gap-2.5">
                                            <span class="w-2 h-2 rounded-full bg-amber-400"></span>
                                            <span class="font-bold">03. Redis 7 &amp; MySQL 8.0</span>
                                        </div>
                                        <span class="text-[11px] font-sans text-amber-700 dark:text-amber-300 font-medium">B-Tree • Sub-5ms Cache</span>
                                    </div>
                                </div>

                                <!-- Dynamic Telemetry Detail Card -->
                                <div class="mt-4 p-3.5 rounded-xl bg-black/[0.04] dark:bg-black/40 border border-black/[0.08] dark:border-white/[0.08] text-xs font-mono space-y-1">
                                    <div x-show="activeNode === 'edge'" class="space-y-1">
                                        <div class="text-teal-400 font-bold">Edge Protection &amp; SSL Offload</div>
                                        <div class="text-slate-600 dark:text-slate-300 text-[11px]">DDoS mitigation, Brotli compression, IP throttling, and zero-downtime routing.</div>
                                    </div>
                                    <div x-show="activeNode === 'api'" class="space-y-1">
                                        <div class="text-emerald-500 dark:text-emerald-400 font-bold">Laravel 12 Business Core</div>
                                        <div class="text-slate-600 dark:text-slate-300 text-[11px]">Strict Type declarations, Form Request sanitization, Route Model Binding &amp; asynchronous jobs.</div>
                                    </div>
                                    <div x-show="activeNode === 'db'" class="space-y-1">
                                        <div class="text-amber-500 dark:text-amber-400 font-bold">Relational Integrity &amp; In-Memory Layer</div>
                                        <div class="text-slate-600 dark:text-slate-300 text-[11px]">Strict 3NF schemas, foreign key cascade constraints, indexed query plans, and Redis session states.</div>
                                    </div>
                                </div>
                            </div>

                            <!-- TAB 2: LIVE SIMULATED API PLAYGROUND -->
                            <div x-show="activeTab === 'api'" style="display: none;" class="p-6 space-y-4 font-mono text-xs">
                                <div class="flex items-center justify-between pb-3 border-b border-black/[0.06] dark:border-white/[0.06]">
                                    <span class="text-slate-500 dark:text-slate-400">Endpoint Simulation</span>
                                    <span class="px-2 py-0.5 rounded bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 text-[10px] font-bold">HTTP/2 200 OK</span>
                                </div>

                                <div class="flex items-center gap-2 p-2.5 rounded-lg bg-black/[0.03] dark:bg-black/50 border border-black/[0.08] dark:border-white/[0.08] text-[11px]">
                                    <span class="text-emerald-600 dark:text-emerald-400 font-bold">GET</span>
                                    <span class="text-slate-700 dark:text-slate-300">/api/v1/health/telemetry</span>
                                    <button type="button" @click="runApiTest()"
                                        class="ml-auto px-2.5 py-1 rounded theme-btn-primary font-bold text-[10px] transition-colors">
                                        <span x-text="apiExecuting ? 'Executing...' : 'Run Test'">Run Test</span>
                                    </button>
                                </div>

                                <div class="p-3.5 rounded-xl bg-black/[0.04] dark:bg-black/60 border border-black/[0.08] dark:border-white/[0.08] text-[11px] leading-relaxed overflow-x-auto">
<pre class="text-emerald-400">{
  <span class="text-slate-400">"status"</span>: <span class="text-teal-300">"operational"</span>,
  <span class="text-slate-400">"runtime"</span>: <span class="text-teal-300">"PHP 8.3 / Laravel 12"</span>,
  <span class="text-slate-400">"database"</span>: <span class="text-teal-300">"MySQL 8.0 (ACID compliant)"</span>,
  <span class="text-slate-400">"latency_ms"</span>: <span class="text-amber-300">14.2</span>,
  <span class="text-slate-400">"cached_queries"</span>: <span class="text-white">true</span>,
  <span class="text-slate-400">"active_workers"</span>: <span class="text-amber-300">4</span>
}</pre>
                                </div>

                                <div class="text-[11px] text-slate-400 flex items-center justify-between font-sans">
                                    <span>Rate limit: 60/min</span>
                                    <span class="text-emerald-400 font-mono">Response Time: 14.2ms</span>
                                </div>
                            </div>

                            <!-- TAB 3: PORTRAIT (IF PRESENT) -->
                            @if($heroImg)
                                <div x-show="activeTab === 'photo'" style="display: none;" class="p-4">
                                    <div class="aspect-square w-full rounded-xl overflow-hidden bg-slate-900 mb-3">
                                        <img src="{{ $heroImg }}" alt="{{ $profile->full_name }}" width="400" height="400" fetchpriority="high" class="w-full h-full object-cover">
                                    </div>
                                    <div class="flex items-center justify-between px-2">
                                        <div>
                                            <div class="text-sm font-bold text-white">{{ $profile->full_name }}</div>
                                            <div class="text-xs text-slate-400">{{ $profile->title ?: 'Full Stack Software Engineer' }}</div>
                                        </div>
                                        <span class="text-xs font-mono text-emerald-400 bg-emerald-500/10 px-2.5 py-1 rounded-md border border-emerald-500/20">
                                            Commercial Lead
                                        </span>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if($section === 'hero')
    <!-- ========================================================
         TECH STACK LOGO MARQUEE — QUIET & SOPHISTICATED
         ======================================================== -->
    <section class="py-7 bg-[#05070D] border-b border-white/[0.06] overflow-hidden" aria-label="Core Engineering Tooling">
        <div class="container mx-auto px-4 mb-4 text-center">
            <span class="text-[11px] font-mono tracking-widest uppercase text-slate-500">
                Core Production Technologies &amp; Standards
            </span>
        </div>

        <div class="marquee-mask relative w-full overflow-hidden">
            <div class="animate-marquee flex items-center gap-4 sm:gap-6">
                @for($repeat = 0; $repeat < 2; $repeat++)
                    @foreach($skills as $skill)
                        @php
                            $sName = strtolower(trim($skill->name));
                        @endphp
                        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/[0.02] border border-white/[0.06] text-slate-300 hover:text-white hover:border-white/[0.15] transition-all shrink-0 text-xs font-medium">
                            @if(str_contains($sName, 'laravel'))
                                <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span>
                            @elseif(str_contains($sName, 'php'))
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                            @elseif(str_contains($sName, 'mysql'))
                                <span class="w-1.5 h-1.5 rounded-full bg-teal-400"></span>
                            @elseif(str_contains($sName, 'redis'))
                                <span class="w-1.5 h-1.5 rounded-full bg-rose-400"></span>
                            @else
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                            @endif
                            <span class="text-white font-medium">{{ $skill->name }}</span>
                        </div>
                    @endforeach
                @endfor
            </div>
        </div>
    </section>
    @endif

    @if($section === 'about' && $homepageSettings->about_section_enabled)
        <!-- ========================================================
             ABOUT & CAREER NARRATIVE — ASYMMETRIC BENTO GRID
             ======================================================== -->
        <section id="about" class="py-20 sm:py-28 bg-[#070A12] border-b border-white/[0.07] relative">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
                
                <div class="max-w-3xl mb-12 reveal-on-scroll">
                    <span class="text-xs font-mono uppercase tracking-widest text-brand font-semibold mb-3 block">
                        01 / Engineering Standards &amp; Principles
                    </span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight leading-tight">
                        Built for long-term maintainability, zero technical debt, and real throughput.
                    </h2>
                </div>

                <!-- Bento Grid (Linear & Apple Style Layout) -->
                <div class="grid grid-cols-1 md:grid-cols-12 gap-6 reveal-on-scroll">
                    
                    <!-- Bento Tile 1 (Large 8-col): Core Narrative & Commercial Track Record -->
                    <div class="md:col-span-8 p-8 rounded-2xl bg-[#090D16] border border-white/[0.08] flex flex-col justify-between specular-card">
                        <div>
                            <div class="text-xs font-mono text-emerald-400 uppercase tracking-wider mb-3">
                                Commercial Background
                            </div>
                            <h3 class="text-xl sm:text-2xl font-bold text-white mb-4 leading-snug">
                                Full-Stack Software Engineer with 2.5+ years of commercial production software delivery.
                            </h3>
                            <div class="text-slate-300 text-sm sm:text-base leading-relaxed space-y-3 font-normal">
                                <p>
                                    {{ $profile->intro ? strip_tags($profile->intro) : 'Specializing in Laravel, PHP, MySQL, and RESTful architectures. I design dependable backend foundations that empower businesses to scale their customer workflows, administrative operations, and data pipelines with confidence.' }}
                                </p>
                                <p class="text-slate-400">
                                    Every project is written with strict type safety, modular domain separation, and comprehensive indexing — ensuring your application runs fast today and remains painless to maintain years down the line.
                                </p>
                            </div>
                        </div>

                        <div class="mt-8 pt-6 border-t border-white/[0.08] flex flex-wrap items-center justify-between gap-4">
                            <a href="{{ route('about') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-white hover:text-brand transition-colors group">
                                <span>Read Comprehensive Background</span>
                                <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                            <span class="text-xs font-mono text-slate-500">2.5 Yrs Exp + 6 Months Training</span>
                        </div>
                    </div>

                    <!-- Bento Tile 2 (4-col): Real-time Availability & Communication Tile -->
                    <div class="md:col-span-4 p-8 rounded-2xl bg-[#090D16] border border-white/[0.08] flex flex-col justify-between specular-card">
                        <div>
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-xs font-mono text-emerald-400 uppercase tracking-wider">Status &amp; Availability</span>
                                <span class="relative flex h-2.5 w-2.5">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                                </span>
                            </div>

                            <div class="text-lg font-bold text-white mb-1">Open for Contracts</div>
                            <p class="text-xs text-slate-400 mb-6">Available for freelance web application development, ERP panels &amp; API engineering.</p>

                            <div class="space-y-3 text-xs font-mono">
                                <div class="p-3 rounded-xl bg-black/[0.02] dark:bg-white/[0.03] border border-black/[0.08] dark:border-white/[0.06] flex items-center justify-between">
                                    <span class="text-slate-400">Timezone</span>
                                    <span class="text-white font-semibold">IST (UTC+5:30)</span>
                                </div>
                                <div class="p-3 rounded-xl bg-black/[0.02] dark:bg-white/[0.03] border border-black/[0.08] dark:border-white/[0.06] flex items-center justify-between">
                                    <span class="text-slate-400">Communication SLA</span>
                                    <span class="text-brand font-semibold">&lt; 2 Hours</span>
                                </div>
                                <div class="p-3 rounded-xl bg-black/[0.02] dark:bg-white/[0.03] border border-black/[0.08] dark:border-white/[0.06] flex items-center justify-between">
                                    <span class="text-slate-400">Code Standards</span>
                                    <span class="text-white font-semibold">PSR-12 / Clean DDD</span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 pt-4 border-t border-white/[0.08]">
                            <a href="#contact" class="text-xs font-semibold text-brand hover:underline inline-flex items-center gap-1">
                                <span>Schedule Discussion ↗</span>
                            </a>
                        </div>
                    </div>

                    <!-- Bento Tile 3 (4-col): Database Query Optimization Graphic -->
                    <div class="md:col-span-4 p-7 rounded-2xl bg-[#090D16] border border-white/[0.08] flex flex-col justify-between specular-card">
                        <div>
                            <div class="text-xs font-mono text-brand uppercase tracking-wider mb-2">Performance Tuning</div>
                            <h4 class="text-base font-bold text-white mb-2">MySQL Indexing &amp; Query Optimization</h4>
                            <p class="text-xs text-slate-400 leading-relaxed mb-5">
                                Eliminating slow table scans and complex joins using composite B-Tree indexing and query plan analysis.
                            </p>

                            <!-- Before vs After Telemetry Graphic -->
                            <div class="space-y-2 font-mono text-xs">
                                <div class="p-2.5 rounded-lg bg-red-500/10 border border-red-500/20 text-red-600 dark:text-red-400 font-medium flex items-center justify-between">
                                    <span>Unindexed Scan:</span>
                                    <span class="font-bold">380ms</span>
                                </div>
                                <div class="p-2.5 rounded-lg bg-emerald-500/10 border border-emerald-500/20 text-emerald-700 dark:text-emerald-400 font-medium flex items-center justify-between">
                                    <span>Indexed Composite:</span>
                                    <span class="font-bold">18ms (95% Faster)</span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 pt-3 border-t border-white/[0.08] text-[11px] text-slate-500 font-mono">
                            Zero N+1 Query Guarantee
                        </div>
                    </div>

                    <!-- Bento Tile 4 (4-col): Security & Authentication -->
                    <div class="md:col-span-4 p-7 rounded-2xl bg-[#090D16] border border-white/[0.08] flex flex-col justify-between specular-card">
                        <div>
                            <div class="text-xs font-mono text-brand uppercase tracking-wider mb-2">Security Hardening</div>
                            <h4 class="text-base font-bold text-white mb-2">OWASP Hardened Architecture</h4>
                            <p class="text-xs text-slate-400 leading-relaxed mb-4">
                                Strict Form Request input sanitization, CSRF token mitigation, and Laravel Sanctum bearer token rate limiting.
                            </p>
                            <div class="flex flex-wrap gap-1.5 text-[11px] font-mono text-slate-300">
                                <span class="px-2 py-0.5 rounded bg-black/[0.03] dark:bg-white/[0.04] border border-black/10 dark:border-white/[0.08] text-slate-700 dark:text-slate-300 font-medium">Sanctum JWT</span>
                                <span class="px-2 py-0.5 rounded bg-black/[0.03] dark:bg-white/[0.04] border border-black/10 dark:border-white/[0.08] text-slate-700 dark:text-slate-300 font-medium">Rate Limiting</span>
                                <span class="px-2 py-0.5 rounded bg-black/[0.03] dark:bg-white/[0.04] border border-black/10 dark:border-white/[0.08] text-slate-700 dark:text-slate-300 font-medium">RBAC Access</span>
                                <span class="px-2 py-0.5 rounded bg-black/[0.03] dark:bg-white/[0.04] border border-black/10 dark:border-white/[0.08] text-slate-700 dark:text-slate-300 font-medium">CORS Config</span>
                            </div>
                        </div>

                        <div class="mt-4 pt-3 border-t border-white/[0.08] text-[11px] text-slate-500 font-mono">
                            Data Privacy &amp; Integrity by Design
                        </div>
                    </div>

                    <!-- Bento Tile 5 (4-col): Reliable Asynchronous Workers -->
                    <div class="md:col-span-4 p-7 rounded-2xl bg-[#090D16] border border-white/[0.08] flex flex-col justify-between specular-card">
                        <div>
                            <div class="text-xs font-mono text-brand uppercase tracking-wider mb-2">Asynchronous Jobs</div>
                            <h4 class="text-base font-bold text-white mb-2">Non-Blocking Queue Processing</h4>
                            <p class="text-xs text-slate-400 leading-relaxed mb-4">
                                Redis queue workers processing transactional emails, PDF invoice generation, and third-party API sync in the background.
                            </p>
                            <div class="flex flex-wrap gap-1.5 text-[11px] font-mono text-slate-300">
                                <span class="px-2 py-0.5 rounded bg-black/[0.03] dark:bg-white/[0.04] border border-black/10 dark:border-white/[0.08] text-slate-700 dark:text-slate-300 font-medium">Redis Queues</span>
                                <span class="px-2 py-0.5 rounded bg-black/[0.03] dark:bg-white/[0.04] border border-black/10 dark:border-white/[0.08] text-slate-700 dark:text-slate-300 font-medium">Auto-Retry</span>
                                <span class="px-2 py-0.5 rounded bg-black/[0.03] dark:bg-white/[0.04] border border-black/10 dark:border-white/[0.08] text-slate-700 dark:text-slate-300 font-medium">Failed Job Monitors</span>
                            </div>
                        </div>

                        <div class="mt-4 pt-3 border-t border-white/[0.08] text-[11px] text-slate-500 font-mono">
                            100% Non-Blocking Main Thread
                        </div>
                    </div>

                </div>

            </div>
        </section>
    @endif

    @if($section === 'skills' && $homepageSettings->skills_section_enabled && $skills && $skills->isNotEmpty())
        <!-- ========================================================
             SKILLS & DOMAIN MATRIX — STRUCTURED CAPABILITIES
             ======================================================== -->
        <section id="skills" class="py-20 sm:py-28 bg-[#05070D] border-b border-white/[0.07] relative">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
                
                <div class="max-w-3xl mb-14 reveal-on-scroll">
                    <span class="text-xs font-mono uppercase tracking-widest text-brand font-semibold mb-3 block">
                        02 / Technical Domain Matrix
                    </span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight leading-tight">
                        Production stack engineered for dependability and maintainability.
                    </h2>
                    <p class="text-slate-400 text-base mt-3">
                        A structured breakdown of core engineering capabilities, frameworks, and infrastructure tools.
                    </p>
                </div>

                <!-- 4 Distinct Architectural Pillars -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 sm:gap-8">
                    <!-- Pillar 1: Backend Architecture & APIs -->
                    <div class="specular-card p-8 rounded-2xl bg-[#090D16] border border-white/[0.08] reveal-on-scroll">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-bold text-white">Backend Architecture &amp; APIs</h3>
                            <span class="text-xs font-mono text-emerald-700 dark:text-emerald-400 px-2.5 py-0.5 rounded bg-emerald-500/10 border border-emerald-500/25 font-semibold">Primary Focus</span>
                        </div>
                        <p class="text-slate-400 text-xs sm:text-sm mb-5 leading-relaxed">
                            Robust server-side engineering utilizing Laravel 12, strict PHP 8.2+, Form Request validation, Service/Action patterns, and token-based API authentication.
                        </p>
                        <div class="flex flex-wrap gap-2">
                            @foreach($skills->filter(fn($s) => str_contains(strtolower($s->name . ' ' . ($s->category->name ?? '')), 'php') || str_contains(strtolower($s->name), 'laravel') || str_contains(strtolower($s->name), 'api') || str_contains(strtolower($s->name), 'rest')) as $skill)
                                <span class="px-3 py-1.5 rounded-lg bg-black/[0.03] dark:bg-white/[0.04] border border-black/10 dark:border-white/[0.08] text-slate-800 dark:text-slate-200 text-xs font-medium hover:border-brand/40 transition-colors">
                                    {{ $skill->name }}
                                </span>
                            @endforeach
                            <span class="px-3 py-1.5 rounded-lg bg-black/[0.03] dark:bg-white/[0.04] border border-black/10 dark:border-white/[0.08] text-slate-800 dark:text-slate-200 text-xs font-medium hover:border-brand/40 transition-colors">Domain Services</span>
                            <span class="px-3 py-1.5 rounded-lg bg-black/[0.03] dark:bg-white/[0.04] border border-black/10 dark:border-white/[0.08] text-slate-800 dark:text-slate-200 text-xs font-medium hover:border-brand/40 transition-colors">Job Queues</span>
                        </div>
                    </div>

                    <!-- Pillar 2: Database & Storage Optimization -->
                    <div class="specular-card p-8 rounded-2xl bg-[#090D16] border border-white/[0.08] reveal-on-scroll">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-bold text-white">Database &amp; Storage Optimization</h3>
                            <span class="text-xs font-mono text-teal-700 dark:text-teal-400 px-2.5 py-0.5 rounded bg-teal-500/10 border border-teal-500/25 font-semibold">High Performance</span>
                        </div>
                        <p class="text-slate-400 text-xs sm:text-sm mb-5 leading-relaxed">
                            Relational schema design with 3NF normalization, foreign key cascade policies, composite indexing, and query plan analysis to avoid slow tables.
                        </p>
                        <div class="flex flex-wrap gap-2">
                            @foreach($skills->filter(fn($s) => str_contains(strtolower($s->name . ' ' . ($s->category->name ?? '')), 'sql') || str_contains(strtolower($s->name), 'redis') || str_contains(strtolower($s->name), 'data')) as $skill)
                                <span class="px-3 py-1.5 rounded-lg bg-black/[0.03] dark:bg-white/[0.04] border border-black/10 dark:border-white/[0.08] text-slate-800 dark:text-slate-200 text-xs font-medium hover:border-brand/40 transition-colors">
                                    {{ $skill->name }}
                                </span>
                            @endforeach
                            <span class="px-3 py-1.5 rounded-lg bg-black/[0.03] dark:bg-white/[0.04] border border-black/10 dark:border-white/[0.08] text-slate-800 dark:text-slate-200 text-xs font-medium hover:border-brand/40 transition-colors">B-Tree Indexing</span>
                            <span class="px-3 py-1.5 rounded-lg bg-black/[0.03] dark:bg-white/[0.04] border border-black/10 dark:border-white/[0.08] text-slate-800 dark:text-slate-200 text-xs font-medium hover:border-brand/40 transition-colors">Query Tuning</span>
                        </div>
                    </div>

                    <!-- Pillar 3: DevOps, Security & Tooling -->
                    <div class="specular-card p-8 rounded-2xl bg-[#090D16] border border-white/[0.08] reveal-on-scroll">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-bold text-white">DevOps, Security &amp; Workflow</h3>
                            <span class="text-xs font-mono text-slate-700 dark:text-slate-300 px-2.5 py-0.5 rounded bg-black/[0.04] dark:bg-white/[0.05] border border-black/10 dark:border-white/[0.1] font-semibold">Standard</span>
                        </div>
                        <p class="text-slate-400 text-xs sm:text-sm mb-5 leading-relaxed">
                            Continuous delivery workflows, semantic versioning with Git, Dockerized development environments, and Linux/Apache/Nginx production web server administration.
                        </p>
                        <div class="flex flex-wrap gap-2">
                            @foreach($skills->filter(fn($s) => str_contains(strtolower($s->name . ' ' . ($s->category->name ?? '')), 'git') || str_contains(strtolower($s->name), 'docker') || str_contains(strtolower($s->name), 'linux') || str_contains(strtolower($s->name), 'nginx')) as $skill)
                                <span class="px-3 py-1.5 rounded-lg bg-black/[0.03] dark:bg-white/[0.04] border border-black/10 dark:border-white/[0.08] text-slate-800 dark:text-slate-200 text-xs font-medium hover:border-brand/40 transition-colors">
                                    {{ $skill->name }}
                                </span>
                            @endforeach
                            <span class="px-3 py-1.5 rounded-lg bg-black/[0.03] dark:bg-white/[0.04] border border-black/10 dark:border-white/[0.08] text-slate-800 dark:text-slate-200 text-xs font-medium hover:border-brand/40 transition-colors">Git Flow</span>
                            <span class="px-3 py-1.5 rounded-lg bg-black/[0.03] dark:bg-white/[0.04] border border-black/10 dark:border-white/[0.08] text-slate-800 dark:text-slate-200 text-xs font-medium hover:border-brand/40 transition-colors">Apache / Nginx</span>
                        </div>
                    </div>

                    <!-- Pillar 4: Frontend & Interactive Interfaces -->
                    <div class="specular-card p-8 rounded-2xl bg-[#090D16] border border-white/[0.08] reveal-on-scroll">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-bold text-white">Frontend &amp; Responsive UI</h3>
                            <span class="text-xs font-mono text-emerald-700 dark:text-emerald-400 px-2.5 py-0.5 rounded bg-emerald-500/10 border border-emerald-500/25 font-semibold">Reactive</span>
                        </div>
                        <p class="text-slate-400 text-xs sm:text-sm mb-5 leading-relaxed">
                            Clean, accessible interfaces built with modern TailwindCSS, Alpine.js, Blade components, and zero layout shift for seamless user experiences.
                        </p>
                        <div class="flex flex-wrap gap-2">
                            @foreach($skills->filter(fn($s) => str_contains(strtolower($s->name . ' ' . ($s->category->name ?? '')), 'tail') || str_contains(strtolower($s->name), 'alpine') || str_contains(strtolower($s->name), 'js') || str_contains(strtolower($s->name), 'blade') || str_contains(strtolower($s->name), 'css')) as $skill)
                                <span class="px-3 py-1.5 rounded-lg bg-black/[0.03] dark:bg-white/[0.04] border border-black/10 dark:border-white/[0.08] text-slate-800 dark:text-slate-200 text-xs font-medium hover:border-brand/40 transition-colors">
                                    {{ $skill->name }}
                                </span>
                            @endforeach
                            <span class="px-3 py-1.5 rounded-lg bg-black/[0.03] dark:bg-white/[0.04] border border-black/10 dark:border-white/[0.08] text-slate-800 dark:text-slate-200 text-xs font-medium hover:border-brand/40 transition-colors">Responsive Layout</span>
                            <span class="px-3 py-1.5 rounded-lg bg-black/[0.03] dark:bg-white/[0.04] border border-black/10 dark:border-white/[0.08] text-slate-800 dark:text-slate-200 text-xs font-medium hover:border-brand/40 transition-colors">Core Web Vitals</span>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-12">
                    <a href="{{ route('skills') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-300 hover:text-white transition-colors group">
                        <span>View complete technical competency matrix</span>
                        <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
            </div>
        </section>
    @endif

    @if($section === 'projects' && $homepageSettings->projects_section_enabled && $featuredProjects->isNotEmpty())
        <!-- ========================================================
             PROJECTS SHOWCASE — SLEEK DARK MAC BROWSER MOCKUPS
             ======================================================== -->
        <section id="projects" class="py-20 sm:py-28 bg-[#070A12] border-b border-white/[0.07] relative">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
                
                <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-14 reveal-on-scroll">
                    <div>
                        <span class="text-xs font-mono uppercase tracking-widest text-brand font-semibold mb-3 block">
                            03 / Case Studies &amp; Systems
                        </span>
                        <h2 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight leading-tight">
                            Selected Commercial Works
                        </h2>
                        <p class="text-slate-400 text-base mt-2 max-w-xl">
                            Real-world applications built to solve operational bottlenecks, manage data securely, and deliver fast response times.
                        </p>
                    </div>
                    <div class="mt-4 sm:mt-0">
                        <a href="{{ route('projects') }}"
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs sm:text-sm font-medium bg-white/[0.04] text-white border border-white/[0.1] hover:bg-white/[0.08] transition-all">
                            <span>Browse All Projects</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    </div>
                </div>

                <!-- Editorial Alternating Case Studies with Dark Mac Window Frame -->
                <div class="space-y-16 lg:space-y-24">
                    @foreach($featuredProjects as $project)
                        @php
                            $isEven = $loop->index % 2 === 1;
                        @endphp
                        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-14 items-center reveal-on-scroll">
                            
                            <!-- Visual Mac Browser Window Frame -->
                            <div class="lg:col-span-7 {{ $isEven ? 'lg:order-2' : 'lg:order-1' }}">
                                <div class="specular-card rounded-2xl overflow-hidden bg-[#0A0E18] border border-white/[0.12] shadow-2xl shadow-black/80 group">
                                    <!-- Mac Window Top Bar -->
                                    <div class="px-4 py-3 bg-[#07090F] border-b border-white/[0.08] flex items-center justify-between">
                                        <div class="flex items-center gap-2">
                                            <span class="w-2.5 h-2.5 rounded-full bg-[#FF5F56]/80"></span>
                                            <span class="w-2.5 h-2.5 rounded-full bg-[#FFBD2E]/80"></span>
                                            <span class="w-2.5 h-2.5 rounded-full bg-[#27C93F]/80"></span>
                                        </div>

                                        <!-- Simulated Browser Address Pill -->
                                        <div class="hidden sm:flex items-center gap-1.5 px-3 py-1 rounded-md bg-white/[0.03] border border-white/[0.06] text-[11px] font-mono text-slate-400 w-64 justify-center">
                                            <span class="text-emerald-400">🔒</span>
                                            <span class="truncate">https://{{ Str::slug($project->title) }}.app/v2</span>
                                        </div>

                                        <span class="text-[10px] font-mono text-emerald-400 uppercase tracking-wider font-semibold">
                                            {{ $project->category ?? 'Web App' }}
                                        </span>
                                    </div>

                                    <!-- Screenshot Window Content -->
                                    <a href="{{ route('projects.show', $project->slug) }}" class="block aspect-[16/10] overflow-hidden bg-slate-950 relative">
                                        @if($project->thumbnail_url)
                                            <img src="{{ $project->thumbnail_url }}" alt="{{ $project->title }}" loading="lazy" class="w-full h-full object-cover group-hover:scale-[1.025] transition-transform duration-500 ease-out">
                                        @else
                                            <div class="w-full h-full flex flex-col items-center justify-center text-slate-600 bg-slate-950 font-mono text-sm p-4 text-center">
                                                <span class="text-white font-bold mb-1">{{ $project->title }}</span>
                                                <span class="text-xs text-slate-500">Custom Engineering System</span>
                                            </div>
                                        @endif
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                    </a>
                                </div>
                            </div>

                            <!-- Narrative & Technical Breakdown -->
                            <div class="lg:col-span-5 {{ $isEven ? 'lg:order-1' : 'lg:order-2' }} space-y-4">
                                <div class="flex items-center gap-2.5">
                                    <span class="text-xs font-mono text-brand uppercase tracking-wider font-semibold">
                                        {{ $project->category ?? 'Production Application' }}
                                    </span>
                                    <span class="text-slate-600">•</span>
                                    <span class="text-xs text-slate-400">
                                        {{ $project->role ?: 'Lead Backend Engineer' }}
                                    </span>
                                </div>

                                <h3 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight leading-tight">
                                    <a href="{{ route('projects.show', $project->slug) }}" class="hover:text-brand transition-colors">
                                        {{ $project->title }}
                                    </a>
                                </h3>

                                <p class="text-slate-300 text-sm sm:text-base leading-relaxed font-normal">
                                    {{ $project->short_description ?? Str::limit(strip_tags($project->description), 140) }}
                                </p>

                                @if($project->tech_stack && is_array($project->tech_stack))
                                    <div class="flex flex-wrap gap-2 pt-2">
                                        @foreach(array_slice($project->tech_stack, 0, 5) as $tech)
                                            <span class="text-xs font-mono px-2.5 py-1 rounded bg-black/[0.03] dark:bg-white/[0.04] text-slate-700 dark:text-slate-300 border border-black/10 dark:border-white/[0.08] font-medium">
                                                {{ $tech }}
                                            </span>
                                        @endforeach
                                    </div>
                                @endif

                                <div class="pt-4 flex items-center gap-5">
                                    <a href="{{ route('projects.show', $project->slug) }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-white hover:text-brand transition-colors group">
                                        <span>Read Case Study</span>
                                        <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                    </a>

                                    @if($project->public_demo_url)
                                        <a href="{{ $project->public_demo_url }}" target="_blank" rel="noopener noreferrer" class="text-xs font-mono text-slate-400 hover:text-white transition-colors">
                                            Live Deployment ↗
                                        </a>
                                    @endif

                                    @if($project->github_url)
                                        <a href="{{ $project->github_url }}" target="_blank" rel="noopener noreferrer" class="text-xs font-mono text-slate-400 hover:text-white transition-colors">
                                            Source Code ↗
                                        </a>
                                    @endif
                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>

            </div>
        </section>
    @endif

    @if($section === 'services' && $homepageSettings->services_section_enabled && $featuredServices->isNotEmpty())
        <!-- ========================================================
             SERVICES & CAPABILITIES — SOLUTIONS MATRIX
             ======================================================== -->
        <section id="services" class="py-20 sm:py-28 bg-[#05070D] border-b border-white/[0.07]">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
                
                <div class="max-w-3xl mb-14 reveal-on-scroll">
                    <span class="text-xs font-mono uppercase tracking-widest text-brand font-semibold mb-3 block">
                        04 / Commercial Offerings
                    </span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight leading-tight">
                        Specialized Engineering Solutions
                    </h2>
                    <p class="text-slate-400 text-base mt-3">
                        Targeted development services tailored to eliminate technical debt and scale your software products.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 sm:gap-8">
                    @foreach($featuredServices as $service)
                        <div class="specular-card p-8 rounded-2xl bg-[#090D16] border border-white/[0.08] hover:border-white/[0.15] transition-all flex flex-col justify-between reveal-on-scroll">
                            <div>
                                <div class="text-xs font-mono text-brand mb-2 font-semibold">
                                    Capability 0{{ $loop->iteration }}
                                </div>

                                <h3 class="text-xl font-bold text-white mb-3">
                                    <a href="{{ route('services.show', $service->slug) }}" class="hover:text-brand transition-colors">
                                        {{ $service->name }}
                                    </a>
                                </h3>

                                <p class="text-slate-400 text-sm leading-relaxed mb-6 font-normal">
                                    {{ $service->short_description ?? Str::limit(strip_tags($service->description), 130) }}
                                </p>

                                @if($service->features && is_array($service->features))
                                    <ul class="space-y-2 mb-8 text-xs text-slate-300">
                                        @foreach(array_slice($service->features, 0, 3) as $feat)
                                            <li class="flex items-center gap-2">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                                <span>{{ $feat }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>

                            <div class="pt-5 border-t border-white/[0.08] flex items-center justify-between">
                                <span class="text-xs text-slate-500 font-mono">Scope &amp; Architecture Delivery</span>
                                <a href="{{ route('contact', ['service' => $service->slug]) }}" class="text-xs font-semibold text-white hover:text-brand transition-colors inline-flex items-center gap-1">
                                    <span>Inquire ↗</span>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </section>
    @endif

    @if($section === 'work_process' && $homepageSettings->work_process_section_enabled && $workProcesses->isNotEmpty())
        <!-- ========================================================
             WORK PROCESS — CONNECTED MILESTONE PIPELINE
             ======================================================== -->
        <section class="py-20 sm:py-28 bg-[#070A12] border-b border-white/[0.07]">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
                
                <div class="max-w-3xl mb-14 reveal-on-scroll">
                    <span class="text-xs font-mono uppercase tracking-widest text-brand font-semibold mb-3 block">
                        05 / Delivery Standards
                    </span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight leading-tight">
                        How Projects Move From Specs To Production
                    </h2>
                    <p class="text-slate-400 text-base mt-3">
                        A transparent, predictable process focused on clear technical architecture, test coverage, and dependable delivery.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($workProcesses as $index => $process)
                        <div class="border-t border-white/[0.1] pt-6 reveal-on-scroll">
                            <span class="text-xs font-mono text-brand block mb-2 font-semibold">
                                Stage 0{{ $index + 1 }}
                            </span>
                            <h3 class="text-lg font-bold text-white mb-2">{{ $process->title }}</h3>
                            <p class="text-sm text-slate-400 leading-relaxed font-normal">{{ $process->description }}</p>
                        </div>
                    @endforeach
                </div>

            </div>
        </section>
    @endif

    @if($section === 'contact_cta' && $homepageSettings->contact_cta_section_enabled)
        <!-- ========================================================
             CONTACT CTA — ELEVATED MINIMAL CALL TO ACTION
             ======================================================== -->
        <section id="contact" class="py-24 sm:py-32 bg-[#05070D] text-white relative overflow-hidden border-b border-white/[0.07]">
            <div class="absolute inset-0 bg-grid-dots-dark opacity-20 pointer-events-none"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[550px] h-[350px] bg-[#B85D19]/[0.05] dark:bg-[#E07A5F]/[0.06] rounded-full blur-[140px] pointer-events-none"></div>

            <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10 max-w-4xl text-center reveal-on-scroll">
                <span class="text-xs font-mono uppercase tracking-widest text-brand font-semibold mb-4 block">
                    06 / Let's Connect
                </span>
                <h2 class="text-3xl sm:text-5xl font-extrabold tracking-tight text-white mb-4 leading-tight">
                    {{ $homepageSettings->contact_cta_heading ?: 'Have a complex system or project in mind?' }}
                </h2>
                <p class="text-base sm:text-lg text-slate-300/90 mb-10 max-w-xl mx-auto leading-relaxed font-normal">
                    {{ $homepageSettings->contact_cta_description ?: "Let's review your technical specifications. I am open for commercial web development, backend engineering, and system optimizations." }}
                </p>

                <div class="flex flex-wrap gap-4 justify-center items-center">
                    <a href="{{ route('contact') }}"
                        class="theme-btn-primary inline-flex items-center justify-center gap-2 px-8 py-4 rounded-xl text-sm sm:text-base font-semibold shadow-sm transition-all hover:scale-[1.02]">
                        <span>Initiate Project Inquiry</span>
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>

                    @php
                        $contactDirectEmail = $profile->contact_email ?: ($profile->email ?: \App\Models\Setting::get('contact_email'));
                    @endphp
                    @if($contactDirectEmail)
                        <button type="button"
                            @click="window.copyPortfolioEmail('{{ $contactDirectEmail }}', $event)"
                            class="inline-flex items-center justify-center gap-2 px-6 py-4 rounded-xl bg-black/[0.04] dark:bg-white/[0.04] hover:bg-black/[0.07] dark:hover:bg-white/[0.08] text-inherit border border-black/10 dark:border-white/[0.1] text-sm sm:text-base font-medium transition-all"
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
