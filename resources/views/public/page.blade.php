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
<section class="min-h-screen pt-28 sm:pt-36 pb-24 bg-[#F5F7F2]">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-2xl border border-[#E5E7EB] p-8 sm:p-12 shadow-xs">
                <header class="mb-8 pb-6 border-b border-[#E5E7EB]">
                    <h1 class="text-3xl sm:text-4xl font-extrabold text-[#1F2937] tracking-tight">
                        {{ $page->title }}
                    </h1>
                    @if($page->updated_at)
                        <p class="text-xs text-[#667085] mt-2">
                            Last updated: {{ $page->updated_at->format('F d, Y') }}
                        </p>
                    @endif
                </header>

                <article class="prose max-w-none text-[#1F2937] prose-headings:font-bold prose-a:text-[#1B560B] leading-relaxed">
                    {!! $page->content !!}
                </article>
            </div>
        </div>
    </div>
</section>
@endsection
