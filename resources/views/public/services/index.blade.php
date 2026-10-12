@extends('public.layouts.app')

@section('title', 'Services - ' . $websiteName)
@section('meta_description', 'Services I offer')

@section('content')
<section class="min-h-screen pt-16 py-20 bg-gray-50 dark:bg-gray-900">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-12">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-3">My Services</h1>
                <p class="text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                    I provide a range of services to help you build and grow your digital presence.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($services as $service)
                    <a href="{{ route('services.show', ['service' => $service->slug]) }}" class="group block">
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 h-full group-hover:shadow-xl transition-shadow">
                            @if($service->icon_url)
                                <img src="{{ $service->icon_url }}" alt="{{ $service->name }}" class="w-14 h-14 mb-4">
                            @else
                                <div class="w-14 h-14 bg-gray-100 dark:bg-gray-700 rounded-xl flex items-center justify-center mb-4">
                                    <svg class="w-7 h-7 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6l4 2"></path>
                                    </svg>
                                </div>
                            @endif
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">{{ $service->name }}</h3>
                            <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">
                                {{ $service->short_description ?? Str::limit(strip_tags($service->description), 120) }}
                            </p>
                            @if($service->price_formatted)
                                <div class="mt-auto">
                                    <span class="text-lg font-bold text-primary">{{ $service->price_formatted }}</span>
                                </div>
                            @endif
                        </div>
                    </a>
                @empty
                    <p class="col-span-full text-center text-gray-500 dark:text-gray-400">No services found.</p>
                @endforelse
            </div>

            @if($services->hasPages())
                <div class="mt-12">
                    {{ $services->links() }}
                </div>
            @endif
        </div>
    </div>
</section>
@endsection
