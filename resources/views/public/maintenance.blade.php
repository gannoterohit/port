@extends('public.layouts.app')

@section('title', 'Site Under Maintenance')
@section('meta_description', 'Scheduled maintenance')

@section('content')
<section class="min-h-screen flex items-center justify-center bg-gray-100 dark:bg-gray-900 pt-16">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-lg mx-auto text-center">
            <div class="w-24 h-24 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-8">
                <svg class="w-12 h-12 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10.325 4.38L11 7h6l.675-2.62A2 2 0 0016.36 1H7.64a2 2 0 00-1.675 3.38zM11 7V2h.01M11 7v4m-8 5a9 9 0 1118 0 9 9 0 01-18 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">Under Maintenance</h1>
            <p class="text-gray-600 dark:text-gray-400 mb-6">
                We're working on something special. The site is currently undergoing scheduled maintenance.
            </p>
            <p class="text-gray-500 dark:text-gray-500 text-sm">
                Please check back soon for updates.
            </p>
        </div>
    </div>
</section>
@endsection

