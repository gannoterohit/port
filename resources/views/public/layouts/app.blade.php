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
        :root {
            --primary-color: {{ isset($primaryColor) && $primaryColor ? $primaryColor : '#10B981' }};
            --primary-hover-color: #059669;
            --secondary-color: {{ isset($secondaryColor) && $secondaryColor ? $secondaryColor : '#0F172A' }};
            --light-green: rgba(16, 185, 129, 0.15);
            --main-bg: #080C14;
            --alt-bg: #0D131F;
            --primary-text: #F8FAFC;
            --secondary-text: #94A3B8;
            --border-color: #1E293B;
            --footer-bg: #05080E;
            --footer-text: #F8FAFC;
        }
    </style>
</head>
<body class="bg-[#080C14] text-slate-100 font-sans antialiased selection:bg-emerald-500/20 selection:text-emerald-400 min-h-screen flex flex-col">
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
