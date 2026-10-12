@extends('public.layouts.app')

@section('title', $service->name . ' - ' . $websiteName)
@section('meta_description', $service->short_description ?? Str::limit(strip_tags($service->description), 160))

@isset($service->og_image_url)
    <meta property="og:image" content="{{ $service->og_image_url }}">
@endisset

@section('content')
<section class="min-h-screen pt-16 py-20">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <a href="{{ route('services') }}" class="text-primary font-medium text-sm flex items-center gap-2 mb-6">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back to Services
            </a>

            <div class="flex items-center gap-6 mb-8">
                @if($service->icon_url)
                    <img src="{{ $service->icon_url }}" alt="{{ $service->name }}" class="w-20 h-20">
                @endif
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $service->name }}</h1>
                    @if($service->price_formatted)
                        <p class="text-2xl font-bold text-primary mt-2">{{ $service->price_formatted }}</p>
                    @endif
                </div>
            </div>

            @if($service->short_description)
                <p class="text-xl text-gray-600 dark:text-gray-400 mb-8">{{ $service->short_description }}</p>
            @endif

            @if($service->description)
                <div class="prose dark:prose-invert max-w-none mb-8">
                    {!! nl2br(e($service->description)) !!}
                </div>
            @endif

            @if($service->features && is_array($service->features))
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">What's Included</h3>
                    <ul class="space-y-2">
                        @foreach($service->features as $feature)
                            <li class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-gray-700 dark:text-gray-300">{{ $feature }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if($service->image_url)
                <img src="{{ $service->image_url }}" alt="{{ $service->name }}" class="w-full rounded-xl shadow-md mb-8">
            @endif

            <div class="pt-8 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ route('contact') }}"
                    class="inline-flex items-center gap-2 bg-primary hover:bg-primary-dark text-white px-6 py-3 rounded-lg font-medium">
                    Get a Quote for {{ $service->name }}
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
