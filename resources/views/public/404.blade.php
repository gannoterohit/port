@extends('public.layouts.app')

@section('title', '404 - Page Not Found - ' . $websiteName)
@section('meta_description', 'The page you are looking for does not exist.')

@section('content')
<section class="min-h-0 sm:min-h-screen flex items-center justify-center bg-[var(--theme-bg-canvas)] text-[var(--theme-text-heading)] pt-24 sm:pt-36 pb-28 sm:pb-24 relative overflow-hidden transition-colors duration-200">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="max-w-md mx-auto text-center bg-[var(--theme-bg-card)] p-10 rounded-3xl border border-[var(--theme-border)] shadow-xs">
            <div class="w-20 h-20 bg-brand/10 border border-brand/20 rounded-2xl flex items-center justify-center mx-auto mb-6 text-brand font-bold text-2xl shadow-2xs">
                404
            </div>
            <h1 class="text-2xl font-bold text-[var(--theme-text-heading)] mb-3">Page Not Found</h1>
            <p class="text-[var(--theme-text-body)] text-sm mb-8 leading-relaxed">
                The page you are looking for does not exist, has been moved, or is temporarily unavailable.
            </p>
            <a href="{{ route('home') }}"
                class="theme-btn-primary inline-flex items-center gap-2 px-7 py-3.5 rounded-full text-xs sm:text-sm font-semibold transition-all shadow-sm hover:scale-[1.02]">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2v8a2 2 0 002 2h6m-4-10l4-4 4 4m-4-4v10"></path>
                </svg>
                <span>Back to Homepage</span>
            </a>
        </div>
    </div>
</section>
@endsection
