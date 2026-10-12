<div x-data="{
    scrolled: false,
    mobileOpen: false,
    darkMode: document.documentElement.classList.contains('dark'),
    toggleDark() {
        this.darkMode = !this.darkMode;
        if (this.darkMode) {
            document.documentElement.classList.add('dark');
            localStorage.setItem('color-theme', 'dark');
        } else {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('color-theme', 'light');
        }
    }
}" @scroll.window="scrolled = window.scrollY > 20">
    <header class="fixed w-full top-0 z-40 bg-white/90 dark:bg-slate-950/90 backdrop-blur-md border-b border-slate-200/80 dark:border-slate-800/80 transition-all duration-300"
        :class="{ 'shadow-sm': scrolled }">
        <nav class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16 md:h-20">
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center gap-2.5 group" aria-label="{{ $websiteName }} - Home">
                        @if($logo)
                            <img src="{{ asset('storage/' . $logo) }}" alt="{{ $websiteName }}" class="h-9 sm:h-10 w-auto object-contain">
                        @else
                            <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-primary to-blue-400 flex items-center justify-center text-white font-bold text-lg shadow-sm group-hover:scale-105 transition-transform">
                                {{ substr($websiteName, 0, 1) }}
                            </div>
                            <span class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900 dark:text-white group-hover:text-primary transition-colors">
                                {{ $websiteName }}
                            </span>
                        @endif
                    </a>
                </div>

                <div class="hidden md:flex items-center space-x-1 lg:space-x-2">
                    @foreach($navItems as $item)
                        <a href="{{ $item->url }}"
                            class="px-3.5 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->is(ltrim($item->url, '/')) || (request()->routeIs('home') && $item->url === '/') ? 'text-primary bg-primary/10 font-semibold' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800/60' }}">
                            {{ $item->label }}
                        </a>
                    @endforeach
                </div>

                <div class="flex items-center gap-2 sm:gap-3">
                    <button @click="toggleDark()"
                        class="p-2 rounded-lg text-slate-500 hover:text-slate-900 dark:text-slate-400 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors"
                        title="Toggle Dark Mode" aria-label="Toggle theme">
                        <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                        <svg x-show="darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 9H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </button>

                    <div class="hidden sm:block">
                        <a href="{{ route('contact') }}" class="btn btn-primary text-sm px-4 sm:px-5 py-2 font-medium">
                            Hire Me
                        </a>
                    </div>

                    <div class="md:hidden flex items-center">
                        <button @click="mobileOpen = true"
                            class="p-2 text-slate-600 dark:text-slate-400 hover:text-primary dark:hover:text-primary rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors"
                            aria-label="Open menu">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <!-- Mobile Drawer -->
    <div x-show="mobileOpen" x-cloak
        class="fixed inset-0 z-50 md:hidden"
        style="display: none;">
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity" @click="mobileOpen = false"></div>
        <div class="absolute top-0 right-0 h-full w-full max-w-xs bg-white dark:bg-slate-900 shadow-2xl p-6 flex flex-col justify-between overflow-y-auto">
            <div>
                <div class="flex justify-between items-center pb-4 border-b border-slate-100 dark:border-slate-800 mb-6">
                    <span class="font-bold text-lg text-slate-900 dark:text-white">{{ $websiteName }}</span>
                    <button @click="mobileOpen = false" class="p-2 text-slate-500 hover:text-slate-900 dark:hover:text-white rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors" aria-label="Close menu">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div class="space-y-1">
                    @foreach($navItems as $item)
                        <a href="{{ $item->url }}" @click="mobileOpen = false"
                            class="block px-3.5 py-2.5 text-base font-medium text-slate-700 dark:text-slate-200 hover:text-primary dark:hover:text-primary rounded-lg hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                            {{ $item->label }}
                        </a>
                    @endforeach
                </div>
            </div>
            <div class="pt-6 border-t border-slate-100 dark:border-slate-800 space-y-3">
                <a href="{{ route('contact') }}" @click="mobileOpen = false"
                    class="btn btn-primary w-full justify-center">
                    Hire Me
                </a>
            </div>
        </div>
    </div>
</div>