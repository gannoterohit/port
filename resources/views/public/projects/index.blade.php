@extends('public.layouts.app')

@section('title', 'Projects - ' . $websiteName)
@section('meta_description', 'My portfolio projects')

@section('content')
<section class="min-h-screen pt-16 py-20 bg-gray-50 dark:bg-gray-900">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-12">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-3">My Projects</h1>
                <p class="text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                    A selection of projects I've worked on across different industries.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($projects as $project)
                    <a href="{{ route('projects.show', ['project' => $project->slug]) }}" class="group block">
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden group-hover:shadow-xl transition-shadow h-full flex flex-col">
                            @if($project->thumbnail_url)
                                <img src="{{ $project->thumbnail_url }}" alt="{{ $project->title }}"
                                    class="w-full h-48 object-cover">
                            @endif
                            <div class="p-6 flex-1 flex flex-col">
                                <div class="flex items-center justify-between mb-2">
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ $project->title }}</h3>
                                    <span class="text-xs px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded-full">
                                        {{ $project->category ?? 'Uncategorized' }}
                                    </span>
                                </div>
                                <p class="text-gray-600 dark:text-gray-400 text-sm mb-4 flex-1">
                                    {{ $project->short_description ?? Str::limit(strip_tags($project->description), 120) }}
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
                @empty
                    <p class="col-span-full text-center text-gray-500 dark:text-gray-400">No projects found.</p>
                @endforelse
            </div>

            @if($projects->hasPages())
                <div class="mt-12">
                    {{ $projects->links() }}
                </div>
            @endif
        </div>
    </div>
</section>
@endsection
