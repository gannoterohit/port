<div x-data="{
    scrolled: false,
    mobileOpen: false,
    activeSection: 'hero',
    currentTheme: document.documentElement.getAttribute('data-theme') || 'warm_stone',
    toggleTheme() {
        this.currentTheme = (this.currentTheme === 'warm_obsidian') ? 'warm_stone' : 'warm_obsidian';
        document.documentElement.setAttribute('data-theme', this.currentTheme);
        localStorage.setItem('portfolio_theme', this.currentTheme);
    }
}" 
x-init="
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                activeSection = entry.target.id;
            }
        });
    }, { rootMargin: '-20% 0px -55% 0px' });
    document.querySelectorAll('section[id]').forEach(sec => observer.observe(sec));
"
@scroll.window.passive="scrolled = (window.scrollY || document.documentElement.scrollTop) > 20"
class="fixed top-0 left-0 right-0 z-50 pointer-events-none px-3 sm:px-6 pt-3 sm:pt-4 transition-all duration-300">
    <header class="max-w-7xl 2xl:max-w-[1400px] mx-auto pointer-events-auto transition-all duration-300">
        <nav :class="scrolled ? 'bg-[var(--theme-bg-card)]/90 backdrop-blur-2xl border-[var(--theme-border)] shadow-xl py-2 sm:py-2.5' : 'bg-[var(--theme-bg-card)]/75 backdrop-blur-xl border-[var(--theme-border)]/70 shadow-lg py-2.5 sm:py-3'"
            class="specular-card flex items-center justify-between px-3.5 sm:px-5 rounded-full border transition-all duration-300">
            
            <!-- Brand / Logo Monogram with Code Brackets & Live Indicator -->
            <div class="flex items-center gap-2.5 sm:gap-3">
                <a href="{{ route('home') }}" class="flex items-center gap-2.5 group" aria-label="{{ $websiteName }} - Home">
                    @if($logo)
                        <img src="{{ asset('storage/' . $logo) }}" alt="{{ $websiteName }}" class="h-8 sm:h-9 w-auto object-contain">
                    @else
                        <!-- Developer Monogram with Code Brackets </> -->
                        <div class="relative w-8 h-8 sm:w-9 sm:h-9 rounded-xl bg-brand/10 text-brand border border-brand/25 flex items-center justify-center font-mono font-bold text-xs sm:text-sm tracking-tight shadow-2xs transition-all group-hover:scale-105">
                            <span>&lt;/&gt;</span>
                            <span class="absolute -bottom-0.5 -right-0.5 w-2 h-2 rounded-full bg-emerald-500 ring-2 ring-[var(--theme-bg-card)]"></span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-sm font-bold tracking-tight leading-tight text-[var(--theme-text-heading)] group-hover:text-brand transition-colors">
                                {{ $websiteName }}
                            </span>
                            <span class="hidden sm:inline text-[10px] font-mono text-[var(--theme-text-muted)] tracking-wider uppercase">
                                {{ \App\Models\Setting::get('specialization_text') ?: 'BACKEND & SYSTEMS' }}
                            </span>
                        </div>
                    @endif
                </a>

                <!-- Header Live Available Pulsing Badge (Visible on Tablet, Laptop & Desktop) -->
                @if(\App\Models\Setting::get('available_for_freelance', '1') == '1')
                <div class="hidden md:inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20 text-[11px] font-semibold tracking-wide">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                    </span>
                    <span>Available for Work</span>
                </div>
                @endif
            </div>

            @php
                $isHomePage = request()->routeIs('home');

                $sectionAnchorMap = [
                    'hero' => 'hero',
                    'home' => 'hero',
                    'about' => 'about',
                    'skills' => 'tech-stack',
                    'tech-stack' => 'tech-stack',
                    'projects' => 'projects',
                    'services' => 'services',
                    'contact' => 'contact',
                    'testimonials' => 'testimonials',
                ];

                $resolveNavItemUrl = function ($rawUrl) use ($isHomePage, $sectionAnchorMap) {
                    if (blank($rawUrl)) {
                        return $isHomePage ? '#hero' : route('home');
                    }

                    if (str_starts_with($rawUrl, 'http://') || str_starts_with($rawUrl, 'https://')) {
                        return $rawUrl;
                    }

                    $slug = trim($rawUrl, '/#');

                    if (empty($slug) || $rawUrl === '/') {
                        return $isHomePage ? '#hero' : route('home');
                    }

                    if (isset($sectionAnchorMap[$slug])) {
                        $anchor = '#' . $sectionAnchorMap[$slug];
                        return $isHomePage ? $anchor : (rtrim(route('home'), '/') . '/' . $anchor);
                    }

                    return url(ltrim($rawUrl, '/'));
                };

                // Dynamic Navigation from Admin Panel (NavigationItem model) with consistent anchor-first routing
                $activeNavItems = (isset($navItems) && $navItems->isNotEmpty())
                    ? $navItems->map(function ($item) use ($resolveNavItemUrl) {
                        $rawUrl = $item->url;
                        $slug = trim($rawUrl, '/#');

                        return (object)[
                            'id' => $slug ?: 'hero',
                            'label' => $item->label,
                            'url' => $resolveNavItemUrl($rawUrl),
                            'target' => $item->target ?? '_self',
                        ];
                    })
                    : collect([
                        (object)['id' => 'hero',       'label' => 'Home',     'url' => $isHomePage ? '#hero'       : route('home'), 'target' => '_self'],
                        (object)['id' => 'about',      'label' => 'About',    'url' => $isHomePage ? '#about'      : (rtrim(route('home'), '/') . '/#about'), 'target' => '_self'],
                        (object)['id' => 'skills',     'label' => 'Skills',   'url' => $isHomePage ? '#tech-stack' : (rtrim(route('home'), '/') . '/#tech-stack'), 'target' => '_self'],
                        (object)['id' => 'projects',   'label' => 'Projects', 'url' => $isHomePage ? '#projects'   : (rtrim(route('home'), '/') . '/#projects'), 'target' => '_self'],
                        (object)['id' => 'services',   'label' => 'Services', 'url' => $isHomePage ? '#services'   : (rtrim(route('home'), '/') . '/#services'), 'target' => '_self'],
                        (object)['id' => 'resume',     'label' => 'Resume',   'url' => route('resume'), 'target' => '_self'],
                        (object)['id' => 'contact',    'label' => 'Contact',  'url' => $isHomePage ? '#contact'    : (rtrim(route('home'), '/') . '/#contact'), 'target' => '_self'],
                    ]);
            @endphp

            <!-- Desktop Centered Navigation with Active Floating Pill Tracking -->
            <div class="hidden lg:flex items-center gap-1 bg-black/[0.04] dark:bg-white/[0.04] px-2 py-1 rounded-full border border-black/[0.06] dark:border-white/[0.06]">
                @foreach($activeNavItems as $item)
                    @php
                        $isActiveCond = in_array($item->id, ['skills', 'tech-stack']) 
                            ? "(activeSection === 'skills' || activeSection === 'tech-stack')" 
                            : "activeSection === '{$item->id}'";
                    @endphp
                    <a href="{{ $item->url }}" target="{{ $item->target }}"
                        :class="{{ $isActiveCond }} 
                            ? 'bg-brand/10 text-brand font-bold shadow-xs' 
                            : 'text-[var(--theme-text-body)] opacity-75 hover:opacity-100 hover:bg-black/[0.04] dark:hover:bg-white/[0.05]'"
                        class="px-3.5 py-1.5 text-xs lg:text-[13px] font-medium rounded-full transition-all duration-150">
                        {{ $item->label }}
                    </a>
                @endforeach
            </div>

            <!-- Action Controls -->
            <div class="flex items-center gap-2 sm:gap-2.5">
                <!-- Theme Toggle Button (☀️ Warm Stone <-> 🌙 Warm Obsidian) -->
                <button type="button" @click="toggleTheme()"
                    class="p-2 sm:px-3 sm:py-1.5 rounded-full border border-black/10 dark:border-white/10 bg-black/[0.03] dark:bg-white/[0.04] hover:bg-black/[0.06] dark:hover:bg-white/[0.08] text-xs font-semibold flex items-center gap-1.5 transition-all duration-200"
                    :title="currentTheme === 'warm_obsidian' ? 'Switch to Warm Stone (Light)' : 'Switch to Warm Obsidian (Dark)'"
                    aria-label="Toggle Light and Dark Mode">
                    
                    <span x-show="currentTheme === 'warm_obsidian'" class="flex items-center gap-1.5 text-amber-300">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        <span class="hidden xl:inline text-[11px] font-mono font-bold">Light</span>
                    </span>

                    <span x-show="currentTheme !== 'warm_obsidian'" class="flex items-center gap-1.5 text-slate-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                        <span class="hidden xl:inline text-[11px] font-mono font-bold">Dark</span>
                    </span>
                </button>

                @if($profile && $profile->whatsapp_url)
                    <a href="{{ $profile->whatsapp_url }}" target="_blank" rel="noopener noreferrer"
                        class="hidden xl:inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium rounded-full bg-black/[0.03] dark:bg-white/[0.03] hover:bg-black/[0.06] dark:hover:bg-white/[0.06] border border-black/[0.06] dark:border-white/[0.06] transition-all"
                        title="Direct WhatsApp Communication">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span>WhatsApp</span>
                    </a>
                @endif

                <!-- Direct Action CTA Button (Scrolls straight to Contact section) -->
                <a href="{{ request()->routeIs('home') ? '#contact' : (rtrim(route('home'), '/') . '/#contact') }}"
                    class="theme-btn-primary relative inline-flex items-center justify-center gap-1.5 px-3.5 sm:px-5 py-2 text-xs sm:text-[13px] font-semibold rounded-full shadow-sm hover:scale-[1.02] transition-all duration-200">
                    <span>Let's Talk</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>

                <!-- Mobile & Tablet Menu Button (screens < 1024px) -->
                <button @click="mobileOpen = true"
                    class="lg:hidden p-2 rounded-full border border-black/10 dark:border-white/10 hover:bg-black/[0.06] dark:hover:bg-white/[0.06] text-[var(--theme-text-heading)] transition-colors"
                    aria-label="Open Navigation Menu">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </nav>
    </header>

    <!-- Mobile & Tablet Drawer Modal with Smooth Animations -->
    <div x-show="mobileOpen" x-cloak
        class="fixed inset-0 z-50 lg:hidden pointer-events-auto"
        @keydown.escape.window="mobileOpen = false"
        x-effect="document.body.style.overflow = mobileOpen ? 'hidden' : ''"
        style="display: none;">
        
        <!-- Backdrop with Fade -->
        <div x-show="mobileOpen"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-black/75 backdrop-blur-sm"
            @click="mobileOpen = false"></div>

        <!-- Sliding Panel from Right -->
        <div x-show="mobileOpen"
            x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in duration-200 transform"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="translate-x-full"
            class="absolute top-0 right-0 h-full w-full max-w-xs bg-[var(--theme-bg-card)] border-l border-[var(--theme-border)] shadow-2xl p-6 flex flex-col justify-between overflow-y-auto">
            
            <div>
                <div class="flex justify-between items-center pb-4 border-b border-[var(--theme-border)] mb-6">
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-7 rounded-lg bg-brand/10 text-brand border border-brand/20 flex items-center justify-center font-mono font-bold text-xs">
                            &lt;/&gt;
                        </div>
                        <span class="font-bold text-base tracking-tight text-[var(--theme-text-heading)]">{{ $websiteName }}</span>
                    </div>
                    <button @click="mobileOpen = false" class="p-2 opacity-70 hover:opacity-100 rounded-lg hover:bg-black/5 dark:hover:bg-white/5 transition-colors text-[var(--theme-text-heading)]" aria-label="Close menu">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div class="space-y-1">
                    @foreach($activeNavItems as $item)
                        @php
                            $isActiveCondMobile = in_array($item->id, ['skills', 'tech-stack']) 
                                ? "(activeSection === 'skills' || activeSection === 'tech-stack')" 
                                : "activeSection === '{$item->id}'";
                        @endphp
                        <a href="{{ $item->url }}" target="{{ $item->target }}" @click="mobileOpen = false"
                            :class="{{ $isActiveCondMobile }} 
                                ? 'bg-brand/10 text-brand font-bold' 
                                : 'text-[var(--theme-text-heading)] hover:bg-black/5 dark:hover:bg-white/5'"
                            class="flex items-center justify-between px-4 py-3 text-sm font-medium rounded-xl transition-colors">
                            <span>{{ $item->label }}</span>
                            <span class="text-xs opacity-40">→</span>
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="pt-6 border-t border-[var(--theme-border)] space-y-2.5">
                <button type="button" @click="toggleTheme()"
                    class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl border border-[var(--theme-border)] bg-[var(--theme-bg-alt)] text-sm font-semibold text-[var(--theme-text-heading)]">
                    <span x-show="currentTheme === 'warm_obsidian'">☀️ Switch to Light Mode</span>
                    <span x-show="currentTheme !== 'warm_obsidian'">🌙 Switch to Dark Mode</span>
                </button>

                @if($profile && $profile->whatsapp_url)
                    <a href="{{ $profile->whatsapp_url }}" target="_blank" rel="noopener noreferrer" @click="mobileOpen = false"
                        class="inline-flex items-center justify-center w-full px-4 py-2.5 font-medium rounded-xl border border-[var(--theme-border)] bg-[var(--theme-bg-alt)] text-[var(--theme-text-heading)] transition-colors text-sm text-center">
                        WhatsApp Contact
                    </a>
                @endif

                <a href="{{ request()->routeIs('home') ? '#contact' : (rtrim(route('home'), '/') . '/#contact') }}" @click="mobileOpen = false"
                    class="theme-btn-primary inline-flex items-center justify-center w-full px-4 py-2.5 font-semibold rounded-xl shadow-sm text-sm text-center">
                    Let's Talk
                </a>
            </div>
        </div>
    </div>
</div>
