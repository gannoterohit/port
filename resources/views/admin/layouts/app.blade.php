<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - {{ \App\Models\Setting::get('website_name', 'Portfolio CMS') }}</title>
    @vite(['resources/css/admin.css', 'resources/js/admin.js'])
    @yield('head')
</head>
<body class="bg-[#F6F8F7] font-sans antialiased text-[#1F2937]">
    @if(session('success'))
        <div x-cloak x-data="{ show: true }" x-show="show" x-transition role="status" class="fixed right-4 top-4 z-[60] flex max-w-sm items-start gap-3 rounded-2xl border border-emerald-200 bg-white px-4 py-3 text-sm font-medium text-emerald-900 shadow-xl">
            {{ session('success') }}
            <button @click="show = false" class="ml-auto text-lg leading-none text-emerald-700 hover:text-emerald-900" aria-label="Dismiss notification">&times;</button>
        </div>
    @endif

    @if(session('error'))
        <div x-cloak x-data="{ show: true }" x-show="show" x-transition role="alert" class="fixed right-4 top-4 z-[60] flex max-w-sm items-start gap-3 rounded-2xl border border-red-200 bg-white px-4 py-3 text-sm font-medium text-red-900 shadow-xl">
            {{ session('error') }}
            <button @click="show = false" class="ml-auto text-lg leading-none text-red-700 hover:text-red-900" aria-label="Dismiss notification">&times;</button>
        </div>
    @endif

    @yield('content')
</body>
</html>
