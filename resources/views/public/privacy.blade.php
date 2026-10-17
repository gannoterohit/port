@extends('public.layouts.app')

@section('title', ($page->seo_title ?? $page->title ?? 'Privacy Policy') . ' - ' . $websiteName)
@section('meta_description', $page->seo_description ?? Str::limit(strip_tags($page->content ?? ''), 160))

@section('content')
<section class="min-h-screen pt-28 sm:pt-36 pb-24 bg-[var(--theme-bg-canvas)] text-[var(--theme-text-heading)] relative overflow-hidden transition-colors duration-200">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10 max-w-7xl 2xl:max-w-[1400px]">
        <div class="max-w-4xl mx-auto">
            <div class="bg-[var(--theme-bg-card)] rounded-3xl border border-[var(--theme-border)] p-8 sm:p-12 shadow-xs">
                <header class="mb-8 pb-6 border-b border-[var(--theme-border)]">
                    <h1 class="text-3xl sm:text-4xl font-extrabold text-[var(--theme-text-heading)] tracking-tight">
                        {{ $page->title ?? 'Privacy Policy' }}
                    </h1>
                    <p class="text-xs text-[var(--theme-text-muted)] mt-2">
                        Last updated: {{ $page->updated_at ? $page->updated_at->format('F d, Y') : date('F d, Y') }}
                    </p>
                </header>

                <article class="prose max-w-none text-[var(--theme-text-body)] leading-relaxed">
                    {!! $page->content ?? '<p>Privacy policy content will be displayed here. Edit this page from the Admin Panel under Pages.</p>' !!}
                </article>
            </div>
        </div>
    </div>
</section>
@endsection
