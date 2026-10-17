@php
    $websiteName = \App\Models\Setting::get('website_name', 'Rohit Gannote');
    $contactEmail = \App\Models\Setting::get('contact_email', 'hello@rohitgannote.com');
@endphp
<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Under Maintenance — {{ $websiteName }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-[#F6F4EE] text-[#18191B] font-sans antialiased flex flex-col justify-between selection:bg-[#B85D19]/20 selection:text-[#B85D19]">

    <!-- Admin Notification Banner (Visible only to logged-in admin) -->
    @auth
        @if(Auth::user()->is_admin)
            <div class="fixed top-4 left-1/2 -translate-x-1/2 z-50 flex max-w-xl w-[92%] sm:w-auto items-center justify-between gap-3 sm:gap-4 rounded-full border border-amber-300 bg-amber-50/95 backdrop-blur px-4 py-2 text-xs font-semibold text-amber-900 shadow-lg">
                <div class="flex items-center gap-2">
                    <span class="h-2 w-2 rounded-full bg-amber-500 animate-ping"></span>
                    <span>Admin Mode: Maintenance is Active</span>
                </div>
                <div class="flex items-center gap-2.5">
                    <a href="{{ route('admin.maintenance.edit') }}" class="rounded-full bg-amber-200/70 px-2.5 py-1 text-[11px] font-bold text-amber-950 hover:bg-amber-200 transition">
                        Turn Off in Admin
                    </a>
                    <a href="{{ url('/?preview=1') }}" class="text-[11px] text-stone-600 underline font-semibold hover:text-stone-900">
                        Preview Live Site &rarr;
                    </a>
                </div>
            </div>
        @endif
    @endauth

    <!-- Top Brand -->
    <header class="p-6 sm:p-10 flex justify-center sm:justify-start">
        <a href="{{ url('/') }}" class="flex items-center gap-2.5 font-bold tracking-tight text-lg text-stone-900">
            <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-[#18191B] text-xs font-bold text-[#F6F4EE]">
                {{ substr($websiteName, 0, 1) }}
            </span>
            <span>{{ $websiteName }}</span>
        </a>
    </header>

    <!-- Main Content -->
    <main class="my-auto px-6 py-12 text-center max-w-xl mx-auto">
        <!-- Live Status Pill -->
        <div class="inline-flex items-center gap-2 rounded-full border border-amber-200 bg-amber-50 px-3.5 py-1.5 text-xs font-bold text-amber-800 shadow-xs mb-6">
            <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-amber-500"></span>
            </span>
            <span class="font-mono tracking-wider uppercase text-[11px]">Under Scheduled Maintenance</span>
        </div>

        <!-- Big Headline -->
        <h1 class="text-3xl sm:text-5xl font-extrabold tracking-tight text-stone-900 leading-[1.15]">
            Upgrading systems &amp; deploying updates.
        </h1>

        <!-- Subtitle -->
        <p class="mt-4 text-sm sm:text-base text-stone-600 leading-relaxed max-w-md mx-auto">
            We are performing essential architectural improvements and content updates. The website will be fully restored shortly.
        </p>

        <!-- Actions -->
        <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-3">
            @if($contactEmail)
                <a href="mailto:{{ $contactEmail }}" class="inline-flex w-full sm:w-auto items-center justify-center gap-2 rounded-xl bg-[#18191B] px-5 py-3 text-sm font-semibold text-[#F6F4EE] shadow-sm hover:bg-[#2A2B2E] transition">
                    <svg class="w-4 h-4 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 01-2-2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span>Contact Directly</span>
                </a>
            @endif

            <a href="{{ route('admin.login') }}" class="inline-flex w-full sm:w-auto items-center justify-center gap-2 rounded-xl border border-[#E5E1D5] bg-white px-5 py-3 text-sm font-semibold text-stone-700 shadow-xs hover:bg-stone-50 transition">
                <svg class="w-4 h-4 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
                <span>Admin Login</span>
            </a>
        </div>
    </main>

    <!-- Footer -->
    <footer class="p-6 text-center text-xs text-stone-400">
        <p>&copy; {{ date('Y') }} {{ $websiteName }}. All rights reserved.</p>
    </footer>

</body>
</html>
