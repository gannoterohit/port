@extends('public.layouts.app')

@section('title', '404 - Page Not Found - ' . $websiteName)
@section('meta_description', 'The page you are looking for does not exist.')

@section('content')
<section class="min-h-screen flex items-center justify-center bg-[#080C14] text-slate-100 pt-28 sm:pt-36 pb-24 relative overflow-hidden">
    <div class="absolute inset-0 bg-grid-dots-dark opacity-35 pointer-events-none"></div>
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="max-w-md mx-auto text-center bg-[#0F172A]/90 p-10 rounded-2xl border border-slate-800 shadow-2xl">
            <div class="w-20 h-20 bg-emerald-500/15 border border-emerald-500/30 rounded-2xl flex items-center justify-center mx-auto mb-6 text-emerald-400 font-bold text-2xl shadow-md">
                404
            </div>
            <h1 class="text-2xl font-bold text-white mb-3">Page Not Found</h1>
            <p class="text-slate-400 text-sm mb-8 leading-relaxed">
                The page you are looking for does not exist, has been moved, or is temporarily unavailable.
            </p>
            <a href="{{ route('home') }}"
                class="btn-shimmer-effect inline-flex items-center gap-2 bg-gradient-to-r from-emerald-600 to-teal-500 hover:from-emerald-500 hover:to-teal-400 text-white px-6 py-3 rounded-xl text-sm font-semibold transition-all shadow-lg shadow-emerald-500/25">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2v8a2 2 0 002 2h6m-4-10l4-4 4 4m-4-4v10"></path>
                </svg>
                Back to Homepage
            </a>
        </div>
    </div>
</section>
@endsection
