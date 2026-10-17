<div x-data="{
    scrolled: false,
    mobileOpen: false,
    activeSection: 'hero'
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
        <nav class="specular-card flex items-center justify-between px-3.5 sm:px-5 py-2.5 sm:py-3 rounded-full bg-[#080B12]/85 backdrop-blur-2xl border border-white/[0.1] shadow-2xl shadow-black/70 transition-all duration-300"
            :class="{ 'bg-[#080B12]/95 border-white/[0.15] shadow-emerald-950/20': scrolled }">
            
            <!-- Brand / Monogram with Live Indicator -->
            <div class="flex items-center gap-3">
                <a href="{{ route('home') }}" class="flex items-center gap-2.5 group" aria-label="{{ $websiteName }} - Home">
                    @if($logo)
                        <img src="{{ asset('storage/' . $logo) }}" alt="{{ $websiteName }}" class="h-8 sm:h-9 w-auto object-contain">
                    @else
                        <div class="relative w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-gradient-to-br from-slate-800 to-slate-900 border border-white/[0.12] flex items-center justify-center text-white font-bold text-sm tracking-tight shadow-inner group-hover:border-emerald-500/50 group-hover:text-emerald-400 transition-all">
                            {{ substr($websiteName, 0, 1) }}
                            <span class="absolute -bottom-0.5 -right-0.5 w-2.5 h-2.5 rounded-full bg-emerald-500 ring-2 ring-[#080B12]"></span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-sm font-semibold tracking-tight text-white group-hover:text-slate-200 transition-colors leading-tight">
                                {{ $websiteName }}
                            </span>
                            <span class="hidden sm:inline text-[10px] font-mono text-emerald-400/90 tracking-wider">
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
            <div class="hidden md:flex items-center gap-1 bg-white/[0.03] px-2 py-1 rounded-full border border-white/[0.05]">
                @foreach($navItems as $item)
                    <a href="{{ $item->url }}"
                        :class="activeSection === '{{ $item->id }}' ? 'bg-white/[0.1] text-white shadow-xs font-semibold' : 'text-slate-400 hover:text-white hover:bg-white/[0.05]'"
                        class="px-3.5 py-1.5 text-xs lg:text-[13px] font-medium rounded-full transition-all duration-150">
                        {{ $item->label }}
                    </a>
                @endforeach
            </div>

            <!-- Action Controls -->
            <div class="flex items-center gap-2 sm:gap-2.5">
                @if($profile && $profile->whatsapp_url)
                    <a href="{{ $profile->whatsapp_url }}" target="_blank" rel="noopener noreferrer"
                        class="hidden lg:inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-slate-300 hover:text-white rounded-full bg-white/[0.03] hover:bg-white/[0.07] border border-white/[0.06] transition-all"
                        title="Direct WhatsApp Communication">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span>WhatsApp</span>
                    </a>
                @endif

                <a href="{{ route('contact') }}"
                    class="relative inline-flex items-center justify-center gap-1.5 px-4 sm:px-5 py-2 text-xs sm:text-[13px] font-semibold rounded-full bg-white text-slate-950 hover:bg-slate-100 hover:scale-[1.02] shadow-sm transition-all duration-200">
                    <span>Let's Talk</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>

                <!-- Mobile Menu Button -->
                <button @click="mobileOpen = true"
                    class="md:hidden p-2 text-slate-300 hover:text-white rounded-full hover:bg-white/[0.08] transition-colors"
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
        <div class="absolute top-0 right-0 h-full w-full max-w-xs bg-[#080B12] border-l border-white/[0.08] shadow-2xl p-6 flex flex-col justify-between overflow-y-auto">
            <div>
                <div class="flex justify-between items-center pb-4 border-b border-white/[0.08] mb-6">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-400"></span>
                        <span class="font-bold text-base text-white tracking-tight">{{ $websiteName }}</span>
                    </div>
                    <button @click="mobileOpen = false" class="p-2 text-slate-400 hover:text-white rounded-lg hover:bg-white/[0.06] transition-colors" aria-label="Close menu">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div class="space-y-1">
                    @foreach($navItems as $item)
                        <a href="{{ $item->url }}" @click="mobileOpen = false"
                            class="block px-3.5 py-2.5 text-sm font-medium rounded-xl text-slate-300 hover:text-white hover:bg-white/[0.06] transition-colors">
                            {{ $item->label }}
                        </a>
                    @endforeach
                </div>
            </div>
            <div class="pt-6 border-t border-white/[0.08] space-y-2.5">
                @if($profile && $profile->whatsapp_url)
                    <a href="{{ $profile->whatsapp_url }}" target="_blank" rel="noopener noreferrer" @click="mobileOpen = false"
                        class="inline-flex items-center justify-center w-full px-4 py-2.5 font-medium rounded-xl border border-white/[0.1] bg-white/[0.03] text-slate-200 hover:bg-white/[0.06] transition-colors text-sm text-center">
                        WhatsApp Contact
                    </a>
                @endif
                <a href="{{ route('contact') }}" @click="mobileOpen = false"
                    class="inline-flex items-center justify-center w-full px-4 py-2.5 font-semibold rounded-xl bg-white text-slate-950 hover:bg-slate-100 transition-colors text-sm text-center">
                    Let's Talk
                </a>
            </div>
        </div>
    </div>
</div>
