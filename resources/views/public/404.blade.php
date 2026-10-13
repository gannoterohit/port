@extends('public.layouts.app')

@section('title', '404 - Page Not Found - ' . $websiteName)
@section('meta_description', 'The page you are looking for does not exist.')

@section('content')
<section class="min-h-screen flex items-center justify-center bg-[#F5F7F2] pt-28 sm:pt-36 pb-24">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-md mx-auto text-center bg-white p-10 rounded-2xl border border-[#E5E7EB] shadow-xs">
            <div class="w-20 h-20 bg-[#DCE8D6] rounded-2xl flex items-center justify-center mx-auto mb-6 text-[#1B560B] font-bold text-2xl">
                404
            </div>
            <h1 class="text-2xl font-bold text-[#1F2937] mb-3">Page Not Found</h1>
            <p class="text-[#667085] text-sm mb-8 leading-relaxed">
                The page you are looking for does not exist, has been moved, or is temporarily unavailable.
            </p>
            <a href="{{ route('home') }}"
                class="inline-flex items-center gap-2 bg-[#1B560B] hover:bg-[#144208] text-white px-6 py-3 rounded-lg text-sm font-semibold transition-all shadow-xs">
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
