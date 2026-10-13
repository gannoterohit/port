@extends('public.layouts.app')

@section('title', ($page->seo_title ?? $page->title ?? 'Privacy Policy') . ' - ' . $websiteName)
@section('meta_description', $page->seo_description ?? Str::limit(strip_tags($page->content ?? ''), 160))

@section('content')
<section class="min-h-screen pt-28 sm:pt-36 pb-24 bg-[#F5F7F2]">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-2xl border border-[#E5E7EB] p-8 sm:p-12 shadow-xs">
                <header class="mb-8 pb-6 border-b border-[#E5E7EB]">
                    <h1 class="text-3xl sm:text-4xl font-extrabold text-[#1F2937] tracking-tight">
                        {{ $page->title ?? 'Privacy Policy' }}
                    </h1>
                    <p class="text-xs text-[#667085] mt-2">
                        Last updated: {{ $page->updated_at ? $page->updated_at->format('F d, Y') : date('F d, Y') }}
                    </p>
                </header>

                <article class="prose max-w-none text-[#1F2937] prose-headings:font-bold prose-a:text-[#1B560B] leading-relaxed">
                    {!! $page->content ?? '<p>Privacy policy content will be displayed here. Edit this page from the Admin Panel under Pages.</p>' !!}
                </article>
            </div>
        </div>
    </div>
</section>
@endsection
