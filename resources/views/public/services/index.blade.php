@extends('public.layouts.app')

@section('title', 'Services & Technical Solutions - ' . $websiteName)
@section('meta_description', 'Professional full-stack web development services including Laravel applications, RESTful APIs, modern frontend, database architecture, and performance optimization.')

@section('content')
<section class="min-h-screen pt-28 sm:pt-36 pb-20 bg-slate-50 dark:bg-slate-950">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto">
            <!-- Header Section -->
            <div class="text-center mb-16">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold uppercase tracking-wider bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300 mb-4">
                    What I Offer
                </div>
                <h1 class="text-4xl sm:text-5xl font-extrabold text-slate-900 dark:text-white tracking-tight mb-4">
                    Professional Services
                </h1>
                <p class="text-lg text-slate-600 dark:text-slate-400 max-w-2xl mx-auto">
                    End-to-end web engineering tailored for businesses, startups, and agencies requiring scalable, clean, and maintainable software.
                </p>
            </div>

            <!-- Services Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($services as $service)
                    <div class="group bg-white dark:bg-slate-900 rounded-2xl p-7 border border-slate-200/80 dark:border-slate-800 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col h-full">
                        <div class="flex items-center justify-between mb-6">
                            @if($service->icon_url)
                                <img src="{{ $service->icon_url }}" alt="{{ $service->name }}" class="w-14 h-14 object-contain rounded-xl p-2 bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700">
                            @else
                                <div class="w-14 h-14 bg-blue-50 dark:bg-blue-950/60 text-blue-600 dark:text-blue-400 rounded-xl flex items-center justify-center border border-blue-100 dark:border-blue-900/50">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                                    </svg>
                                </div>
                            @endif

                            @if($service->is_featured)
                                <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300">
                                    Featured
                                </span>
                            @endif
                        </div>

                        <h2 class="text-2xl font-bold text-slate-900 dark:text-white mb-3 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                            <a href="{{ route('services.show', ['service' => $service->slug]) }}">
                                {{ $service->name }}
                            </a>
                        </h2>

                        <p class="text-slate-600 dark:text-slate-400 text-sm mb-6 flex-1 line-clamp-3 leading-relaxed">
                            {{ $service->short_description ?? Str::limit(strip_tags($service->description), 140) }}
                        </p>

                        @if($service->features && is_array($service->features))
                            <ul class="space-y-2 mb-6 pt-4 border-t border-slate-100 dark:border-slate-800/80">
                                @foreach(array_slice($service->features, 0, 3) as $feat)
                                    <li class="flex items-center gap-2 text-xs text-slate-600 dark:text-slate-400">
                                        <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span class="truncate">{{ $feat }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif

                        <div class="pt-4 border-t border-slate-100 dark:border-slate-800/80 flex items-center justify-between mt-auto">
                            @if($service->price_formatted)
                                <span class="text-lg font-bold text-blue-600 dark:text-blue-400">
                                    {{ $service->price_formatted }}
                                </span>
                            @else
                                <span class="text-xs text-slate-400">Custom Quote</span>
                            @endif

                            <a href="{{ route('services.show', ['service' => $service->slug]) }}"
                                class="inline-flex items-center gap-1.5 text-sm font-semibold text-slate-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                Learn More
                                <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-16 bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800">
                        <svg class="w-16 h-16 text-slate-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.27V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2h12.59l-2.7 2.7a1 1 0 00.7 1.7h3.07a2 2 0 002-2v-4.73"></path>
                        </svg>
                        <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200 mb-1">No Services Available</h3>
                        <p class="text-slate-500 dark:text-slate-400 text-sm">Services are currently being updated. Please check back later.</p>
                    </div>
                @endforelse
            </div>

            @if($services->hasPages())
                <div class="mt-12 flex justify-center">
                    {{ $services->links() }}
                </div>
            @endif
        </div>
    </div>
</section>
@endsection
