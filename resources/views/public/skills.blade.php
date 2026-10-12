@extends('public.layouts.app')

@section('title', 'Skills - ' . $websiteName)
@section('meta_description', 'My technical skills and expertise')

@isset($profile->og_image_url)
    <meta property="og:image" content="{{ $profile->og_image_url }}">
@endisset

@section('content')
<section class="min-h-screen pt-16 py-20">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-12">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-3">My Skills</h1>
                <p class="text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                    Technical expertise I bring to every project
                </p>
            </div>

            <div class="space-y-12">
                @foreach($categories as $category)
                    @if($category->skills->isNotEmpty())
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6">
                            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4" style="color: {{ $category->color }}">
                                {{ $category->name }}
                            </h2>
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                                @foreach($category->skills as $skill)
                                    <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                        <span class="text-gray-700 dark:text-gray-300 font-medium">{{ $skill->name }}</span>
                                        <div class="flex items-center gap-2">
                                            <span class="text-xs text-gray-500 dark:text-gray-400">{{ $skill->proficiency }}%</span>
                                            <div class="w-12 h-2 bg-gray-200 dark:bg-gray-600 rounded-full overflow-hidden">
                                                <div class="h-full bg-primary" style="width: {{ $skill->proficiency }}%"></div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</section>
@endsection
