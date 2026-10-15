@extends('public.layouts.app')

@section('title', 'Services & Technical Solutions - ' . $websiteName)
@section('meta_description', 'Professional full-stack web development services including Laravel applications, RESTful APIs, modern frontend, database architecture, and performance optimization.')

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
                    What I Offer
                </span>
                <h1 class="text-4xl sm:text-5xl font-extrabold text-white tracking-tight mb-4">
                    Full Stack Development Services
                </h1>
                <p class="text-base sm:text-lg text-slate-400 max-w-2xl mx-auto leading-relaxed">
                    End-to-end web engineering tailored for businesses, startups, and agencies requiring scalable, clean, and maintainable software.
                </p>
            </div>

            <!-- Services Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse($services as $service)
                    <div class="group bg-[#0F172A]/90 rounded-2xl p-7 border border-slate-800 shadow-xl card-glow-hover flex flex-col h-full transition-all">
                        <div class="flex items-center justify-between mb-6">
                            @if($service->icon_url)
                                <img src="{{ $service->icon_url }}" alt="{{ $service->name }}" loading="lazy" decoding="async" class="w-14 h-14 object-contain rounded-xl p-2 bg-slate-900 border border-slate-800">
                            @else
                                <div class="w-14 h-14 bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 group-hover:bg-gradient-to-br group-hover:from-emerald-500 group-hover:to-teal-500 group-hover:text-white rounded-xl flex items-center justify-center font-bold text-xl shadow-md transition-all">
                                    {{ substr($service->name, 0, 1) }}
                                </div>
                            @endif

                            @if($service->is_featured)
                                <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-gradient-to-r from-emerald-600 to-teal-500 text-white shadow-xs">
                                    Featured
                                </span>
                            @endif
                        </div>

                        <h2 class="text-xl font-bold text-white mb-3 group-hover:text-emerald-400 transition-colors">
                            <a href="{{ route('services.show', ['service' => $service->slug]) }}">
                                {{ $service->name }}
                            </a>
                        </h2>

                        <p class="text-slate-400 text-sm mb-6 flex-1 line-clamp-3 leading-relaxed">
                            {{ $service->short_description ?? Str::limit(strip_tags($service->description), 140) }}
                        </p>

                        @if($service->features && is_array($service->features))
                            <ul class="space-y-2 mb-6 pt-4 border-t border-slate-800">
                                @foreach(array_slice($service->features, 0, 3) as $feat)
                                    <li class="flex items-center gap-2 text-xs text-slate-300">
                                        <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span class="truncate">{{ $feat }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif

                        <div class="pt-4 border-t border-slate-800 flex items-center justify-between mt-auto">
                            <span class="text-xs text-slate-400">Free estimate</span>

                            <a href="{{ route('contact', ['service' => $service->slug]) }}"
                                aria-label="Get a quote for {{ $service->name }}"
                                class="inline-flex items-center gap-1.5 text-sm font-semibold text-emerald-400 hover:text-emerald-300 group-hover:underline">
                                Get a Quote
                                <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-16 bg-[#0F172A]/90 rounded-2xl border border-slate-800">
                        <svg class="w-16 h-16 text-slate-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.27V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2h12.59l-2.7 2.7a1 1 0 00.7 1.7h3.07a2 2 0 002-2v-4.73"></path>
                        </svg>
                        <h3 class="text-lg font-semibold text-white mb-1">No Services Available</h3>
                        <p class="text-slate-400 text-sm">Services are currently being updated. Please check back later.</p>
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
