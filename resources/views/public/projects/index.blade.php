@extends('public.layouts.app')

@section('title', 'Featured Projects & Case Studies - ' . $websiteName)
@section('meta_description', 'Browse my portfolio of genuine web applications, client solutions, and full-stack software projects.')

@section('content')
<section class="min-h-screen pt-28 sm:pt-36 pb-20 bg-slate-50 dark:bg-slate-950">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <!-- Header Section -->
            <div class="text-center mb-16">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold uppercase tracking-wider bg-emerald-100 text-emerald-800 dark:bg-emerald-950/40 dark:text-emerald-300 mb-4">
                    Case Studies & Work
                </div>
                <h1 class="text-4xl sm:text-5xl font-extrabold text-slate-900 dark:text-white tracking-tight mb-4">
                    Featured Projects
                </h1>
                <p class="text-lg text-slate-600 dark:text-slate-400 max-w-2xl mx-auto">
                    A curated selection of robust full-stack web applications, APIs, and client platforms built with modern technology stacks.
                </p>
            </div>

            <!-- Projects Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($projects as $project)
                    <div class="group bg-white dark:bg-slate-900 rounded-2xl overflow-hidden border border-slate-200/80 dark:border-slate-800 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col">
                        <a href="{{ route('projects.show', ['project' => $project->slug]) }}" class="relative block overflow-hidden aspect-video bg-slate-100 dark:bg-slate-800">
                            @if($project->thumbnail_url)
                                <img src="{{ $project->thumbnail_url }}" alt="{{ $project->thumbnail_alt ?: $project->title }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-400 dark:text-slate-600">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                            <div class="absolute top-3 right-3 flex gap-2">
                                @if($project->is_featured)
                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-amber-500 text-white shadow-sm">
                                        Featured
                                    </span>
                                @endif
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-slate-900/80 backdrop-blur-sm text-white">
                                    {{ $project->category ?? 'Full Stack' }}
                                </span>
                            </div>
                        </a>

                        <div class="p-6 flex-1 flex flex-col">
                            <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-2 group-hover:text-emerald-700 dark:group-hover:text-emerald-400 transition-colors">
                                <a href="{{ route('projects.show', ['project' => $project->slug]) }}">
                                    {{ $project->title }}
                                </a>
                            </h2>

                            <p class="text-slate-600 dark:text-slate-400 text-sm mb-5 flex-1 line-clamp-3">
                                {{ $project->short_description ?? Str::limit(strip_tags($project->description), 140) }}
                            </p>

                            @if($project->tech_stack && is_array($project->tech_stack))
                                <div class="flex flex-wrap gap-1.5 mb-6">
                                    @foreach(array_slice($project->tech_stack, 0, 5) as $tech)
                                        <span class="text-xs px-2.5 py-1 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 rounded-md font-medium">
                                            {{ $tech }}
                                        </span>
                                    @endforeach
                                    @if(count($project->tech_stack) > 5)
                                        <span class="text-xs px-2 py-1 text-slate-400 font-medium">
                                            +{{ count($project->tech_stack) - 5 }}
                                        </span>
                                    @endif
                                </div>
                            @endif

                            <div class="pt-4 border-t border-slate-100 dark:border-slate-800/80 flex items-center justify-between mt-auto">
                                <a href="{{ route('projects.show', ['project' => $project->slug]) }}"
                                    class="inline-flex items-center gap-1.5 text-sm font-semibold text-emerald-700 dark:text-emerald-400 hover:text-emerald-800 dark:hover:text-emerald-300">
                                    View Details
                                    <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>

                                <div class="flex items-center gap-3">
                                    @if($project->github_url)
                                        <a href="{{ $project->github_url }}" target="_blank" rel="noopener noreferrer"
                                            class="text-slate-400 hover:text-slate-700 dark:hover:text-slate-200 transition-colors" title="View Source Code">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"/>
                                            </svg>
                                        </a>
                                    @endif
                                    @if($project->demo_url)
                                        <a href="{{ $project->demo_url }}" target="_blank" rel="noopener noreferrer"
                                            class="text-slate-400 hover:text-emerald-700 dark:hover:text-emerald-400 transition-colors" title="Live Preview">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                            </svg>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-16 bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800">
                        <svg class="w-16 h-16 text-slate-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200 mb-1">No Projects Found</h3>
                        <p class="text-slate-500 dark:text-slate-400 text-sm">Check back soon for new case studies and project demonstrations.</p>
                    </div>
                @endforelse
            </div>

            @if($projects->hasPages())
                <div class="mt-12 flex justify-center">
                    {{ $projects->links() }}
                </div>
            @endif
        </div>
    </div>
</section>
@endsection

