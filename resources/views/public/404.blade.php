@extends('public.layouts.app')

@section('title', '404 - Page Not Found')
@section('meta_description', 'The page you are looking for does not exist.')

@section('content')
<section class="min-h-screen flex items-center justify-center bg-slate-50 dark:bg-slate-950 pt-28 sm:pt-36 pb-20">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-md mx-auto text-center">
            <div class="w-24 h-24 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-8">
                <span class="text-4xl font-bold text-gray-400 dark:text-gray-500">404</span>
            </div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Page Not Found</h1>
            <p class="text-gray-600 dark:text-gray-400 mb-8">
                The page you are looking for doesn't exist or has been moved.
            </p>
            <a href="{{ route('home') }}"
                class="inline-flex items-center gap-2 bg-primary hover:bg-primary-dark text-white px-6 py-3 rounded-lg font-medium transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2v8a2 2 0 002 2h6m-4-10l4-4 4 4m-4-4v10"></path>
                </svg>
                Back to Home
            </a>
        </div>
    </div>
</section>
@endsection
