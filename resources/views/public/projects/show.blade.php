@extends('public.layouts.app')

@section('title', ($project->seo_title ?: $project->title) . ' - ' . $websiteName)
@section('meta_description', $project->seo_description ?: ($project->short_description ?? Str::limit(strip_tags($project->description), 160)))
@section('og_title', $project->og_title ?: $project->title)
@section('og_description', $project->og_description ?: ($project->short_description ?? Str::limit(strip_tags($project->description), 160)))
@section('og_image', $project->og_image_url ?: $project->thumbnail_url)
@section('canonical', $project->canonical_url ?: url()->current())
@section('meta_robots', $project->no_index ? 'noindex, nofollow' : 'index, follow')

@section('content')
<section class="min-h-screen pt-28 sm:pt-36 pb-24 bg-[#080C14] text-slate-100 relative overflow-hidden">
    <!-- Ambient Lighting & Dot Grid -->
    <div class="absolute inset-0 bg-grid-dots-dark opacity-35 pointer-events-none"></div>
    <div class="absolute -top-32 -left-20 w-[500px] h-[500px] bg-emerald-500/15 rounded-full blur-3xl pointer-events-none animate-pulse-glow"></div>
    <div class="absolute top-1/3 -right-20 w-[450px] h-[450px] bg-teal-500/10 rounded-full blur-3xl pointer-events-none animate-float-delayed"></div>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="max-w-4xl mx-auto">
            <!-- Top Navigation & Breadcrumbs -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-8 pb-4 border-b border-slate-800/80">
                <a href="{{ route('projects') }}" class="text-emerald-400 hover:text-emerald-300 font-semibold text-xs sm:text-sm inline-flex items-center gap-2 group transition-colors">
                    <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    <span>Back to All Projects</span>
                </a>

                <nav class="flex items-center gap-2 text-xs font-mono text-slate-400" aria-label="Breadcrumb">
                    <a href="{{ route('home') }}" class="hover:text-emerald-400 transition-colors">Home</a>
                    <span>/</span>
                    <a href="{{ route('projects') }}" class="hover:text-emerald-400 transition-colors">Projects</a>
                    <span>/</span>
                    <span class="text-emerald-400 font-semibold truncate max-w-[180px] sm:max-w-xs">{{ $project->title }}</span>
                </nav>
            </div>

            <!-- Category & Status Badges -->
            <div class="flex flex-wrap items-center gap-2.5 mb-4">
                <span class="text-xs px-3.5 py-1 bg-emerald-500/15 border border-emerald-500/30 text-emerald-400 font-bold rounded-full shadow-xs">
                    {{ $project->category ?? 'Case Study' }}
                </span>
                @if($project->is_featured)
                    <span class="text-xs px-3.5 py-1 bg-gradient-to-r from-emerald-600 to-teal-500 text-white font-bold rounded-full shadow-xs">
                        ★ Featured Engineering Case Study
                    </span>
                @endif
                <span class="text-xs px-3 py-1 bg-slate-900 border border-slate-800 text-slate-400 rounded-full font-mono">
                    Production Architecture
                </span>
            </div>

            <!-- Project Title & Subtitle -->
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white tracking-tight mb-4">
                {{ $project->title }}
            </h1>

            @if($project->short_description)
                <p class="text-base sm:text-lg text-slate-300 leading-relaxed mb-8">{{ $project->short_description }}</p>
            @endif

            <!-- Top Quick Actions Bar (Live Demo & GitHub) -->
            @if($project->public_demo_url || $project->github_url)
                <div class="flex flex-wrap items-center gap-3.5 mb-10">
                    @if($project->public_demo_url)
                        <a href="{{ $project->public_demo_url }}" target="_blank" rel="noopener noreferrer"
                            class="btn-shimmer-effect inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-500 hover:from-emerald-500 hover:to-teal-400 text-white font-semibold text-sm transition-all shadow-lg shadow-emerald-500/25 hover:-translate-y-0.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                            </svg>
                            <span>Live Production Demo</span>
                        </a>
                    @endif
                    @if($project->github_url)
                        <a href="{{ $project->github_url }}" target="_blank" rel="noopener noreferrer"
                            class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-slate-900/90 hover:bg-slate-800 text-slate-200 hover:text-white font-semibold text-sm border border-slate-700 hover:border-emerald-500/40 transition-all shadow-md">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"/>
                            </svg>
                            <span>Explore Source on GitHub ↗</span>
                        </a>
                    @endif
                </div>
            @endif

            <!-- Main Thumbnail Card -->
            @if($project->thumbnail_url)
                <div class="rounded-2xl overflow-hidden border border-slate-800 shadow-2xl mb-10 bg-slate-950 relative group">
                    <img src="{{ $project->thumbnail_url }}" alt="{{ $project->title }}"
                        class="w-full h-auto aspect-video object-cover transition-transform duration-500 group-hover:scale-[1.02]">
                </div>
            @endif

            <!-- Quick Specs Matrix (Silicon Valley Standard) -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-10">
                <div class="p-4 rounded-xl bg-[#0F172A]/90 border border-slate-800 shadow-md">
                    <span class="text-[11px] font-mono uppercase tracking-wider text-slate-400 block mb-1">Engineering Role</span>
                    <span class="text-sm font-bold text-white">{{ $project->role ?: 'Lead Full Stack' }}</span>
                </div>
                <div class="p-4 rounded-xl bg-[#0F172A]/90 border border-slate-800 shadow-md">
                    <span class="text-[11px] font-mono uppercase tracking-wider text-slate-400 block mb-1">Domain &amp; Field</span>
                    <span class="text-sm font-bold text-emerald-400">{{ $project->category ?? 'Web Application' }}</span>
                </div>
                <div class="p-4 rounded-xl bg-[#0F172A]/90 border border-slate-800 shadow-md">
                    <span class="text-[11px] font-mono uppercase tracking-wider text-slate-400 block mb-1">Architecture</span>
                    <span class="text-sm font-bold text-teal-300">Clean MVC / REST</span>
                </div>
                <div class="p-4 rounded-xl bg-[#0F172A]/90 border border-slate-800 shadow-md">
                    <span class="text-[11px] font-mono uppercase tracking-wider text-slate-400 block mb-1">Delivery Status</span>
                    <span class="text-sm font-bold text-white flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        Production
                    </span>
                </div>
            </div>

            <!-- Technologies & Architecture Stack -->
            @if($project->tech_stack && is_array($project->tech_stack))
                <div class="mb-10 bg-[#0F172A]/90 rounded-2xl border border-slate-800 p-6 sm:p-7 shadow-xl card-glow-hover">
                    <h3 class="text-xs font-bold text-emerald-400 mb-3.5 uppercase tracking-wider flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
                        <span>Core Technologies &amp; Production Tooling</span>
                    </h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($project->tech_stack as $tech)
                            <span class="px-3.5 py-1.5 bg-slate-900 text-slate-200 border border-slate-700/70 hover:border-emerald-500/40 rounded-xl text-xs sm:text-sm font-semibold transition-colors shadow-xs">
                                {{ $tech }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Problem Solved & Purpose -->
            @if($project->purpose)
                <div class="mb-10 bg-[#0F172A]/90 rounded-2xl border border-slate-800 p-6 sm:p-8 shadow-xl card-glow-hover">
                    <h3 class="text-xl font-bold text-white mb-3 flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-emerald-500/15 border border-emerald-500/30 text-emerald-400 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <span>Problem Solved &amp; Project Purpose</span>
                    </h3>
                    <div class="prose prose-invert max-w-none text-slate-300 text-sm sm:text-base leading-relaxed pl-0 sm:pl-10">
                        {!! nl2br(e($project->purpose)) !!}
                    </div>
                </div>
            @endif

            <!-- Role & Contribution -->
            @if($project->role)
                <div class="mb-10 bg-[#0F172A]/90 rounded-2xl border border-slate-800 p-6 sm:p-8 shadow-xl card-glow-hover">
                    <h3 class="text-xl font-bold text-white mb-3 flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-teal-500/15 border border-teal-500/30 text-teal-300 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <span>My Role &amp; Key Responsibilities</span>
                    </h3>
                    <div class="prose prose-invert max-w-none text-slate-300 text-sm sm:text-base leading-relaxed pl-0 sm:pl-10">
                        {!! nl2br(e($project->role)) !!}
                    </div>
                </div>
            @endif

            <!-- Key Features Grid -->
            @if($project->key_features)
                <div class="mb-10 bg-[#0F172A]/90 rounded-2xl border border-slate-800 p-6 sm:p-8 shadow-xl card-glow-hover">
                    <h3 class="text-xl font-bold text-white mb-5 flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-emerald-500/15 border border-emerald-500/30 text-emerald-400 flex items-center justify-center shrink-0">
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
                                <li class="flex items-start gap-3 p-3.5 rounded-xl bg-slate-900/90 border border-slate-800 hover:border-slate-700 transition-colors">
                                    <div class="w-5 h-5 rounded-full bg-emerald-500/15 text-emerald-400 border border-emerald-500/30 flex items-center justify-center shrink-0 mt-0.5">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                    <span class="text-slate-200 text-xs sm:text-sm font-medium leading-relaxed">{{ trim($feature) }}</span>
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
                        <div class="bg-[#0F172A]/90 border border-amber-500/30 rounded-2xl p-6 sm:p-7 shadow-xl card-glow-hover relative overflow-hidden">
                            <div class="flex items-center gap-2 mb-3.5">
                                <span class="w-2.5 h-2.5 rounded-full bg-amber-400 animate-pulse"></span>
                                <h3 class="text-base sm:text-lg font-bold text-white">Technical Bottlenecks</h3>
                            </div>
                            <div class="prose prose-invert max-w-none text-slate-300 text-sm leading-relaxed">
                                {!! nl2br(e($project->challenges)) !!}
                            </div>
                        </div>
                    @endif
                    @if($project->solutions)
                        <div class="bg-[#0F172A]/90 border border-emerald-500/30 rounded-2xl p-6 sm:p-7 shadow-xl card-glow-hover relative overflow-hidden">
                            <div class="flex items-center gap-2 mb-3.5">
                                <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                <h3 class="text-base sm:text-lg font-bold text-white">Architectural Solutions</h3>
                            </div>
                            <div class="prose prose-invert max-w-none text-slate-300 text-sm leading-relaxed">
                                {!! nl2br(e($project->solutions)) !!}
                            </div>
                        </div>
                    @endif
                </div>
            @endif

            <!-- Detailed Description / Implementation -->
            @if($project->description)
                <div class="mb-10 bg-[#0F172A]/90 rounded-2xl border border-slate-800 p-6 sm:p-8 shadow-xl">
                    <h3 class="text-xl font-bold text-white mb-4">Implementation Overview</h3>
                    <div class="prose prose-invert max-w-none text-slate-300 text-sm sm:text-base leading-relaxed">
                        {!! nl2br(e($project->description)) !!}
                    </div>
                </div>
            @endif

            <!-- Screenshots Gallery -->
            @if($project->screenshots && $project->screenshots->isNotEmpty())
                <div class="mb-12">
                    <h3 class="text-xl font-bold text-white mb-6 flex items-center gap-2">
                        <span>📸</span>
                        <span>Application Visuals &amp; User Flow</span>
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($project->screenshots as $screenshot)
                            <div class="rounded-2xl overflow-hidden border border-slate-800 shadow-xl bg-slate-950 group">
                                <img src="{{ $screenshot->image_url }}" alt="{{ $screenshot->caption ?? $project->title }}" loading="lazy" decoding="async"
                                    class="w-full h-56 object-cover object-top group-hover:scale-105 transition-transform duration-300">
                                @if($screenshot->caption)
                                    <p class="p-3 text-xs text-slate-400 text-center border-t border-slate-800 bg-slate-900/80">{{ $screenshot->caption }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Bottom Action & Client Bar -->
            @if($project->client_name || $project->public_demo_url || $project->github_url)
                <div class="p-6 rounded-2xl bg-[#0F172A]/90 border border-slate-800 shadow-xl flex flex-wrap gap-4 items-center justify-between mb-12">
                    <div class="flex flex-wrap gap-3 items-center">
                        @if($project->public_demo_url)
                            <a href="{{ $project->public_demo_url }}" target="_blank" rel="noopener noreferrer"
                                class="btn-shimmer-effect inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-500 hover:from-emerald-500 hover:to-teal-400 text-white font-medium text-sm transition-all shadow-md shadow-emerald-500/25">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                </svg>
                                <span>Live Demo</span>
                            </a>
                        @endif
                        @if($project->github_url)
                            <a href="{{ $project->github_url }}" target="_blank" rel="noopener noreferrer"
                                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-slate-200 font-medium text-sm border border-slate-700 transition-colors">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"/>
                                </svg>
                                <span>GitHub Repository</span>
                            </a>
                        @endif
                    </div>
                    @if($project->client_name)
                        <div class="text-xs sm:text-sm text-slate-400">
                            Client: <span class="font-semibold text-white">{{ $project->client_name }}</span>
                        </div>
                    @endif
                </div>
            @endif

            <!-- Explore Other Case Studies (Prev/Next/Related) -->
            @if(isset($relatedProjects) && $relatedProjects->isNotEmpty())
                <div class="mb-14 pt-10 border-t border-slate-800/80">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg sm:text-xl font-bold text-white">More Engineering Case Studies</h3>
                        <a href="{{ route('projects') }}" class="text-xs sm:text-sm font-semibold text-emerald-400 hover:text-emerald-300 transition-colors">View All &rarr;</a>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        @foreach($relatedProjects as $rel)
                            <a href="{{ route('projects.show', $rel->slug) }}" class="group bg-[#0F172A]/90 hover:bg-[#131E35] rounded-2xl p-5 border border-slate-800 hover:border-emerald-500/40 transition-all flex flex-col justify-between shadow-lg">
                                <div>
                                    <span class="text-[10px] font-mono font-bold uppercase tracking-wider text-emerald-400 bg-emerald-500/10 border border-emerald-500/20 px-2 py-0.5 rounded-full mb-2 inline-block">
                                        {{ $rel->category ?? 'Project' }}
                                    </span>
                                    <h4 class="text-base font-bold text-white group-hover:text-emerald-400 transition-colors mb-2">{{ $rel->title }}</h4>
                                    <p class="text-slate-400 text-xs line-clamp-2">{{ $rel->short_description ?? Str::limit(strip_tags($rel->description), 100) }}</p>
                                </div>
                                <div class="mt-4 pt-3 border-t border-slate-800/80 flex items-center justify-between text-xs font-semibold text-emerald-400">
                                    <span>Read Case Study</span>
                                    <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Inquire CTA Box -->
            <div class="p-8 sm:p-12 rounded-2xl bg-gradient-to-br from-[#0F172A] to-[#0A101D] border border-emerald-500/30 shadow-2xl text-center relative overflow-hidden">
                <div class="absolute -top-12 -right-12 w-40 h-40 bg-emerald-500/10 rounded-full blur-2xl pointer-events-none"></div>
                <span class="inline-block text-xs font-bold uppercase tracking-wider text-emerald-400 bg-emerald-500/10 border border-emerald-500/30 px-3.5 py-1 rounded-full mb-3 shadow-xs">Need Similar Engineering?</span>
                <h3 class="text-2xl sm:text-3xl font-bold text-white mb-3">Have a project with similar technical requirements?</h3>
                <p class="text-slate-400 text-sm sm:text-base max-w-xl mx-auto mb-6 leading-relaxed">Let's discuss how we can build a scalable, reliable web application tailored to your business needs.</p>
                <div class="flex flex-wrap gap-3.5 justify-center">
                    <a href="{{ route('contact') }}"
                        class="btn-shimmer-effect inline-flex items-center gap-2 bg-gradient-to-r from-emerald-600 to-teal-500 hover:from-emerald-500 hover:to-teal-400 text-white px-7 py-3.5 rounded-xl font-semibold transition-all shadow-lg shadow-emerald-500/25">
                        <span>Hire Me For Your Project</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
