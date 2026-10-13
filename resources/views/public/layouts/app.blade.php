<!DOCTYPE html>
<html lang="en" class="scroll-smooth" data-theme="{{ $themePreset ?? 'indigo_dark' }}">
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

    @if($profile)
    <script type="application/ld+json">
    {!! json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'Person',
        'name' => $profile->full_name,
        'jobTitle' => $profile->title,
        'description' => strip_tags($profile->intro ?: ($profile->biography ?? '')),
        'url' => url('/'),
        'email' => $profile->contact_email,
        'telephone' => $profile->contact_phone,
        'image' => $profile->profile_photo_url,
        'address' => $profile->location_visible && $profile->location ? [
            '@type' => 'PostalAddress',
            'addressLocality' => $profile->location,
        ] : null,
        'sameAs' => array_values(array_filter($profile->social_links ?? [])),
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
    </script>
    @endif

    <style>
        /* ========================================================
           COMPREHENSIVE MULTI-THEME ENGINE (ADMIN DRIVEN)
           ======================================================== */
        :root,
        [data-theme="indigo_dark"] {
            --theme-mode: dark;
            --theme-bg-main: #0B0F19;
            --theme-bg-alt: #0F172A;
            --theme-bg-card: #1E293B;
            --theme-bg-card-hover: #26354D;
            --theme-border: #334155;
            --theme-border-subtle: rgba(51, 65, 85, 0.7);
            --theme-text-primary: #F8FAFC;
            --theme-text-secondary: #94A3B8;
            --theme-text-muted: #64748B;
            --theme-brand: #6366F1;
            --theme-brand-hover: #4F46E5;
            --theme-brand-accent: #38BDF8;
            --theme-brand-glow: rgba(99, 102, 241, 0.22);
            --theme-badge-bg: rgba(99, 102, 241, 0.15);
            --theme-badge-border: rgba(99, 102, 241, 0.35);
            --theme-badge-text: #A5B4FC;
            --theme-nav-bg: rgba(11, 15, 25, 0.88);
            --theme-footer-bg: #070A12;
            --theme-selection-bg: rgba(99, 102, 241, 0.25);
            --theme-selection-text: #A5B4FC;
        }

        [data-theme="apple_light"] {
            --theme-mode: light;
            --theme-bg-main: #F8FAFC;
            --theme-bg-alt: #F1F5F9;
            --theme-bg-card: #FFFFFF;
            --theme-bg-card-hover: #F8FAFC;
            --theme-border: #E2E8F0;
            --theme-border-subtle: rgba(226, 232, 240, 0.9);
            --theme-text-primary: #0F172A;
            --theme-text-secondary: #475569;
            --theme-text-muted: #64748B;
            --theme-brand: #2563EB;
            --theme-brand-hover: #1D4ED8;
            --theme-brand-accent: #0284C7;
            --theme-brand-glow: rgba(37, 99, 235, 0.15);
            --theme-badge-bg: rgba(37, 99, 235, 0.08);
            --theme-badge-border: rgba(37, 99, 235, 0.25);
            --theme-badge-text: #1D4ED8;
            --theme-nav-bg: rgba(255, 255, 255, 0.94);
            --theme-footer-bg: #F1F5F9;
            --theme-selection-bg: rgba(37, 99, 235, 0.15);
            --theme-selection-text: #1D4ED8;
        }

        [data-theme="navy_cyan"] {
            --theme-mode: dark;
            --theme-bg-main: #0A1128;
            --theme-bg-alt: #0F1A34;
            --theme-bg-card: #111E38;
            --theme-bg-card-hover: #16284D;
            --theme-border: #1E2E4F;
            --theme-border-subtle: rgba(30, 46, 79, 0.7);
            --theme-text-primary: #F1F5F9;
            --theme-text-secondary: #94A3B8;
            --theme-text-muted: #64748B;
            --theme-brand: #06B6D4;
            --theme-brand-hover: #0891B2;
            --theme-brand-accent: #8B5CF6;
            --theme-brand-glow: rgba(6, 182, 212, 0.25);
            --theme-badge-bg: rgba(6, 182, 212, 0.15);
            --theme-badge-border: rgba(6, 182, 212, 0.35);
            --theme-badge-text: #22D3EE;
            --theme-nav-bg: rgba(10, 17, 40, 0.9);
            --theme-footer-bg: #060B1A;
            --theme-selection-bg: rgba(6, 182, 212, 0.25);
            --theme-selection-text: #22D3EE;
        }

        [data-theme="titanium_amber"] {
            --theme-mode: dark;
            --theme-bg-main: #12141A;
            --theme-bg-alt: #181C24;
            --theme-bg-card: #1E222B;
            --theme-bg-card-hover: #262C38;
            --theme-border: #2A313E;
            --theme-border-subtle: rgba(42, 49, 62, 0.7);
            --theme-text-primary: #F3F4F6;
            --theme-text-secondary: #9CA3AF;
            --theme-text-muted: #6B7280;
            --theme-brand: #F59E0B;
            --theme-brand-hover: #D97706;
            --theme-brand-accent: #FB923C;
            --theme-brand-glow: rgba(245, 158, 11, 0.22);
            --theme-badge-bg: rgba(245, 158, 11, 0.15);
            --theme-badge-border: rgba(245, 158, 11, 0.35);
            --theme-badge-text: #FBBF24;
            --theme-nav-bg: rgba(18, 20, 26, 0.9);
            --theme-footer-bg: #0C0E12;
            --theme-selection-bg: rgba(245, 158, 11, 0.25);
            --theme-selection-text: #FBBF24;
        }

        [data-theme="emerald_dark"] {
            --theme-mode: dark;
            --theme-bg-main: #080C14;
            --theme-bg-alt: #0D131F;
            --theme-bg-card: #0F172A;
            --theme-bg-card-hover: #152035;
            --theme-border: #1E293B;
            --theme-border-subtle: rgba(30, 41, 59, 0.7);
            --theme-text-primary: #F8FAFC;
            --theme-text-secondary: #94A3B8;
            --theme-text-muted: #64748B;
            --theme-brand: #10B981;
            --theme-brand-hover: #059669;
            --theme-brand-accent: #14B8A6;
            --theme-brand-glow: rgba(16, 185, 129, 0.22);
            --theme-badge-bg: rgba(16, 185, 129, 0.15);
            --theme-badge-border: rgba(16, 185, 129, 0.35);
            --theme-badge-text: #34D399;
            --theme-nav-bg: rgba(8, 12, 20, 0.88);
            --theme-footer-bg: #05080E;
            --theme-selection-bg: rgba(16, 185, 129, 0.25);
            --theme-selection-text: #34D399;
        }

        /* Dynamic Theme Element Mapping */
        [data-theme] body,
        [data-theme] .bg-\[\#080C14\] {
            background-color: var(--theme-bg-main) !important;
        }

        [data-theme] .bg-\[\#0D131F\],
        [data-theme] .bg-\[\#0B1220\],
        [data-theme] .bg-\[\#0B101D\],
        [data-theme] .bg-slate-900\/60,
        [data-theme] .bg-slate-900\/70,
        [data-theme] .bg-slate-900\/80,
        [data-theme] .bg-slate-900\/90 {
            background-color: var(--theme-bg-alt) !important;
        }

        [data-theme] .bg-\[\#0F172A\],
        [data-theme] .bg-slate-900 {
            background-color: var(--theme-bg-card) !important;
        }

        [data-theme] .bg-\[\#05080E\] {
            background-color: var(--theme-footer-bg) !important;
        }

        [data-theme] header {
            background-color: var(--theme-nav-bg) !important;
        }

        [data-theme] .border-slate-800,
        [data-theme] .border-slate-800\/80,
        [data-theme] .border-slate-700,
        [data-theme] .border-slate-700\/50,
        [data-theme] .border-slate-700\/80 {
            border-color: var(--theme-border) !important;
        }

        /* Buttons & Brand Gradients */
        [data-theme] .btn-shimmer-effect,
        [data-theme] .bg-gradient-to-r.from-emerald-600.to-teal-500,
        [data-theme] a.bg-gradient-to-r.from-emerald-600,
        [data-theme] button.bg-gradient-to-r.from-emerald-600 {
            background-image: linear-gradient(135deg, var(--theme-brand), var(--theme-brand-accent)) !important;
            border-color: transparent !important;
        }

        [data-theme] .text-emerald-400,
        [data-theme] .text-emerald-500 {
            color: var(--theme-brand) !important;
        }

        [data-theme] .bg-emerald-500\/10 {
            background-color: var(--theme-badge-bg) !important;
        }

        [data-theme] .border-emerald-500\/25,
        [data-theme] .border-emerald-500\/30 {
            border-color: var(--theme-badge-border) !important;
        }

        [data-theme] .bg-emerald-500 {
            background-color: var(--theme-brand) !important;
        }

        [data-theme] .bg-emerald-500\/15,
        [data-theme] .bg-emerald-500\/20,
        [data-theme] .bg-teal-500\/10,
        [data-theme] .bg-cyan-500\/10 {
            background-color: var(--theme-brand-glow) !important;
        }

        [data-theme] .bg-gradient-to-r.from-emerald-400.via-teal-300.to-cyan-400,
        [data-theme] .gradient-text {
            background-image: linear-gradient(135deg, var(--theme-brand), var(--theme-brand-accent)) !important;
        }

        [data-theme] .hover\:border-emerald-500\/50:hover,
        [data-theme] .hover\:border-emerald-500\/60:hover {
            border-color: var(--theme-brand) !important;
        }

        [data-theme] .group-hover\:text-emerald-400:hover,
        [data-theme] .group:hover .group-hover\:text-emerald-400,
        [data-theme] .hover\:text-emerald-400:hover {
            color: var(--theme-brand) !important;
        }

        [data-theme] ::selection {
            background-color: var(--theme-selection-bg) !important;
            color: var(--theme-selection-text) !important;
        }

        /* Light Theme Custom Adaptations */
        [data-theme="apple_light"] body {
            color: #0F172A !important;
        }
        [data-theme="apple_light"] h1,
        [data-theme="apple_light"] h2,
        [data-theme="apple_light"] h3,
        [data-theme="apple_light"] h4,
        [data-theme="apple_light"] .text-white {
            color: #0F172A !important;
        }
        [data-theme="apple_light"] .text-slate-100 {
            color: #0F172A !important;
        }
        [data-theme="apple_light"] .text-slate-200 {
            color: #1E293B !important;
        }
        [data-theme="apple_light"] .text-slate-300 {
            color: #475569 !important;
        }
        [data-theme="apple_light"] .text-slate-400 {
            color: #64748B !important;
        }
        [data-theme="apple_light"] header {
            background-color: rgba(255, 255, 255, 0.94) !important;
            border-bottom-color: #E2E8F0 !important;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05) !important;
        }
        [data-theme="apple_light"] .btn-shimmer-effect,
        [data-theme="apple_light"] a.btn-shimmer-effect,
        [data-theme="apple_light"] button.btn-shimmer-effect {
            color: #FFFFFF !important;
        }
        [data-theme="apple_light"] .bg-slate-900\/60,
        [data-theme="apple_light"] .bg-slate-900\/70,
        [data-theme="apple_light"] .bg-slate-900\/80,
        [data-theme="apple_light"] .bg-slate-900\/90,
        [data-theme="apple_light"] .bg-slate-900 {
            background-color: #FFFFFF !important;
            border-color: #E2E8F0 !important;
            box-shadow: 0 4px 15px -2px rgba(0, 0, 0, 0.05), 0 2px 6px -2px rgba(0, 0, 0, 0.03) !important;
        }
        [data-theme="apple_light"] footer {
            background-color: #F1F5F9 !important;
            border-top-color: #E2E8F0 !important;
        }
        [data-theme="apple_light"] footer .text-slate-300,
        [data-theme="apple_light"] footer .text-slate-400 {
            color: #64748B !important;
        }
        [data-theme="apple_light"] .bg-grid-dots-dark {
            background-image: radial-gradient(rgba(37, 99, 235, 0.12) 1.5px, transparent 1.5px) !important;
        }
        [data-theme="apple_light"] input.bg-slate-900,
        [data-theme="apple_light"] textarea.bg-slate-900,
        [data-theme="apple_light"] select.bg-slate-900 {
            background-color: #FFFFFF !important;
            color: #0F172A !important;
            border-color: #CBD5E1 !important;
        }
    </style>
</head>
<body class="font-sans antialiased selection:bg-indigo-500/20 selection:text-indigo-400 min-h-screen flex flex-col">
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

    @if($profile && $profile->whatsapp_url)
        <a href="{{ $profile->whatsapp_url }}"
            target="_blank"
            rel="noopener noreferrer"
            class="fixed bottom-5 right-5 z-40 inline-flex items-center gap-2 rounded-full bg-[#25D366] hover:bg-[#1ebe57] text-white pl-3.5 pr-5 py-3 shadow-lg hover:shadow-xl transition-all duration-200"
            aria-label="Chat on WhatsApp"
            title="Chat on WhatsApp">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.435 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
            </svg>
            <span class="text-sm font-semibold hidden sm:inline">WhatsApp</span>
        </a>
    @endif

    @stack('scripts')
</body>
</html>
