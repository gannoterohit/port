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
    }, { threshold: 0.35 });
    document.querySelectorAll('section[id]').forEach(sec => observer.observe(sec));
"
@scroll.window.passive="scrolled = (window.scrollY || document.documentElement.scrollTop) > 20"
class="fixed top-0 left-0 right-0 z-50 pointer-events-none px-3 sm:px-6 pt-3 sm:pt-4 transition-all duration-300">
    <header class="max-w-6xl mx-auto pointer-events-auto transition-all duration-300">
        <nav class="specular-card flex items-center justify-between px-3.5 sm:px-5 py-2.5 sm:py-3 rounded-full backdrop-blur-2xl border shadow-xl transition-all duration-300">
            
            <!-- Brand / Monogram with Live Indicator -->
            <div class="flex items-center gap-3">
                <a href="{{ route('home') }}" class="flex items-center gap-2.5 group" aria-label="{{ $websiteName }} - Home">
                    @if($logo)
                        <img src="{{ asset('storage/' . $logo) }}" alt="{{ $websiteName }}" class="h-8 sm:h-9 w-auto object-contain">
                    @else
                        <div class="relative w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-black/10 dark:bg-white/10 border border-current/20 flex items-center justify-center font-bold text-sm tracking-tight shadow-inner transition-all">
                            {{ substr($websiteName, 0, 1) }}
                            <span class="absolute -bottom-0.5 -right-0.5 w-2.5 h-2.5 rounded-full bg-emerald-500 ring-2 ring-white dark:ring-black"></span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-sm font-semibold tracking-tight leading-tight">
                                {{ $websiteName }}
                            </span>
                            <span class="hidden sm:inline text-[10px] font-mono opacity-75 tracking-wider">
                                BACKEND &amp; SYSTEMS
                            </span>
                        </div>
                    @endif
                </a>
            </div>

            @php
                $isHomePage = request()->routeIs('home');

                $navItems = collect([
                    (object)['id' => 'hero',     'label' => 'Home',     'url' => $isHomePage ? '#hero'     : route('home') . '#hero'],
                    (object)['id' => 'about',    'label' => 'About',    'url' => $isHomePage ? '#about'    : route('home') . '#about'],
                    (object)['id' => 'skills',   'label' => 'Skills',   'url' => $isHomePage ? '#skills'   : route('home') . '#skills'],
                    (object)['id' => 'projects', 'label' => 'Projects', 'url' => $isHomePage ? '#projects' : route('home') . '#projects'],
                    (object)['id' => 'services', 'label' => 'Services', 'url' => $isHomePage ? '#services' : route('home') . '#services'],
                    (object)['id' => 'contact',  'label' => 'Contact',  'url' => $isHomePage ? '#contact'  : route('home') . '#contact'],
                ]);
            @endphp

            <!-- Desktop Centered Navigation with Active Floating Pill Tracking -->
            <div class="hidden md:flex items-center gap-1 bg-black/[0.04] dark:bg-white/[0.04] px-2 py-1 rounded-full border border-black/[0.06] dark:border-white/[0.06]">
                @foreach($navItems as $item)
                    <a href="{{ $item->url }}"
                        :class="activeSection === '{{ $item->id }}' ? 'bg-black/10 dark:bg-white/10 shadow-xs font-semibold' : 'opacity-70 hover:opacity-100 hover:bg-black/[0.04] dark:hover:bg-white/[0.04]'"
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
                        <span class="hidden lg:inline text-[11px] font-mono font-bold">Light</span>
                    </span>

                    <span x-show="currentTheme !== 'warm_obsidian'" class="flex items-center gap-1.5 text-slate-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                        <span class="hidden lg:inline text-[11px] font-mono font-bold">Dark</span>
                    </span>
                </button>

                @if($profile && $profile->whatsapp_url)
                    <a href="{{ $profile->whatsapp_url }}" target="_blank" rel="noopener noreferrer"
                        class="hidden lg:inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium rounded-full bg-black/[0.03] dark:bg-white/[0.03] hover:bg-black/[0.06] dark:hover:bg-white/[0.06] border border-black/[0.06] dark:border-white/[0.06] transition-all"
                        title="Direct WhatsApp Communication">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span>WhatsApp</span>
                    </a>
                @endif

                <a href="{{ route('contact') }}"
                    class="theme-btn-primary relative inline-flex items-center justify-center gap-1.5 px-4 sm:px-5 py-2 text-xs sm:text-[13px] font-semibold rounded-full shadow-sm hover:opacity-90 transition-all duration-200">
                    <span>Let's Talk</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>

                <!-- Mobile Menu Button -->
                <button @click="mobileOpen = true"
                    class="md:hidden p-2 rounded-full hover:bg-black/[0.06] dark:hover:bg-white/[0.06] transition-colors"
                    aria-label="Open Navigation Menu">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </nav>
    </header>

    <!-- Mobile Drawer Modal -->
    <div x-show="mobileOpen" x-cloak
        class="fixed inset-0 z-50 md:hidden pointer-events-auto"
        style="display: none;">
        <div class="fixed inset-0 bg-black/80 backdrop-blur-md transition-opacity" @click="mobileOpen = false"></div>
        <div class="absolute top-0 right-0 h-full w-full max-w-xs bg-white dark:bg-[#121316] border-l border-black/10 dark:border-white/10 shadow-2xl p-6 flex flex-col justify-between overflow-y-auto">
            <div>
                <div class="flex justify-between items-center pb-4 border-b border-black/10 dark:border-white/10 mb-6">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                        <span class="font-bold text-base tracking-tight">{{ $websiteName }}</span>
                    </div>
                    <button @click="mobileOpen = false" class="p-2 opacity-70 hover:opacity-100 rounded-lg hover:bg-black/5 dark:hover:bg-white/5 transition-colors" aria-label="Close menu">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div class="space-y-1">
                    @foreach($navItems as $item)
                        <a href="{{ $item->url }}" @click="mobileOpen = false"
                            class="block px-3.5 py-2.5 text-sm font-medium rounded-xl opacity-80 hover:opacity-100 hover:bg-black/5 dark:hover:bg-white/5 transition-colors">
                            {{ $item->label }}
                        </a>
                    @endforeach
                </div>
            </div>
            <div class="pt-6 border-t border-black/10 dark:border-white/10 space-y-2.5">
                <button type="button" @click="toggleTheme()"
                    class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl border border-black/10 dark:border-white/10 bg-black/5 dark:bg-white/5 text-sm font-semibold">
                    <span x-show="currentTheme === 'warm_obsidian'">☀️ Switch to Light Mode (Warm Stone)</span>
                    <span x-show="currentTheme !== 'warm_obsidian'">🌙 Switch to Dark Mode (Warm Obsidian)</span>
                </button>

                @if($profile && $profile->whatsapp_url)
                    <a href="{{ $profile->whatsapp_url }}" target="_blank" rel="noopener noreferrer" @click="mobileOpen = false"
                        class="inline-flex items-center justify-center w-full px-4 py-2.5 font-medium rounded-xl border border-black/10 dark:border-white/10 bg-black/[0.02] dark:bg-white/[0.02] transition-colors text-sm text-center">
                        WhatsApp Contact
                    </a>
                @endif
                <a href="{{ route('contact') }}" @click="mobileOpen = false"
                    class="inline-flex items-center justify-center w-full px-4 py-2.5 font-semibold rounded-xl bg-white text-slate-950 transition-colors text-sm text-center">
                    Let's Talk
                </a>
            </div>
        </div>
    </div>
</div>
