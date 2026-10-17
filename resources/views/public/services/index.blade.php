@extends('public.layouts.app')

@section('title', 'Services & Technical Solutions - ' . $websiteName)
@section('meta_description', 'Professional full-stack web development services including Laravel applications, RESTful APIs, modern frontend, database architecture, and performance optimization.')

@section('content')
<section class="min-h-screen pt-28 sm:pt-36 pb-24 bg-[var(--theme-bg-canvas)] text-[var(--theme-text-heading)] relative overflow-hidden transition-colors duration-200">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10 max-w-7xl 2xl:max-w-[1400px]">
        <div class="max-w-7xl 2xl:max-w-[1400px] mx-auto">
            <!-- Header Section -->
            <div class="text-center mb-16">
                <span class="inline-block text-xs font-bold uppercase tracking-wider text-brand badge-brand px-3.5 py-1 rounded-full mb-3.5 shadow-2xs">
                    What I Offer
                </span>
                <h1 class="text-4xl sm:text-5xl font-extrabold text-[var(--theme-text-heading)] tracking-tight mb-4">
                    Full Stack Development Services
                </h1>
                <p class="text-base sm:text-lg text-[var(--theme-text-body)] max-w-2xl mx-auto leading-relaxed">
                    End-to-end web engineering tailored for businesses, startups, and agencies requiring scalable, clean, and maintainable software.
                </p>
            </div>

            <!-- Services Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse($services as $service)
                    <div class="group bg-[var(--theme-bg-card)] rounded-3xl p-7 border border-[var(--theme-border)] hover:border-brand/40 shadow-xs flex flex-col h-full transition-all">
                        <div class="flex items-center justify-between mb-6">
                            @if($service->icon_url)
                                <img src="{{ $service->icon_url }}" alt="{{ $service->name }}" loading="lazy" decoding="async" class="w-14 h-14 object-contain rounded-xl p-2 bg-[var(--theme-bg-alt)] border border-[var(--theme-border)]">
                            @else
                                <div class="w-14 h-14 bg-brand/10 border border-brand/20 text-brand rounded-2xl flex items-center justify-center font-bold text-xl shadow-2xs transition-all">
                                    {{ substr($service->name, 0, 1) }}
                                </div>
                            @endif

                            @if($service->is_featured)
                                <span class="text-xs font-semibold px-2.5 py-1 rounded-full badge-brand text-brand font-bold shadow-2xs">
                                    Featured
                                </span>
                            @endif
                        </div>

                        <h2 class="text-xl font-bold text-[var(--theme-text-heading)] mb-3 group-hover:text-brand transition-colors">
                            <a href="{{ route('services.show', ['service' => $service->slug]) }}">
                                {{ $service->name }}
                            </a>
                        </h2>

                        <p class="text-[var(--theme-text-body)] text-sm mb-6 flex-1 line-clamp-3 leading-relaxed">
                            {{ $service->short_description ?? Str::limit(strip_tags($service->description), 140) }}
                        </p>

                        @if($service->features && is_array($service->features))
                            <ul class="space-y-2 mb-6 pt-4 border-t border-[var(--theme-border)]">
                                @foreach(array_slice($service->features, 0, 3) as $feat)
                                    <li class="flex items-center gap-2 text-xs text-[var(--theme-text-body)]">
                                        <svg class="w-4 h-4 text-brand shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span class="truncate">{{ $feat }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif

                        <div class="pt-4 border-t border-[var(--theme-border)] flex items-center justify-between mt-auto">
                            <span class="text-xs text-[var(--theme-text-muted)]">Free estimate</span>

                            <a href="{{ route('contact', ['service' => $service->slug]) }}"
                                aria-label="Get a quote for {{ $service->name }}"
                                class="inline-flex items-center gap-1.5 text-sm font-semibold text-brand hover:underline">
                                <span>Get a Quote</span>
                                <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-16 bg-[var(--theme-bg-card)] rounded-3xl border border-[var(--theme-border)]">
                        <h3 class="text-lg font-semibold text-[var(--theme-text-heading)] mb-1">No Services Available</h3>
                        <p class="text-[var(--theme-text-muted)] text-sm">Services are currently being updated. Please check back later.</p>
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
