@extends('public.layouts.app')

@section('title', ($page->seo_title ?: $page->title) . ' - ' . $websiteName)
@section('meta_description', $page->seo_description ?: ($page->meta_description ?? Str::limit(strip_tags($page->content), 160)))
@section('og_title', $page->og_title ?: $page->title)
@section('og_description', $page->og_description ?: ($page->seo_description ?? Str::limit(strip_tags($page->content), 160)))
@if($page->og_image_url)
    @section('og_image', $page->og_image_url)
@endif
@if($page->canonical_url)
    @section('canonical', $page->canonical_url)
@endif
@if($page->no_index)
    @section('meta_robots', 'noindex, nofollow')
@endif

@section('content')
<section class="min-h-screen pt-28 sm:pt-36 pb-24 bg-[#080C14] text-slate-100 relative overflow-hidden">
    <!-- Ambient Lighting & Dot Grid -->
    <div class="absolute inset-0 bg-grid-dots-dark opacity-35 pointer-events-none"></div>
    <div class="absolute -top-32 -left-20 w-[500px] h-[500px] bg-emerald-500/15 rounded-full blur-3xl pointer-events-none animate-pulse-glow"></div>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="max-w-4xl mx-auto">
            <div class="bg-[#0F172A]/90 rounded-2xl border border-slate-800 p-8 sm:p-12 shadow-xl">
                <header class="mb-8 pb-6 border-b border-slate-800">
                    <h1 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">
                        {{ $page->title }}
                    </h1>
                    @if($page->updated_at)
                        <p class="text-xs text-slate-400 mt-2">
                            Last updated: {{ $page->updated_at->format('F d, Y') }}
                        </p>
                    @endif
                </header>

                <article class="prose prose-invert max-w-none text-slate-300 prose-headings:text-white prose-a:text-emerald-400 leading-relaxed">
                    {!! $page->content !!}
                </article>
            </div>
        </div>
    </div>
</section>
@endsection
