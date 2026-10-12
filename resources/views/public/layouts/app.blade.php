<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', $defaultSeoTitle ?? ($websiteName . ' - ' . $siteDescription))</title>
    <meta name="description" content="@yield('meta_description', $defaultSeoDescription ?? $siteDescription)">
    <meta name="robots" content="@yield('meta_robots', 'index, follow')">
    <link rel="canonical" href="@yield('canonical', url()->current())">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('og_title', View::yieldContent('title', $defaultSeoTitle ?? ($websiteName . ' - ' . $siteDescription)))">
    <meta property="og:description" content="@yield('og_description', View::yieldContent('meta_description', $defaultSeoDescription ?? $siteDescription))">
    @php
        $ogImgYield = View::yieldContent('og_image');
    @endphp
    @if($ogImgYield)
        <meta property="og:image" content="{{ $ogImgYield }}">
    @elseif(!empty($defaultOgImage))
        <meta property="og:image" content="{{ asset('storage/' . $defaultOgImage) }}">
    @elseif(!empty($profile->profile_photo_url))
        <meta property="og:image" content="{{ $profile->profile_photo_url }}">
    @endif

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ url()->current() }}">
    <meta name="twitter:title" content="@yield('og_title', View::yieldContent('title', $defaultSeoTitle ?? ($websiteName . ' - ' . $siteDescription)))">
    <meta name="twitter:description" content="@yield('og_description', View::yieldContent('meta_description', $defaultSeoDescription ?? $siteDescription))">
    @if($ogImgYield)
        <meta name="twitter:image" content="{{ $ogImgYield }}">
    @elseif(!empty($defaultOgImage))
        <meta name="twitter:image" content="{{ asset('storage/' . $defaultOgImage) }}">
    @elseif(!empty($profile->profile_photo_url))
        <meta name="twitter:image" content="{{ $profile->profile_photo_url }}">
    @endif

    @stack('meta')

    @if($favicon)
        <link rel="icon" href="{{ asset('storage/' . $favicon) }}">
    @else
        <link rel="icon" href="{{ asset('favicon.ico') }}">
    @endif

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
    <script>
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
    <style>
        :root {
            --primary-color: {{ isset($primaryColor) && $primaryColor ? $primaryColor : '#2563eb' }};
            --secondary-color: {{ isset($secondaryColor) && $secondaryColor ? $secondaryColor : '#0f172a' }};
        }
    </style>
</head>
<body class="bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100 font-sans antialiased selection:bg-blue-600 selection:text-white min-h-screen flex flex-col">
    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-transition
            class="fixed top-4 right-4 z-50 bg-emerald-500 text-white px-4 py-3 rounded-lg shadow-lg animate-slide-down">
            {{ session('success') }}
            <button @click="show = false" class="ml-2 text-white hover:text-slate-200">&times;</button>
        </div>
    @endif

    @if(session('error'))
        <div x-data="{ show: true }" x-show="show" x-transition
            class="fixed top-4 right-4 z-50 bg-red-500 text-white px-4 py-3 rounded-lg shadow-lg animate-slide-down">
            {{ session('error') }}
            <button @click="show = false" class="ml-2 text-white hover:text-slate-200">&times;</button>
        </div>
    @endif

    @include('public.partials.header')

    <main class="flex-1 w-full">
        @yield('content')
    </main>

    @include('public.partials.footer')

    @stack('scripts')
</body>
</html>