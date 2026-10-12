@extends('public.layouts.app')

@section('title', $profile->full_name . ' - ' . $websiteName)
@section('meta_description', $profile->bio ?? 'Full Stack Web Developer portfolio')

@section('content')
<section class="min-h-screen pt-16">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="max-w-4xl mx-auto text-center">
            @if($profile->profile_photo_url)
                <img src="{{ $profile->profile_photo_url }}" alt="{{ $profile->full_name }}"
                    class="w-32 h-32 rounded-full mx-auto mb-6 object-cover border-4 border-white shadow-lg">
            @endif
            <h1 class="text-4xl sm:text-5xl font-bold text-gray-900 dark:text-white mb-4">
                Hi, I'm <span class="text-primary">{{ $profile->first_name }}</span> {{ $profile->last_name }}
            </h1>
            <p class="text-xl text-gray-600 dark:text-gray-400 mb-8 max-w-2xl mx-auto">
                {{ $profile->bio ?? $profile->title ?? 'Full Stack Web Developer' }}
            </p>
            <div class="flex flex-wrap gap-4 justify-center">
                <a href="{{ route('projects') }}"
                    class="bg-primary hover:bg-primary-dark text-white px-8 py-3 rounded-lg text-sm font-medium">
                    View My Work
                </a>
                <a href="{{ route('contact') }}"
                    class="border-2 border-primary text-primary hover:bg-primary hover:text-white px-8 py-3 rounded-lg text-sm font-medium">
                    Contact Me
                </a>
            </div>
        </div>
    </div>
</section>

@if($skills && $skills->isNotEmpty())
<section class="bg-gray-50 dark:bg-gray-800 py-12">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white text-center mb-3">My Skills</h2>
            <p class="text-gray-600 dark:text-gray-400 text-center mb-12 max-w-2xl mx-auto">
                Technologies I work with
            </p>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                @foreach($skills as $skill)
                    <div class="bg-white dark:bg-gray-800 rounded-lg p-4 text-center shadow-sm">
                        <div class="text-primary font-bold text-lg mb-1">{{ $skill->name }}</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $skill->category->name ?? '' }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif

@if($featuredProjects->isNotEmpty())
<section class="py-20">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white text-center mb-3">Featured Projects</h2>
            <p class="text-gray-600 dark:text-gray-400 text-center mb-12 max-w-2xl mx-auto">
                A selection of projects I've worked on
            </p>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($featuredProjects as $project)
                    <a href="{{ route('projects.show', ['project' => $project->slug]) }}" class="group block">
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden group-hover:shadow-xl transition-shadow h-full flex flex-col">
                            @if($project->thumbnail_url)
                                <img src="{{ $project->thumbnail_url }}" alt="{{ $project->title }}"
                                    class="w-full h-48 object-cover">
                            @endif
                            <div class="p-6 flex-1 flex flex-col">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">{{ $project->title }}</h3>
                                <p class="text-gray-600 dark:text-gray-400 text-sm mb-4 flex-1">
                                    {{ Str::limit(strip_tags($project->description), 120) }}
                                </p>
                                @if($project->tech_stack && is_array($project->tech_stack))
                                    <div class="flex flex-wrap gap-1 mt-auto">
                                        @foreach($project->tech_stack as $tech)
                                            <span class="text-xs px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded">
                                                {{ $tech }}
                                            </span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="text-center mt-12">
                <a href="{{ route('projects') }}" class="text-primary font-medium hover:text-primary-dark inline-flex items-center gap-2">
                    View all projects
                </a>
            </div>
        </div>
    </div>
</section>
@endif

@if($featuredServices->isNotEmpty())
<section class="bg-gray-50 dark:bg-gray-800 py-20">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white text-center mb-3">What I Do</h2>
            <p class="text-gray-600 dark:text-gray-400 text-center mb-12 max-w-2xl mx-auto">
                Services I offer to help bring your digital ideas to life
            </p>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($featuredServices as $service)
                    <a href="{{ route('services.show', ['service' => $service->slug]) }}" class="group block">
                        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-md p-6 h-full group-hover:shadow-xl transition-shadow">
                            @if($service->icon_url)
                                <img src="{{ $service->icon_url }}" alt="{{ $service->name }}" class="w-14 h-14 mb-4">
                            @endif
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">{{ $service->name }}</h3>
                            <p class="text-gray-600 dark:text-gray-400 text-sm">{{ Str::limit(strip_tags($service->description), 120) }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif

@if($workProcesses->isNotEmpty())
<section class="py-20">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white text-center mb-3">My Work Process</h2>
            <p class="text-gray-600 dark:text-gray-400 text-center mb-12 max-w-2xl mx-auto">
                How I approach each project
            </p>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($workProcesses as $process)
                    <div class="text-center">
                        @if($process->icon_url)
                            <img src="{{ $process->icon_url }}" alt="{{ $process->title }}" class="w-16 h-16 mx-auto mb-4">
                        @endif
                        <h3 class="font-bold text-gray-900 dark:text-white mb-2">{{ $process->title }}</h3>
                        <p class="text-xs text-gray-600 dark:text-gray-400">{{ Str::limit(strip_tags($process->description), 80) }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif

@if($testimonials->isNotEmpty())
<section class="bg-gray-50 dark:bg-gray-800 py-20">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-3">Client Testimonials</h2>
            <p class="text-gray-600 dark:text-gray-400 text-center mb-12 max-w-2xl mx-auto">
                What clients say about my work
            </p>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($testimonials as $testimonial)
                    <div class="bg-white dark:bg-gray-900 rounded-xl shadow-md p-6 h-full">
                        <p class="text-gray-600 dark:text-gray-400 text-sm italic mb-4">
                            "{{ Str::limit(strip_tags($testimonial->feedback), 150) }}"
                        </p>
                        <div class="font-semibold text-gray-900 dark:text-white">{{ $testimonial->name }}</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ $testimonial->role_company }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif
@endsection
