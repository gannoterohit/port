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
<section class="min-h-screen pt-28 sm:pt-36 pb-20 bg-slate-50 dark:bg-slate-950">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <a href="{{ route('projects') }}" class="text-primary font-medium text-sm flex items-center gap-2 mb-6">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back to Projects
            </a>

            <div class="mb-6">
                <span class="text-xs px-3 py-1 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded-full">
                    {{ $project->category ?? 'Uncategorized' }}
                </span>
            </div>

            <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white mb-6">
                {{ $project->title }}
            </h1>

            @if($project->short_description)
                <p class="text-xl text-gray-600 dark:text-gray-400 mb-8">{{ $project->short_description }}</p>
            @endif

            @if($project->thumbnail_url)
                <img src="{{ $project->thumbnail_url }}" alt="{{ $project->title }}"
                    class="w-full h-auto rounded-xl shadow-md mb-8">
            @endif

            @if($project->tech_stack && is_array($project->tech_stack))
                <div class="mb-8">
                    <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 mb-3 uppercase tracking-wider">Technologies</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($project->tech_stack as $tech)
                            <span class="px-3 py-1 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-full text-sm">
                                {{ $tech }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif

            @if($project->purpose)
                <div class="mb-10 bg-white dark:bg-slate-800/80 rounded-2xl border border-slate-200/80 dark:border-slate-700/80 p-6 sm:p-8 shadow-sm">
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3 flex items-center gap-2">
                        <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Project Purpose & Overview
                    </h3>
                    <div class="prose dark:prose-invert max-w-none text-slate-600 dark:text-slate-300">
                        {!! nl2br(e($project->purpose)) !!}
                    </div>
                </div>
            @endif

            @if($project->role)
                <div class="mb-10 bg-white dark:bg-slate-800/80 rounded-2xl border border-slate-200/80 dark:border-slate-700/80 p-6 sm:p-8 shadow-sm">
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3 flex items-center gap-2">
                        <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        My Role & Contribution
                    </h3>
                    <div class="prose dark:prose-invert max-w-none text-slate-600 dark:text-slate-300">
                        {!! nl2br(e($project->role)) !!}
                    </div>
                </div>
            @endif

            @if($project->key_features)
                <div class="mb-10 bg-white dark:bg-slate-800/80 rounded-2xl border border-slate-200/80 dark:border-slate-700/80 p-6 sm:p-8 shadow-sm">
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Key Features
                    </h3>
                    @php
                        $features = is_string($project->key_features) ? (str_contains($project->key_features, "\n") ? explode("\n", $project->key_features) : explode('|', $project->key_features)) : (is_array($project->key_features) ? $project->key_features : []);
                    @endphp
                    <ul class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        @foreach($features as $feature)
                            @if(trim($feature))
                                <li class="flex items-start gap-2.5 p-3 rounded-lg bg-slate-50 dark:bg-slate-900/60 border border-slate-100 dark:border-slate-800">
                                    <svg class="w-5 h-5 text-emerald-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="text-slate-700 dark:text-slate-300 text-sm font-medium">{{ trim($feature) }}</span>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            @endif

            @if($project->challenges || $project->solutions)
                <div class="mb-10 grid grid-cols-1 md:grid-cols-2 gap-6">
                    @if($project->challenges)
                        <div class="bg-amber-50/60 dark:bg-amber-950/20 border border-amber-200/60 dark:border-amber-800/40 rounded-2xl p-6">
                            <h3 class="text-lg font-bold text-amber-900 dark:text-amber-300 mb-3 flex items-center gap-2">
                                <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                Challenges Faced
                            </h3>
                            <div class="prose dark:prose-invert max-w-none text-slate-700 dark:text-slate-300 text-sm">
                                {!! nl2br(e($project->challenges)) !!}
                            </div>
                        </div>
                    @endif
                    @if($project->solutions)
                        <div class="bg-blue-50/60 dark:bg-blue-950/20 border border-blue-200/60 dark:border-blue-800/40 rounded-2xl p-6">
                            <h3 class="text-lg font-bold text-blue-900 dark:text-blue-300 mb-3 flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg>
                                Solutions Implemented
                            </h3>
                            <div class="prose dark:prose-invert max-w-none text-slate-700 dark:text-slate-300 text-sm">
                                {!! nl2br(e($project->solutions)) !!}
                            </div>
                        </div>
                    @endif
                </div>
            @endif

            @if($project->description)
                <div class="mb-10 bg-white dark:bg-slate-800/80 rounded-2xl border border-slate-200/80 dark:border-slate-700/80 p-6 sm:p-8 shadow-sm">
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-4">Detailed Description</h3>
                    <div class="prose dark:prose-invert max-w-none text-slate-600 dark:text-slate-300">
                        {!! nl2br(e($project->description)) !!}
                    </div>
                </div>
            @endif

            @if($project->screenshots->isNotEmpty())
                <div class="mb-12">
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-6">Project Screenshots</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($project->screenshots as $screenshot)
                            <div class="group rounded-2xl overflow-hidden border border-slate-200 dark:border-slate-700 shadow-sm hover:shadow-lg transition-all duration-300 bg-white dark:bg-slate-900">
                                <img src="{{ $screenshot->image_url }}" alt="{{ $screenshot->caption ?? $project->title }}"
                                    class="w-full h-56 object-cover object-top group-hover:scale-105 transition-transform duration-300">
                                @if($screenshot->caption)
                                    <p class="p-3 text-xs text-slate-500 dark:text-slate-400 text-center">{{ $screenshot->caption }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if($project->client_name || $project->demo_url || $project->github_url)
                <div class="p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-sm flex flex-wrap gap-4 items-center justify-between mb-12">
                    <div class="flex flex-wrap gap-4 items-center">
                        @if($project->demo_url)
                            <a href="{{ $project->demo_url }}" target="_blank" rel="noopener noreferrer"
                                class="btn btn-primary">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                </svg>
                                Live Demo
                            </a>
                        @endif
                        @if($project->github_url)
                            <a href="{{ $project->github_url }}" target="_blank" rel="noopener noreferrer"
                                class="btn btn-secondary">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 0C5.371 0 0 5.371 0 12.004c0 5.302 3.544 9.8 8.434 11.386.6.112.82-.262.82-.58 0-.286-.01-1.186-.015-2.148-3.429.756-4.141-1.647-4.141-1.647-.555-1.401-1.342-1.77-1.342-1.77-1.09-.75.084-.735.084-.735 1.203.084 1.836 1.24 1.836 1.24 1.067 1.83 2.805 1.305 3.49.996.108-.782.418-1.305.762-1.605-2.665-.305-5.467-1.335-5.467-5.935 0-1.311.47-2.381 1.236-3.221-.124-.303-.053-.823.027-1.646 0 0 .027-.086.997 1.203 3.186-.998 4.263-.274 4.263-.274.34.861.995 1.685 1.715 1.998.82-.122 1.64-.247 2.456-.449 0 0 1.09-.19 2.24 1.226 0 0 1.105-1.156 1.568-2.779 0 0 .42-1.325.027-2.779 0 0 1.59-.041 2.997 1.229.96-.273 1.99-.822 3.01-1.599.762 1.155 1.142 2.497 1.142 3.91 0 1.566.015 3.132.015 3.589 0 0 .084.49.82 1.295.932 1.2 1.42 1.964 1.42 1.964.534.889 1.158 1.341 1.81.995 1.27-.338 1.72-.881 2.03.336.265.999.82 1.787 1.427 2.423.81-.161 1.6-.48 2.27-.93.074-.554.136-1.435.136-1.97 0-4.608-3.135-8.342-7.41-9.466 1.32-.975 2.295-2.975 2.295-6.215 0-4.816-3.135-8.746-7.412-8.746-2.322 0-4.522.85-6.29 2.282-.643-.12-1.28.2-1.92.49-.995 22.07-7.7 15.62-12.06 15.66-1.35-.27-2.74-.42-4.15-.42z"></path>
                                </svg>
                                GitHub Repo
                            </a>
                        @endif
                    </div>
                    @if($project->client_name)
                        <div class="text-sm text-slate-500">
                            Client: <span class="font-semibold text-slate-900 dark:text-white">{{ $project->client_name }}</span>
                        </div>
                    @endif
                </div>
            @endif

            <div class="p-8 sm:p-12 rounded-3xl bg-gradient-to-r from-blue-600 via-indigo-600 to-primary text-white shadow-xl text-center">
                <h3 class="text-2xl sm:text-3xl font-bold mb-3">Like what you see?</h3>
                <p class="text-blue-100 max-w-xl mx-auto mb-6">Need a custom web solution with similar architecture and clean delivery? Let's discuss your requirements!</p>
                <a href="{{ route('contact') }}"
                    class="inline-flex items-center gap-2 bg-white text-blue-700 hover:bg-blue-50 px-8 py-3.5 rounded-xl font-bold transition-all shadow-md hover:shadow-lg">
                    Hire Me For Your Project
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
