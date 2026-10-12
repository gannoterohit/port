@extends('public.layouts.app')

@section('title', $project->title . ' - ' . $websiteName)
@section('meta_description', $project->short_description ?? Str::limit(strip_tags($project->description), 160))

@isset($project->og_image_url)
    <meta property="og:image" content="{{ $project->og_image_url }}">
@endisset

@section('content')
<section class="min-h-screen pt-16 py-20">
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

            @if($project->key_features)
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Key Features</h3>
                    @php
                        $features = is_string($project->key_features) ? explode('|', $project->key_features) : (is_array($project->key_features) ? $project->key_features : []);
                    @endphp
                    <ul class="space-y-2">
                        @foreach($features as $feature)
                            <li class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-gray-700 dark:text-gray-300">{{ trim($feature) }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if($project->description)
                <div class="prose dark:prose-invert max-w-none">
                    {!! nl2br(e($project->description)) !!}
                </div>
            @endif

            @if($project->screenshots->isNotEmpty())
                <div class="mt-12">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Screenshots</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($project->screenshots as $screenshot)
                            <img src="{{ $screenshot->image_url }}" alt="{{ $screenshot->caption ?? $project->title }}"
                                class="w-full h-48 object-cover rounded-xl shadow-md">
                        @endforeach
                    </div>
                </div>
            @endif

            @if($project->client_name || $project->demo_url || $project->github_url)
                <div class="mt-12 pt-8 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex flex-wrap gap-4 items-center justify-between">
                        @if($project->demo_url)
                            <a href="{{ $project->demo_url }}" target="_blank"
                                class="bg-primary hover:bg-primary-dark text-white px-6 py-3 rounded-lg font-medium flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 6h4m-4 0V4a2 2 0 014 0v2m-4 0h4m-4 0v2m4-2h2a2 2 0 012 2v4m-6-6h-2a2 2 0 00-2 2v6m0 0h12v-4m0 0l-8-4V8m4 4l4-2v6m0 0a2 2 0 004 0 2 2 0 00-4 0z"></path>
                                </svg>
                                Live Demo
                            </a>
                        @endif
                        @if($project->github_url)
                            <a href="{{ $project->github_url }}" target="_blank"
                                class="border-2 border-primary text-primary hover:bg-primary hover:text-white px-6 py-3 rounded-lg font-medium flex items-center gap-2">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 .296C8.875.296 6.25 2.922 6.25 6.057c0 2.69 1.749 4.948 4.178 5.714.3.055.412.215.412.479 0 .236-.008.866-.013 1.686C7.195 14.284 3.803 12.37 0 12.126c-.214-.035-.28.12-.28.277v3.185c0 1.89 1.28 3.528 3.16 4.067 0 .014.87.015 1.28.015.262 0 .404-.018.696-.333 2.075-2.088 3.894-3.294 6.16-3.338 2.23-.052 4.25 1.154 5.46 3.05.005.002.008.004.013.005.31.26.67.416 1.11.416 1.992 0 3.595-1.596 3.595-3.571 0-1.932-1.577-3.521-3.617-3.878.555-.447 1.046-1.008 1.464-1.686.612-.97 1.095-2.117 1.095-3.35 0-2.592-2.107-4.696-4.71-4.696-.233 0-.47.012-.707.035.002-.415.015-.827.015-1.241 0-.415-.01-1.276-.015-2.152-.006-.264.194-.563.462-.563.996-.012 1.777-.016 2.528-.002.07.005.156.08.15.15 0 .597-.008 1.016-.01 1.163.005.346.202.748.437.748 2.42 0 4.388-1.993 4.388-4.45 0-2.625-2.416-4.767-5.405-4.767-1.745 0-3.39.76-4.433 1.943A4.183 4.183 0 0 0 15.5 2.07a5.268 5.268 0 0 0-3.23-1.066z"></path>
                                </svg>
                                GitHub
                            </a>
                        @endif
                    </div>
                </div>
            @endif

            <div class="mt-12 pt-8 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ route('contact') }}"
                    class="inline-flex items-center gap-2 bg-primary hover:bg-primary-dark text-white px-6 py-3 rounded-lg font-medium">
                    Need a similar project? Let's talk!
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
