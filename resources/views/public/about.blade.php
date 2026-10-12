@extends('public.layouts.app')

@section('title', 'About - ' . $websiteName)
@section('meta_description', $profile->bio ?? 'Learn more about me')

@isset($profile->og_image_url)
    <meta property="og:image" content="{{ $profile->og_image_url }}">
@endisset

@section('content')
<section class="min-h-screen pt-16 py-20">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <div class="flex flex-col md:flex-row gap-12 items-center mb-12">
                @if($profile->profile_photo_url)
                    <img src="{{ $profile->profile_photo_url }}" alt="{{ $profile->full_name }}"
                        class="w-48 h-48 rounded-2xl object-cover shadow-xl">
                @endif
                <div class="flex-1">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">About Me</h1>
                    <h2 class="text-2xl text-primary font-semibold mb-4">{{ $profile->title }}</h2>
                    @if($profile->subtitle)
                        <p class="text-lg text-gray-600 dark:text-gray-400 mb-6">{{ $profile->subtitle }}</p>
                    @endif
                    <div class="prose dark:prose-invert max-w-none">
                        {!! nl2br(e($profile->intro ?? $profile->biography ?? '')) !!}
                    </div>
                </div>
            </div>

            @if($profile->location || $profile->email || $profile->phone)
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 mb-8">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Contact Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @if($profile->email)
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Email</span>
                                    <span class="block font-medium text-gray-900 dark:text-white">{{ $profile->email }}</span>
                                </div>
                            </div>
                        @endif
                        @if($profile->phone)
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.14 3.317a1 1 0 01-.54 1.212l-2.52 1.027a.5.5 0 00-.25.278L8.19 11.88a6 6 0 005.92 5.92l.27-1.35a1 1 0 01.27-.41l2.2-2.2a1 1 0 011.11-.22l3.31 1.14A1 1 0 0121 11.72V15a2 2 0 01-2 2h-2"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="text-sm text-gray-500 dark:text-gray-400">Phone</span>
                                        <span class="block font-medium text-gray-900 dark:text-white">{{ $profile->phone }}</span>
                                    </div>
                                </div>
                            @endif
                        @if($profile->location && $profile->location_visible)
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.982 18.724A7.481 7.481 0 0112 20a7.481 7.481 0 01-5.982-2.276m11.964 0A10.954 10.954 0 0012 22c-2.648 0-5.145-.97-7.024-2.545A7.478 7.478 0 0112 17.5a7.478 7.478 0 015.982 2.276z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Location</span>
                                    <span class="block font-medium text-gray-900 dark:text-white">{{ $profile->location }}</span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            @if($profile->social_links)
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 mb-8">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Social Profiles</h3>
                    <div class="flex gap-4">
                        @foreach($profile->social_links as $platform => $url)
                            <a href="{{ $url }}" target="_blank"
                                class="w-10 h-10 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center text-gray-600 dark:text-gray-300 hover:text-primary transition-colors">
                                <span class="sr-only">{{ ucfirst($platform) }}</span>
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    @if($platform === 'github')
                                        <path d="M12 .296C5.371 0 0 5.371 0 12.004c0 5.302 3.544 9.8 8.434 11.386.6.112.82-.262.82-.58 0-.286-.01-1.186-.015-2.148-3.429.756-4.141-1.647-4.141-1.647-.555-1.401-1.342-1.77-1.342-1.77-1.09-.75.084-.735.084-.735 1.203.084 1.836 1.24 1.836 1.24 1.067 1.83 2.805 1.305 3.49.996.108-.782.418-1.305.762-1.605-2.665-.305-5.467-1.335-5.467-5.935 0-1.311.47-2.381 1.236-3.221-.124-.303-.053-.823.027-1.646 0 0 .027-.086.997 1.203 3.186-.998 4.263-.274 4.263-.274.34.861.995 1.685 1.715 1.998.82-.122 1.64-.247 2.456-.449 0 0 1.09-.19 2.24 1.226 0 0 1.105-1.156 1.568-2.779 0 0 .42-1.325.027-2.779 0 0 1.59-.041 2.997 1.229.96-.273 1.99-.822 3.01-1.599.762 1.155 1.142 2.497 1.142 3.91 0 1.566.015 3.132.015 3.589 0 0 .084.49.82 1.295.932 1.2 1.42 1.964 1.42 1.964.534.889 1.158 1.341 1.81.995 1.27-.338 1.72-.881 2.03.336.265.999.82 1.787 1.427 2.423.81-.161 1.6-.48 2.27-.93.074-.554.136-1.435.136-1.97 0-4.608-3.135-8.342-7.41-9.466 1.32-.975 2.295-2.975 2.295-6.215 0-4.816-3.135-8.746-7.412-8.746-2.322 0-4.522.85-6.29 2.282-.643-.12-1.28.2-1.92.49-.995 22.07-7.7 15.62-12.06 15.66-1.35-.27-2.74-.42-4.15-.42z"></path>
                                    @endif
                                    @if($platform === 'linkedin')
                                        <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.846-3.037-1.851 0-2.136 1.445-2.136 2.942v5.664h-3.554V9h3.373v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.456v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019h-3.554V9h3.554v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"></path>
                                    @endif
                                    @if($platform === 'twitter')
                                        <path d="M23.954 4.569c-.885.389-1.83.654-2.825.775 1.014-.611 1.794-1.574 2.163-2.723-.951.555-2.005.959-3.127 1.184-.897-.959-2.178-1.559-3.594-1.559-2.723 0-4.928 2.206-4.928 4.928 0 .386.043.762.127 1.124C8.191 8.094 5.192 6.135 3.074 3.17c-.427.722-.666 1.561-.666 2.475 0 1.71.87 3.19 2.188 4.07-.802-.025-1.56-.245-2.228-.616v.062c0 2.386 1.698 4.376 3.951 4.827-.414.112-.85.17-1.276.17.181-.001.35-.021.515-.058-.43 1.335-1.416 2.554-2.629 3.269C5.125 19.145 7.375 20 9.29 20 3.514 20 0 16.486 0 12.082 1.29 11.414 2.755 10.759 4.308 10.297c-.035-.008-.066-.016-.1-.023 0-.023.001-.046.001-.069 0-2.723 2.213-4.935 4.928-4.935 1.345 0 2.541.39 3.536 1.028l.001-.002c.05 1.704 1.25 3.182 2.942 3.547-1.02.755-2.255 1.202-3.617 1.202-.017 0-.033-.001-.05-.001.045 1.841 1.435 3.372 3.318 3.694 3.166 3.166 8.475 1.49 9.846-2.462 1.028-.745 1.912-1.69 2.536-2.76l.001-.001c1.2-.865 2.18-1.92 2.78-3.066 1.235-.987 2.174-2.298 2.77-3.736 0-.047-.001-.093-.001-.14z"></path>
                                    @endif
                                </svg>
                            </a>
                        @endforeach
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
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2"
                                        style="color: {{ $category->color }}">
                                        {{ $category->name }}
                                    </h3>
                                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-2">
                                        @foreach($category->skills as $skill)
                                            <span class="px-3 py-1 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-full text-sm">
                                                {{ $skill->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif

            @if($profile->experience_text)
                <div class="mb-12">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">My Experience</h2>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                        {{ $profile->experience_text }}
                    </p>
                </div>
            @endif

            @if($profile->resume_url && $profile->resume_button_visible)
                <div class="text-center">
                    <a href="{{ $profile->resume_url }}" target="_blank" download
                        class="inline-flex items-center gap-2 bg-primary hover:bg-primary-dark text-white px-8 py-3 rounded-lg font-medium">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1M12 12V2m0 0l-4 4m4-4l4 4M5 14h14a2 2 0 010 4H5a2 2 0 010-4z"></path>
                        </svg>
                        Download Resume
                    </a>
                </div>
            @endif
        </div>
    </div>
</section>
@endsection
