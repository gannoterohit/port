@extends('public.layouts.app')

@section('title', ($service->seo_title ?: $service->name) . ' - ' . $websiteName)
@section('meta_description', $service->seo_description ?: ($service->short_description ?? Str::limit(strip_tags($service->description), 160)))
@section('og_title', $service->og_title ?: $service->name)
@section('og_description', $service->og_description ?: ($service->short_description ?? Str::limit(strip_tags($service->description), 160)))
@section('og_image', $service->og_image_url ?: $service->icon_url)
@section('canonical', $service->canonical_url ?: url()->current())
@section('meta_robots', $service->no_index ? 'noindex, nofollow' : 'index, follow')

@section('content')
<section class="min-h-0 sm:min-h-screen pt-24 sm:pt-36 pb-28 sm:pb-24 bg-[var(--theme-bg-canvas)] text-[var(--theme-text-heading)] relative overflow-hidden transition-colors duration-200">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10 max-w-7xl 2xl:max-w-[1400px]">
        <div class="max-w-4xl mx-auto space-y-8">
            <a href="{{ route('services') }}" class="text-brand hover:underline font-semibold text-xs sm:text-sm inline-flex items-center gap-2 group">
                <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                <span>Back to Services</span>
            </a>

            <div class="bg-[var(--theme-bg-card)] rounded-3xl p-8 sm:p-10 border border-[var(--theme-border)] shadow-xs space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center gap-6">
                    @if($service->icon_url)
                        <img src="{{ $service->icon_url }}" alt="{{ $service->name }}" class="w-16 h-16 object-contain p-2 rounded-2xl bg-[var(--theme-bg-alt)] border border-[var(--theme-border)]">
                    @else
                        <div class="w-16 h-16 rounded-2xl bg-brand/10 border border-brand/20 text-brand flex items-center justify-center font-bold text-2xl shadow-2xs">
                            {{ substr($service->name, 0, 1) }}
                        </div>
                    @endif
                    <div class="flex-1">
                        <h1 class="text-3xl sm:text-4xl font-extrabold text-[var(--theme-text-heading)] tracking-tight">{{ $service->name }}</h1>
                        <p class="text-sm text-[var(--theme-text-muted)] mt-1">Pricing depends on your requirements — request a free estimate.</p>
                    </div>
                </div>

                @if($service->short_description)
                    <p class="text-base sm:text-lg text-[var(--theme-text-body)] leading-relaxed">{{ $service->short_description }}</p>
                @endif

                @if($service->description)
                    <div class="text-[var(--theme-text-body)] text-base leading-relaxed pt-4 border-t border-[var(--theme-border)] space-y-3">
                        {!! nl2br(e($service->description)) !!}
                    </div>
                @endif

                @if($service->features && is_array($service->features))
                    <div class="pt-6 border-t border-[var(--theme-border)]">
                        <h2 class="text-lg font-bold text-[var(--theme-text-heading)] mb-4">Included in this Service</h2>
                        <ul class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            @foreach($service->features as $feature)
                                <li class="flex items-start gap-2.5 p-3.5 rounded-2xl bg-[var(--theme-bg-alt)] border border-[var(--theme-border)]">
                                    <svg class="w-4 h-4 text-brand mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="text-xs sm:text-sm font-medium text-[var(--theme-text-heading)]">{{ $feature }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if($service->image_url)
                    <div class="pt-6 border-t border-[var(--theme-border)]">
                        <img src="{{ $service->image_url }}" alt="{{ $service->name }}" loading="lazy" decoding="async" class="w-full rounded-2xl border border-[var(--theme-border)] shadow-xs">
                    </div>
                @endif

                <div class="pt-6 border-t border-[var(--theme-border)] flex flex-wrap gap-4 items-center justify-between">
                    <a href="{{ url($service->cta_url ?: route('contact', ['service' => $service->slug])) }}"
                        class="theme-btn-primary inline-flex items-center gap-2 px-7 py-3.5 rounded-full font-semibold text-xs sm:text-sm transition-all shadow-sm hover:scale-[1.02]">
                        <span>{{ $service->cta_text ?: ('Enquire for ' . $service->name) }}</span>
                        <svg class="w-4 h-4 ml-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
