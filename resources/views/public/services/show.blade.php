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
<section class="min-h-screen pt-28 sm:pt-36 pb-24 bg-[#F5F7F2]">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto space-y-10">
            <a href="{{ route('services') }}" class="text-[#1B560B] hover:text-[#144208] font-medium text-sm inline-flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back to Services
            </a>

            <div class="bg-white rounded-2xl p-8 sm:p-10 border border-[#E5E7EB] shadow-xs space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center gap-6">
                    @if($service->icon_url)
                        <img src="{{ $service->icon_url }}" alt="{{ $service->name }}" class="w-16 h-16 object-contain p-2 rounded-xl bg-[#F5F7F2] border border-[#E5E7EB]">
                    @else
                        <div class="w-16 h-16 rounded-xl bg-[#DCE8D6] text-[#1B560B] flex items-center justify-center font-bold text-2xl border border-[#DCE8D6]">
                            {{ substr($service->name, 0, 1) }}
                        </div>
                    @endif
                    <div class="flex-1">
                        <h1 class="text-3xl sm:text-4xl font-extrabold text-[#1F2937] tracking-tight">{{ $service->name }}</h1>
                        @if($service->price_formatted)
                            <p class="text-xl font-bold text-[#1B560B] mt-1">{{ $service->price_formatted }}</p>
                        @endif
                    </div>
                </div>

                @if($service->short_description)
                    <p class="text-lg text-[#667085] leading-relaxed">{{ $service->short_description }}</p>
                @endif

                @if($service->description)
                    <div class="prose max-w-none text-[#667085] text-base leading-relaxed pt-4 border-t border-[#E5E7EB]">
                        {!! nl2br(e($service->description)) !!}
                    </div>
                @endif

                @if($service->features && is_array($service->features))
                    <div class="pt-6 border-t border-[#E5E7EB]">
                        <h2 class="text-lg font-bold text-[#1F2937] mb-4">Included in this Service</h2>
                        <ul class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            @foreach($service->features as $feature)
                                <li class="flex items-start gap-2.5 p-3 rounded-xl bg-[#F5F7F2] border border-[#E5E7EB]">
                                    <svg class="w-5 h-5 text-[#1B560B] mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="text-sm font-medium text-[#1F2937]">{{ $feature }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if($service->image_url)
                    <div class="pt-6 border-t border-[#E5E7EB]">
                        <img src="{{ $service->image_url }}" alt="{{ $service->name }}" class="w-full rounded-xl border border-[#E5E7EB] shadow-xs">
                    </div>
                @endif

                <div class="pt-6 border-t border-[#E5E7EB] flex flex-wrap gap-4 items-center justify-between">
                    <a href="{{ $service->cta_url ?: route('contact', ['service' => $service->slug]) }}"
                        class="inline-flex items-center gap-2 px-6 py-3.5 rounded-lg bg-[#1B560B] hover:bg-[#144208] text-white font-semibold text-base transition-all shadow-xs">
                        {{ $service->cta_text ?: ('Enquire for ' . $service->name) }}
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
