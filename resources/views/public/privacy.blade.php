@extends('public.layouts.app')

@section('title', ($page->seo_title ?? $page->title ?? 'Privacy Policy') . ' - ' . $websiteName)
@section('meta_description', $page->seo_description ?? Str::limit(strip_tags($page->content ?? ''), 160))

@section('content')
<section class="min-h-screen pt-28 sm:pt-36 pb-20 bg-slate-50 dark:bg-slate-950">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-200/80 dark:border-slate-800 p-8 sm:p-12">
            <h1 class="text-3xl sm:text-4xl font-bold text-slate-900 dark:text-white mb-2">
                {{ $page->title ?? 'Privacy Policy' }}
            </h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mb-8 pb-6 border-b border-slate-100 dark:border-slate-800">
                Last updated: {{ $page->updated_at ? $page->updated_at->format('F d, Y') : date('F d, Y') }}
            </p>

            <div class="prose dark:prose-invert max-w-none text-slate-700 dark:text-slate-300">
                {!! $page->content ?? '<p>Privacy policy content will be displayed here.</p>' !!}
            </div>
        </div>
    </div>
</section>
@endsection

