@extends('public.layouts.app')

@section('title', 'Featured Projects & Case Studies - ' . $websiteName)
@section('meta_description', 'Browse my portfolio of genuine web applications, client solutions, and full-stack software projects.')

@section('content')
<section class="min-h-screen pt-28 sm:pt-36 pb-24 bg-[#080C14] text-slate-100 relative overflow-hidden">
    <!-- Ambient Lighting & Dot Grid -->
    <div class="absolute inset-0 bg-grid-dots-dark opacity-35 pointer-events-none"></div>
    <div class="absolute -top-32 -left-20 w-[500px] h-[500px] bg-emerald-500/15 rounded-full blur-3xl pointer-events-none animate-pulse-glow"></div>
    <div class="absolute top-1/3 -right-20 w-[450px] h-[450px] bg-teal-500/10 rounded-full blur-3xl pointer-events-none animate-float-delayed"></div>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="max-w-7xl mx-auto">
            <!-- Header Section -->
            <div class="text-center mb-16">
                <span class="inline-block text-xs font-bold uppercase tracking-wider text-emerald-400 bg-emerald-500/10 border border-emerald-500/30 px-3.5 py-1 rounded-full mb-3.5 shadow-xs">
                    Portfolio Showcase
                </span>
                <h1 class="text-4xl sm:text-5xl font-extrabold text-white tracking-tight mb-4">
                    Featured Projects &amp; Case Studies
                </h1>
                <p class="text-base sm:text-lg text-slate-400 max-w-2xl mx-auto leading-relaxed">
                    A curated selection of robust full-stack web applications, APIs, and client platforms built with modern technology stacks.
                </p>
            </div>

            <!-- Search & Category Filter -->
            <form method="GET" action="{{ route('projects') }}" class="mb-10 flex flex-col sm:flex-row gap-3 items-stretch sm:items-center">
                <div class="relative flex-1">
                    <input type="search" name="search" value="{{ request('search') }}"
                        placeholder="Search projects..."
                        class="w-full px-4 py-3 rounded-xl border border-slate-700 bg-slate-900/90 text-white placeholder-slate-500 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent shadow-md">
                </div>
                @if(isset($categories) && $categories->isNotEmpty())
                    <select name="category"
                        class="px-4 py-3 rounded-xl border border-slate-700 bg-slate-900/90 text-white text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent sm:min-w-[180px] shadow-md">
                        <option value="">All categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category }}" {{ request('category') === $category ? 'selected' : '' }}>
                                {{ $category }}
                            </option>
                        @endforeach
                    </select>
                @endif
                <button type="submit"
                    class="btn-shimmer-effect inline-flex items-center justify-center px-6 py-3 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-500 hover:from-emerald-500 hover:to-teal-400 text-white text-sm font-semibold transition-all shadow-md shadow-emerald-500/25">
                    Filter
                </button>
                @if(request()->filled('search') || request()->filled('category'))
                    <a href="{{ route('projects') }}"
                        class="inline-flex items-center justify-center px-5 py-3 rounded-xl border border-slate-700 bg-slate-900/90 text-slate-300 hover:text-white text-sm font-medium transition-colors shadow-xs">
                        Clear
                    </a>
                @endif
            </form>

            <!-- 3-Column Projects Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($projects as $project)
                    <div class="group bg-[#0F172A]/90 rounded-2xl overflow-hidden border border-slate-800 shadow-xl card-glow-hover flex flex-col">
                        <a href="{{ route('projects.show', ['project' => $project->slug]) }}" class="relative block overflow-hidden aspect-[16/9] bg-slate-950">
                            @if($project->thumbnail_url)
                                <img src="{{ $project->thumbnail_url }}" alt="{{ $project->thumbnail_alt ?: $project->title }}" width="640" height="360" loading="lazy" decoding="async"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-400 bg-gradient-to-br from-slate-900 to-slate-950">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                            <div class="absolute top-3 right-3 flex gap-2">
                                @if($project->is_featured)
                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-gradient-to-r from-emerald-600 to-teal-500 text-white shadow-xs">
                                        Featured
                                    </span>
                                @endif
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-slate-950/80 backdrop-blur-md text-emerald-400 border border-emerald-500/30">
                                    {{ $project->category ?? 'Full Stack' }}
                                </span>
                            </div>
                        </a>

                        <div class="p-6 sm:p-7 flex-1 flex flex-col">
                            <h2 class="text-xl font-bold text-white mb-2 group-hover:text-emerald-400 transition-colors">
                                <a href="{{ route('projects.show', ['project' => $project->slug]) }}">
                                    {{ $project->title }}
                                </a>
                            </h2>

                            <p class="text-slate-400 text-sm mb-4 flex-1 line-clamp-3 leading-relaxed">
                                {{ $project->short_description ?? Str::limit(strip_tags($project->description), 140) }}
                            </p>

                            @if($project->role)
                                <div class="mb-4">
                                    <span class="inline-block text-[11px] font-medium text-emerald-300 bg-emerald-500/15 border border-emerald-500/30 px-2.5 py-0.5 rounded">
                                        Contribution: {{ $project->role }}
                                    </span>
                                </div>
                            @endif

                            @if($project->tech_stack && is_array($project->tech_stack))
                                <div class="flex flex-wrap gap-1.5 mb-6">
                                    @foreach(array_slice($project->tech_stack, 0, 5) as $tech)
                                        <span class="text-xs px-2.5 py-1 bg-slate-800 text-slate-300 rounded-md font-medium border border-slate-700/60">
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

                            <div class="pt-4 border-t border-slate-800 flex items-center justify-between mt-auto">
                                <a href="{{ route('projects.show', ['project' => $project->slug]) }}"
                                    aria-label="View details of {{ $project->title }}"
                                    class="inline-flex items-center gap-1.5 text-sm font-semibold text-emerald-400 hover:text-emerald-300 group-hover:underline">
                                    View Details
                                    <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>

                                <div class="flex items-center gap-3">
                                    @if($project->github_url)
                                        <a href="{{ $project->github_url }}" target="_blank" rel="noopener noreferrer"
                                            aria-label="GitHub source for {{ $project->title }}"
                                            class="text-slate-400 hover:text-emerald-400 transition-colors" title="View Source Code">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"/>
                                            </svg>
                                        </a>
                                    @endif
                                    @if($project->public_demo_url)
                                        <a href="{{ $project->public_demo_url }}" target="_blank" rel="noopener noreferrer"
                                            aria-label="Live preview of {{ $project->title }}"
                                            class="text-slate-400 hover:text-emerald-400 transition-colors" title="Live Preview">
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
                    <div class="col-span-full text-center py-16 bg-[#0F172A]/90 rounded-2xl border border-slate-800">
                        <svg class="w-16 h-16 text-slate-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        <h3 class="text-lg font-semibold text-white mb-1">No Projects Found</h3>
                        <p class="text-slate-400 text-sm">Check back soon for new case studies and project demonstrations.</p>
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
