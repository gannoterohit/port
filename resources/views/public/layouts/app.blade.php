<!DOCTYPE html>
<html lang="en" class="scroll-smooth" data-theme="warm_stone">
<head>
    <meta charset="UTF-8">
    <script>
        (function() {
            var saved = localStorage.getItem('portfolio_theme');
            if (saved === 'warm_obsidian' || saved === 'warm_stone') {
                document.documentElement.setAttribute('data-theme', saved);
            } else {
                var prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
                document.documentElement.setAttribute('data-theme', prefersDark ? 'warm_obsidian' : 'warm_stone');
            }
        })();
    </script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @php
        $pageTitle = $__env->yieldContent('title') ?: ($defaultSeoTitle ?? ($websiteName . ' - ' . $siteDescription));
        $pageDescription = $__env->yieldContent('meta_description') ?: ($defaultSeoDescription ?? $siteDescription);
        $pageOgTitle = $__env->yieldContent('og_title') ?: $pageTitle;
        $pageOgDescription = $__env->yieldContent('og_description') ?: $pageDescription;
        $pageOgImage = $__env->yieldContent('og_image')
            ?: (!empty($defaultOgImage) ? asset('storage/' . $defaultOgImage) : (!empty($profile->profile_photo_url) ? $profile->profile_photo_url : null));
    @endphp
    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ $pageDescription }}">
    <meta name="robots" content="@yield('meta_robots', 'index, follow')">
    <link rel="canonical" href="@yield('canonical', url()->current())">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $pageOgTitle }}">
    <meta property="og:description" content="{{ $pageOgDescription }}">
    @if($pageOgImage)
        <meta property="og:image" content="{{ $pageOgImage }}">
    @endif

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ url()->current() }}">
    <meta name="twitter:title" content="{{ $pageOgTitle }}">
    <meta name="twitter:description" content="{{ $pageOgDescription }}">
    @if($pageOgImage)
        <meta name="twitter:image" content="{{ $pageOgImage }}">
    @endif

    @stack('meta')

    @if($favicon)
        <link rel="icon" href="{{ asset('storage/' . $favicon) }}">
    @else
        <link rel="icon" href="{{ asset('favicon.ico') }}">
    @endif

    <!-- Google Fonts Optimized (Zero CLS, Zero Render-Blocking) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=optional" media="print" onload="this.media='all'">
    <noscript>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=optional">
    </noscript>

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

<body class="font-sans antialiased min-h-screen flex flex-col">
    <!-- Awwwards-Style Magnetic Dot & Lag Ring Custom Cursor -->
    <div id="cursor-dot" class="custom-cursor-dot" aria-hidden="true"></div>
    <div id="cursor-ring" class="custom-cursor-ring" aria-hidden="true"></div>

    <!-- Top Scroll Dynamic Progress Bar -->
    <div id="scroll-progress-bar" class="fixed top-0 left-0 h-[2.5px] bg-[#B85D19] dark:bg-[#E07A5F] z-[9999] pointer-events-none transition-all duration-75 ease-out" style="width: 0%"></div>

    <!-- Interactive Copy Email Toast Notification -->
    <div x-data="{ show: false, email: '' }"
        @copy-email-toast.window="email = $event.detail.email; show = true; setTimeout(() => show = false, 3200)"
        x-show="show"
        x-cloak
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-6 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-6 scale-95"
        class="fixed bottom-8 left-1/2 -translate-x-1/2 z-[99990] bg-[var(--theme-bg-card)] text-[var(--theme-text-heading)] border border-[var(--theme-border)] px-5 py-3 rounded-full shadow-2xl flex items-center gap-3 text-xs sm:text-sm font-semibold backdrop-blur-xl">
        <span class="w-6 h-6 rounded-full bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 flex items-center justify-center font-bold text-xs shrink-0">✓</span>
        <span>Email Copied: <span class="font-mono text-brand" x-text="email"></span></span>
    </div>

    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-transition
            class="fixed top-4 right-4 z-50 bg-[#18191B] text-[#F6F4EE] dark:bg-[#F4F3EF] dark:text-[#121316] px-4 py-3 rounded-xl shadow-xl animate-slide-down text-sm font-semibold border border-black/10 dark:border-white/10">
            {{ session('success') }}
            <button @click="show = false" class="ml-2 opacity-70 hover:opacity-100">&times;</button>
        </div>
    @endif

    @if(session('error'))
        <div x-data="{ show: true }" x-show="show" x-transition
            class="fixed top-4 right-4 z-50 bg-red-600 text-white px-4 py-3 rounded-xl shadow-xl animate-slide-down text-sm font-semibold">
            {{ session('error') }}
            <button @click="show = false" class="ml-2 text-white hover:opacity-80">&times;</button>
        </div>
    @endif

    <!-- 1-Click Copy Email Global Toast Notification -->
    <div x-data="{
        open: false,
        email: '',
        timer: null,
        show(emailText) {
            this.email = emailText;
            this.open = true;
            clearTimeout(this.timer);
            this.timer = setTimeout(() => { this.open = false; }, 4500);
        },
        openGmail() {
            window.open('https://mail.google.com/mail/?view=cm&fs=1&to=' + encodeURIComponent(this.email), '_blank');
            this.open = false;
        }
    }"
    @copy-email-toast.window="show($event.detail.email)"
    x-show="open"
    x-cloak
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:translate-x-4 scale-95"
    x-transition:enter-end="opacity-100 translate-y-0 sm:translate-x-0 scale-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 scale-100"
    x-transition:leave-end="opacity-0 scale-95"
    class="fixed bottom-24 right-4 sm:top-5 sm:bottom-auto sm:right-6 z-[9999] max-w-sm w-[calc(100%-2rem)] bg-[#1A1B20] text-[#F4F3EF] border border-[#E07A5F]/40 backdrop-blur-xl p-4 rounded-2xl shadow-2xl shadow-black/80"
    style="display: none;">
        <div class="flex items-start gap-3">
            <div class="w-8 h-8 rounded-xl bg-[#E07A5F]/15 text-[#E07A5F] border border-[#E07A5F]/30 flex items-center justify-center shrink-0 mt-0.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <div class="flex-1 min-w-0">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-white">Copied to Clipboard!</span>
                    <button type="button" @click="open = false" class="text-slate-400 hover:text-white p-0.5 text-base font-bold leading-none">&times;</button>
                </div>
                <div class="text-[12px] text-[#E07A5F] font-mono truncate mt-0.5" x-text="email"></div>
                <div class="mt-2.5 flex items-center gap-2">
                    <button type="button" @click="openGmail()" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-[#E07A5F] hover:opacity-90 text-white font-bold text-xs shadow-sm transition-opacity">
                        <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="currentColor"><path d="M24 5.457v13.909c0 .904-.732 1.636-1.636 1.636h-3.819V11.73L12 16.64l-6.545-4.91v9.273H1.636A1.636 1.636 0 0 1 0 19.366V5.457c0-2.023 2.309-3.178 3.927-1.964L5.455 4.64 12 9.548l6.545-4.91 1.528-1.145C21.69 2.28 24 3.434 24 5.457z"/></svg>
                        <span>Open in Gmail</span>
                    </button>
                    <button type="button" @click="open = false" class="px-2.5 py-1.5 rounded-lg bg-white/10 hover:bg-white/15 text-slate-300 text-xs font-semibold transition-colors">
                        Dismiss
                    </button>
                </div>
            </div>
        </div>
    </div>

    @include('public.partials.header')

    <main class="flex-1 w-full">
        @yield('content')
    </main>

    @include('public.partials.footer')

    @php
        $whatsappLink = ($profile && $profile->whatsapp_url)
            ?: (\App\Models\Setting::get('social_whatsapp')
                ?: (\App\Models\Setting::get('contact_whatsapp') ? 'https://wa.me/' . preg_replace('/\D+/', '', \App\Models\Setting::get('contact_whatsapp')) : null));
    @endphp

    @if($whatsappLink)
        <a href="{{ $whatsappLink }}"
            target="_blank"
            rel="noopener noreferrer"
            class="hidden sm:inline-flex fixed bottom-6 right-6 z-40 group items-center gap-2.5 rounded-full bg-[#25D366] hover:bg-[#1ebe57] text-white pl-4 pr-5 py-3 shadow-xl hover:shadow-2xl hover:scale-105 transition-all duration-200 border border-white/20"
            aria-label="Chat on WhatsApp"
            title="Chat on WhatsApp (Usually replies fast)">
            <span class="relative flex h-2.5 w-2.5">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-white"></span>
            </span>
            <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.435 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
            </svg>
            <span class="text-sm font-bold">Quick Chat</span>
        </a>
    @endif

    <!-- Smooth Back to Top Floating Button -->
    <button type="button"
        x-data="{ show: false }"
        @scroll.window="show = (window.pageYOffset > 400)"
        x-show="show"
        x-cloak
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-3"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-3"
        @click="window.scrollTo({top: 0, behavior: 'smooth'})"
        aria-label="Back to top"
        class="fixed bottom-20 sm:bottom-6 sm:right-48 right-6 z-40 p-3 rounded-full bg-white dark:bg-[#1A1B20] border border-black/10 dark:border-white/10 hover:border-[#B85D19]/50 text-slate-700 dark:text-slate-300 hover:text-[#B85D19] dark:hover:text-[#E07A5F] shadow-xl backdrop-blur-md transition-all duration-200 hover:-translate-y-1"
        title="Scroll to top">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
    </button>

    @php
        $mobileDirectEmail = null;
        if (!empty($profile)) {
            $mobileDirectEmail = $profile->contact_email ?: ($profile->email ?: null);
        }
        if (!$mobileDirectEmail) {
            $mobileDirectEmail = \App\Models\Setting::get('contact_email', 'rohitgannote@gmail.com');
        }

        $mobileWaRaw = null;
        if (!empty($profile)) {
            $mobileWaRaw = $profile->contact_whatsapp ?: ($profile->contact_phone ?: null);
        }
        if (!$mobileWaRaw) {
            $mobileWaRaw = \App\Models\Setting::get('contact_whatsapp')
                ?: (\App\Models\Setting::get('social_whatsapp')
                    ?: \App\Models\Setting::get('contact_phone'));
        }

        if ($mobileWaRaw) {
            $mobileWaDigits = preg_replace('/\D+/', '', $mobileWaRaw);
            $mobileWhatsappUrl = 'https://wa.me/' . $mobileWaDigits;
        } else {
            $mobileWhatsappUrl = 'https://wa.me/?text=' . urlencode('Hello Rohit, I saw your portfolio and would like to discuss a project.');
        }

        $mobileEmailSubject = rawurlencode('Project Inquiry - Backend Development');
        $mobileGmailUrl = 'https://mail.google.com/mail/?view=cm&fs=1&to=' . rawurlencode($mobileDirectEmail) . '&su=' . $mobileEmailSubject;
        $mobileMailtoUrl = 'mailto:' . $mobileDirectEmail . '?subject=' . $mobileEmailSubject;
    @endphp

    <!-- Mobile Floating Bottom Quick Action Dock (Strict 2-Tab: WhatsApp & Email Redirect) -->
    <div class="sm:hidden fixed bottom-3 inset-x-3 z-40">
        <div class="bg-[var(--theme-bg-card)]/95 backdrop-blur-2xl border border-[var(--theme-border)] rounded-2xl p-2 shadow-2xl shadow-black/20 grid grid-cols-2 gap-2">
            <!-- 1. WhatsApp Redirect -->
            <a href="{{ $mobileWhatsappUrl }}" target="_blank" rel="noopener noreferrer"
                class="flex items-center justify-center gap-2 py-3 px-3 rounded-xl bg-emerald-500/10 hover:bg-emerald-500/20 active:scale-[0.98] border border-emerald-500/20 text-emerald-600 dark:text-emerald-400 font-semibold text-xs transition-all shadow-2xs">
                <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.435 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                </svg>
                <span>WhatsApp</span>
            </a>

            <!-- 2. Email Redirect -->
            <a href="{{ $mobileGmailUrl }}"
                data-mailto="{{ $mobileMailtoUrl }}"
                onclick="window.handleSendEmail(this, '{{ $mobileDirectEmail }}', event)"
                target="_blank"
                rel="noopener noreferrer"
                class="flex items-center justify-center gap-2 py-3 px-3 rounded-xl bg-brand/10 hover:bg-brand/20 active:scale-[0.98] border border-brand/25 text-brand font-semibold text-xs transition-all shadow-2xs">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 01-2-2v12a2 2 0 002 2z"/>
                </svg>
                <span>Send Email</span>
            </a>
        </div>
    </div>

    <script>
        window.handleSendEmail = function(el, email, event) {
            // Optional copy to clipboard for convenience
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(email).catch(function() {});
            }

            // Detect if this is an actual mobile handheld device (not desktop)
            var isHandheld = /Android|iPhone|iPad|iPod/i.test(navigator.userAgent) && !/Win|Windows/i.test(navigator.platform || navigator.userAgent);

            if (isHandheld) {
                // On real mobile phones, trigger native mailto to launch installed Mail / Gmail app
                var mailtoUrl = el ? el.getAttribute('data-mailto') : ('mailto:' + email);
                if (event && event.preventDefault) event.preventDefault();
                window.location.href = mailtoUrl;
            } else {
                // On desktop, PC, or browser testing: let the standard <a href="https://mail.google.com/..." target="_blank"> work natively!
                // No preventDefault needed - native browser link click handles opening Gmail compose in new tab seamlessly!
            }
        };

        window.copyPortfolioEmail = function(email, event) {
            if (event && event.preventDefault) event.preventDefault();
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(email).catch(function() {});
            } else {
                var input = document.createElement('textarea');
                input.value = email;
                document.body.appendChild(input);
                input.select();
                try { document.execCommand('copy'); } catch(e) {}
                document.body.removeChild(input);
            }
            window.dispatchEvent(new CustomEvent('copy-email-toast', { detail: { email: email } }));
        };
    </script>

    @stack('scripts')
</body>
</html>
