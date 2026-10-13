@extends('public.layouts.app')

@section('title', ($project->seo_title ?: $project->title) . ' - ' . $websiteName)
@section('meta_description', $project->seo_description ?: ($project->short_description ?? Str::limit(strip_tags($project->description), 160)))
@section('og_title', $project->og_title ?: $project->title)
@section('og_description', $project->og_description ?: ($project->short_description ?? Str::limit(strip_tags($project->description), 160)))
@section('og_image', $project->og_image_url ?: $project->thumbnail_url)
@if($project->canonical_url)
    @section('canonical', $project->canonical_url)
@endif
@if($project->no_index)
    @section('meta_robots', 'noindex, nofollow')
@endif

@section('content')
<section class="min-h-screen pt-28 sm:pt-36 pb-24 bg-[#080C14] text-slate-100 relative overflow-hidden">
    <!-- Ambient Lighting & Dot Grid -->
    <div class="absolute inset-0 bg-grid-dots-dark opacity-35 pointer-events-none"></div>
    <div class="absolute -top-32 -left-20 w-[500px] h-[500px] bg-emerald-500/15 rounded-full blur-3xl pointer-events-none animate-pulse-glow"></div>
    <div class="absolute top-1/3 -right-20 w-[450px] h-[450px] bg-teal-500/10 rounded-full blur-3xl pointer-events-none animate-float-delayed"></div>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="max-w-4xl mx-auto">
            <!-- Navigation Back -->
            <a href="{{ route('projects') }}" class="text-emerald-400 hover:text-emerald-300 font-medium text-sm inline-flex items-center gap-2 mb-6 group">
                <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back to Projects
            </a>

            <!-- Header Information -->
            <div class="mb-4">
                <span class="text-xs px-3 py-1 bg-emerald-500/15 border border-emerald-500/30 text-emerald-400 font-semibold rounded-full shadow-xs">
                    {{ $project->category ?? 'Case Study' }}
                </span>
            </div>

            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white tracking-tight mb-4">
                {{ $project->title }}
            </h1>

            @if($project->short_description)
                <p class="text-lg sm:text-xl text-slate-300 leading-relaxed mb-8">{{ $project->short_description }}</p>
            @endif

            <!-- Main Thumbnail -->
            @if($project->thumbnail_url)
                <div class="rounded-2xl overflow-hidden border border-slate-800 shadow-2xl mb-10 bg-slate-950">
                    <img src="{{ $project->thumbnail_url }}" alt="{{ $project->title }}"
                        class="w-full h-auto aspect-video object-cover">
                </div>
            @endif

            <!-- Technologies -->
            @if($project->tech_stack && is_array($project->tech_stack))
                <div class="mb-10 bg-[#0F172A]/90 rounded-2xl border border-slate-800 p-6 shadow-xl">
                    <h3 class="text-xs font-bold text-slate-400 mb-3 uppercase tracking-wider">Technologies &amp; Architecture</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($project->tech_stack as $tech)
                            <span class="px-3 py-1.5 bg-slate-800 text-slate-200 border border-slate-700/60 rounded-lg text-sm font-medium">
                                {{ $tech }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Problem & Purpose -->
            @if($project->purpose)
                <div class="mb-10 bg-[#0F172A]/90 rounded-2xl border border-slate-800 p-6 sm:p-8 shadow-xl">
                    <h3 class="text-xl font-bold text-white mb-3 flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Problem Solved &amp; Overview
                    </h3>
                    <div class="prose prose-invert max-w-none text-slate-300 text-base leading-relaxed">
                        {!! nl2br(e($project->purpose)) !!}
                    </div>
                </div>
            @endif

            <!-- Role & Contribution -->
            @if($project->role)
                <div class="mb-10 bg-[#0F172A]/90 rounded-2xl border border-slate-800 p-6 sm:p-8 shadow-xl">
                    <h3 class="text-xl font-bold text-white mb-3 flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        My Role &amp; Contribution
                    </h3>
                    <div class="prose prose-invert max-w-none text-slate-300 text-base leading-relaxed">
                        {!! nl2br(e($project->role)) !!}
                    </div>
                </div>
            @endif

            <!-- Key Features -->
            @if($project->key_features)
                <div class="mb-10 bg-[#0F172A]/90 rounded-2xl border border-slate-800 p-6 sm:p-8 shadow-xl">
                    <h3 class="text-xl font-bold text-white mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Key Features
                    </h3>
                    @php
                        $features = is_string($project->key_features) ? (str_contains($project->key_features, "\n") ? explode("\n", $project->key_features) : explode('|', $project->key_features)) : (is_array($project->key_features) ? $project->key_features : []);
                    @endphp
                    <ul class="grid grid-cols-1 md:grid-cols-2 gap-3.5">
                        @foreach($features as $feature)
                            @if(trim($feature))
                                <li class="flex items-start gap-2.5 p-3 rounded-xl bg-slate-900 border border-slate-800">
                                    <svg class="w-5 h-5 text-emerald-400 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="text-slate-200 text-sm font-medium leading-snug">{{ trim($feature) }}</span>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Challenges & Solutions -->
            @if($project->challenges || $project->solutions)
                <div class="mb-10 grid grid-cols-1 md:grid-cols-2 gap-6">
                    @if($project->challenges)
                        <div class="bg-[#0F172A]/90 border border-slate-800 rounded-2xl p-6 shadow-xl">
                            <h3 class="text-lg font-bold text-white mb-3 flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-amber-400"></span>
                                Technical Challenges
                            </h3>
                            <div class="prose prose-invert max-w-none text-slate-300 text-sm leading-relaxed">
                                {!! nl2br(e($project->challenges)) !!}
                            </div>
                        </div>
                    @endif
                    @if($project->solutions)
                        <div class="bg-[#0F172A]/90 border border-slate-800 rounded-2xl p-6 shadow-xl">
                            <h3 class="text-lg font-bold text-white mb-3 flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-emerald-400"></span>
                                Architectural Solutions
                            </h3>
                            <div class="prose prose-invert max-w-none text-slate-300 text-sm leading-relaxed">
                                {!! nl2br(e($project->solutions)) !!}
                            </div>
                        </div>
                    @endif
                </div>
            @endif

            <!-- Detailed Description -->
            @if($project->description)
                <div class="mb-10 bg-[#0F172A]/90 rounded-2xl border border-slate-800 p-6 sm:p-8 shadow-xl">
                    <h3 class="text-xl font-bold text-white mb-4">Implementation Details</h3>
                    <div class="prose prose-invert max-w-none text-slate-300 text-base leading-relaxed">
                        {!! nl2br(e($project->description)) !!}
                    </div>
                </div>
            @endif

            <!-- Screenshots Gallery -->
            @if($project->screenshots->isNotEmpty())
                <div class="mb-12">
                    <h3 class="text-xl font-bold text-white mb-6">Screenshots &amp; User Flow</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($project->screenshots as $screenshot)
                            <div class="rounded-2xl overflow-hidden border border-slate-800 shadow-xl bg-slate-950">
                                <img src="{{ $screenshot->image_url }}" alt="{{ $screenshot->caption ?? $project->title }}"
                                    class="w-full h-56 object-cover object-top hover:scale-105 transition-transform duration-300">
                                @if($screenshot->caption)
                                    <p class="p-3 text-xs text-slate-400 text-center border-t border-slate-800 bg-slate-900/80">{{ $screenshot->caption }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Live Actions & Client Info -->
            @if($project->client_name || $project->demo_url || $project->github_url)
                <div class="p-6 rounded-2xl bg-[#0F172A]/90 border border-slate-800 shadow-xl flex flex-wrap gap-4 items-center justify-between mb-12">
                    <div class="flex flex-wrap gap-3 items-center">
                        @if($project->demo_url)
                            <a href="{{ $project->demo_url }}" target="_blank" rel="noopener noreferrer"
                                class="btn-shimmer-effect inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-500 hover:from-emerald-500 hover:to-teal-400 text-white font-medium text-sm transition-all shadow-md shadow-emerald-500/25">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                </svg>
                                Live Demo
                            </a>
                        @endif
                        @if($project->github_url)
                            <a href="{{ $project->github_url }}" target="_blank" rel="noopener noreferrer"
                                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-slate-200 font-medium text-sm border border-slate-700 transition-colors">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"/>
                                </svg>
                                GitHub Repo
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

            <!-- Inquire CTA Box -->
            <div class="p-8 sm:p-12 rounded-2xl bg-[#0F172A]/90 border border-slate-800 shadow-xl text-center">
                <span class="inline-block text-xs font-bold uppercase tracking-wider text-emerald-400 bg-emerald-500/10 border border-emerald-500/30 px-3.5 py-1 rounded-full mb-3 shadow-xs">Interested in Similar Work?</span>
                <h3 class="text-2xl sm:text-3xl font-bold text-white mb-3">Have a project with similar requirements?</h3>
                <p class="text-slate-400 max-w-xl mx-auto mb-6 leading-relaxed">Let's discuss how we can build a scalable, reliable web application tailored to your business needs.</p>
                <a href="{{ route('contact') }}"
                    class="btn-shimmer-effect inline-flex items-center gap-2 bg-gradient-to-r from-emerald-600 to-teal-500 hover:from-emerald-500 hover:to-teal-400 text-white px-7 py-3.5 rounded-xl font-semibold transition-all shadow-lg shadow-emerald-500/25">
                    Hire Me For Your Project
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
