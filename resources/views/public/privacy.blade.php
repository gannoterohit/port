@extends('public.layouts.app')

@section('title', 'Privacy Policy - ' . config('app.name'))

@section('content')
<section class="min-h-screen pt-16 py-20">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <div class="prose dark:prose-invert max-w-none">
                <h1>Privacy Policy</h1>
                <p>Last updated: {{ date('F d, Y') }}</p>

                <p>This is the default privacy policy page. You can update this content from the admin panel in Pages.</p>
            </div>
        </div>
    </div>
</section>
@endsection
