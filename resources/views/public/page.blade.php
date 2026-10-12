@extends('public.layouts.app')

@section('title', $page->title . ' - ' . config('app.name'))
@section('meta_description', $page->meta_description ?? Str::limit(strip_tags($page->content), 160))

@isset($page->og_image_url)
    <meta property="og:image" content="{{ $page->og_image_url }}">
@endisset

@section('content')
<section class="min-h-screen pt-16 py-20">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <article class="prose dark:prose-invert max-w-none">
                <h1>{{ $page->title }}</h1>
                {!! $page->content !!}
            </article>
        </div>
    </div>
</section>
@endsection
