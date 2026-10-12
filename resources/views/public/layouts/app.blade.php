<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', $websiteName . ' - ' . $siteDescription)</title>
    <meta name="description" content="@yield('meta_description', $siteDescription)">
    @if($favicon)
        <link rel="icon" href="{{ asset('storage/' . $favicon) }}">
    @else
        <link rel="icon" href="{{ asset('favicon.ico') }}">
    @endif

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
    <style>
        :root {
            --primary-color: {{ isset($primaryColor) ? $primaryColor : '#2563eb' }};
            --secondary-color: {{ isset($secondaryColor) ? $secondaryColor : '#0f172a' }};
        }
    </style>
</head>
<body class="bg-white dark:bg-slate-950 text-slate-900 dark:text-slate-100 font-sans antialiased">
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

    @yield('content')

    @include('public.partials.footer')

    @stack('scripts')
</body>
</html>