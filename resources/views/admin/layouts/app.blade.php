<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - {{ \App\Models\Setting::get('website_name', 'Portfolio CMS') }}</title>
    @vite(['resources/css/admin.css', 'resources/js/admin.js'])
    @yield('head')
</head>
<body class="bg-gray-50 font-sans antialiased">
    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-transition class="fixed top-4 right-4 z-50 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg">
            {{ session('success') }}
            <button @click="show = false" class="ml-2 text-white hover:text-gray-200">&times;</button>
        </div>
    @endif

    @if(session('error'))
        <div x-data="{ show: true }" x-show="show" x-transition class="fixed top-4 right-4 z-50 bg-red-500 text-white px-4 py-2 rounded-lg shadow-lg">
            {{ session('error') }}
            <button @click="show = false" class="ml-2 text-white hover:text-gray-200">&times;</button>
        </div>
    @endif

    @yield('content')
</body>
</html>

