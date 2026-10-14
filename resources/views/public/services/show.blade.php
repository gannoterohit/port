@extends('public.layouts.app')

@section('title', ($service->seo_title ?: $service->name) . ' - ' . $websiteName)
@section('meta_description', $service->seo_description ?: ($service->short_description ?? Str::limit(strip_tags($service->description), 160)))
@section('og_title', $service->og_title ?: $service->name)
@section('og_description', $service->og_description ?: ($service->short_description ?? Str::limit(strip_tags($service->description), 160)))
@section('og_image', $service->og_image_url ?: $service->icon_url)
@if($service->canonical_url)
    @section('canonical', $service->canonical_url)
@endif
@if($service->no_index)
    @section('meta_robots', 'noindex, nofollow')
@endif

@section('content')
<section class="min-h-screen pt-28 sm:pt-36 pb-24 bg-[#080C14] text-slate-100 relative overflow-hidden">
    <!-- Ambient Lighting & Dot Grid -->
    <div class="absolute inset-0 bg-grid-dots-dark opacity-35 pointer-events-none"></div>
    <div class="absolute -top-32 -left-20 w-[500px] h-[500px] bg-emerald-500/15 rounded-full blur-3xl pointer-events-none animate-pulse-glow"></div>
    <div class="absolute top-1/3 -right-20 w-[450px] h-[450px] bg-teal-500/10 rounded-full blur-3xl pointer-events-none animate-float-delayed"></div>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="max-w-4xl mx-auto space-y-10">
            <a href="{{ route('services') }}" class="text-emerald-400 hover:text-emerald-300 font-medium text-sm inline-flex items-center gap-2 group">
                <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back to Services
            </a>

            <div class="bg-[#0F172A]/90 rounded-2xl p-8 sm:p-10 border border-slate-800 shadow-xl space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center gap-6">
                    @if($service->icon_url)
                        <img src="{{ $service->icon_url }}" alt="{{ $service->name }}" class="w-16 h-16 object-contain p-2 rounded-xl bg-slate-900 border border-slate-800">
                    @else
                        <div class="w-16 h-16 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 flex items-center justify-center font-bold text-2xl shadow-md">
                            {{ substr($service->name, 0, 1) }}
                        </div>
                    @endif
                    <div class="flex-1">
                        <h1 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">{{ $service->name }}</h1>
                        <p class="text-sm text-slate-400 mt-2">Pricing depends on your requirements — request a free estimate.</p>
                    </div>
                </div>

                @if($service->short_description)
                    <p class="text-lg text-slate-300 leading-relaxed">{{ $service->short_description }}</p>
                @endif

                @if($service->description)
                    <div class="prose prose-invert max-w-none text-slate-300 text-base leading-relaxed pt-4 border-t border-slate-800">
                        {!! nl2br(e($service->description)) !!}
                    </div>
                @endif

                @if($service->features && is_array($service->features))
                    <div class="pt-6 border-t border-slate-800">
                        <h2 class="text-lg font-bold text-white mb-4">Included in this Service</h2>
                        <ul class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            @foreach($service->features as $feature)
                                <li class="flex items-start gap-2.5 p-3 rounded-xl bg-slate-900 border border-slate-800">
                                    <svg class="w-5 h-5 text-emerald-400 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="text-sm font-medium text-slate-200">{{ $feature }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if($service->image_url)
                    <div class="pt-6 border-t border-slate-800">
                        <img src="{{ $service->image_url }}" alt="{{ $service->name }}" loading="lazy" decoding="async" class="w-full rounded-xl border border-slate-800 shadow-md">
                    </div>
                @endif

                <div class="pt-6 border-t border-slate-800 flex flex-wrap gap-4 items-center justify-between">
                    <a href="{{ url($service->cta_url ?: route('contact', ['service' => $service->slug])) }}"
                        class="btn-shimmer-effect inline-flex items-center gap-2 px-6 py-3.5 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-500 hover:from-emerald-500 hover:to-teal-400 text-white font-semibold text-base transition-all shadow-lg shadow-emerald-500/25">
                        {{ $service->cta_text ?: ('Enquire for ' . $service->name) }}
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
