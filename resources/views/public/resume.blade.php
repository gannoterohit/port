@extends('public.layouts.app')

@section('title', 'Resume - ' . $websiteName)
@section('meta_description', $profile->biography ?? $siteDescription)

@isset($profile->og_image_url)
    <meta property="og:image" content="{{ $profile->og_image_url }}">
@endisset

@section('content')
<section class="min-h-screen pt-16 py-20 bg-gray-50 dark:bg-gray-900">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <div class="flex justify-between items-center mb-12">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Resume</h1>
                @if($profile->resume_url)
                    <a href="{{ $profile->resume_url }}" target="_blank" download
                        class="bg-primary hover:bg-primary-dark text-white px-6 py-3 rounded-lg font-medium flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1M12 12V2m0 0l-4 4m4-4l4 4M5 14h14a2 2 0 010 4H5a2 2 0 010-4z"></path>
                            </svg>
                        Download Resume
                    </a>
                @endif
            </div>

            <div class="prose dark:prose-invert max-w-none mb-12">
                @if($profile->biography)
                    {!! nl2br(e($profile->biography)) !!}
                @else
                    <p>No biography available.</p>
                @endif
            </div>

            @if($profile->experience_text)
                <div class="mb-12">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Professional Experience</h2>
                    <div class="prose dark:prose-invert max-w-none">
                        {!! nl2br(e($profile->experience_text)) !!}
                    </div>
                </div>
            @endif

            @php
                $categories = \App\Models\SkillCategory::where('is_enabled', true)
                    ->with(['skills' => function ($q) {
                        $q->where('is_enabled', true)->orderBy('display_order');
                    }])
                    ->orderBy('display_order')
                    ->get();
            @endphp

            @if($categories->isNotEmpty())
                <div class="mb-12">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Skills</h2>
                    <div class="space-y-6">
                        @foreach($categories as $category)
                            @if($category->skills->isNotEmpty())
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3"
                                        style="color: {{ $category->color }}">
                                        {{ $category->name }}
                                    </h3>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($category->skills as $skill)
                                            <span class="px-3 py-1 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-full text-sm shadow-sm">
                                                {{ $skill->name }} ({{ $skill->proficiency_label ?? $skill->proficiency }}%)
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif

            @if($profile->location || $profile->email || $profile->phone)
                <div class="mb-12">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Contact Information</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @if($profile->email)
                            <div>
                                <span class="block text-sm text-gray-500 dark:text-gray-400">Email</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ $profile->email }}</span>
                            </div>
                        @endif
                        @if($profile->phone)
                            <div>
                                <span class="block text-sm text-gray-500 dark:text-gray-400">Phone</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ $profile->phone }}</span>
                            </div>
                        @endif
                        @if($profile->location)
                            <div>
                                <span class="block text-sm text-gray-500 dark:text-gray-400">Location</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ $profile->location }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>
@endsection
