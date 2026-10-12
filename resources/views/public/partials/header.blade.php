<header class="fixed w-full top-0 z-40 bg-white/80 dark:bg-slate-950/80 backdrop-blur-md border-b border-slate-200 dark:border-slate-800 transition-all duration-300" x-data="{ scrolled: false }" :class="{ 'shadow-md': scrolled }" @scroll.window="scrolled = window.scrollY > 20">
    <nav class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16 md:h-20">
            <div class="flex-shrink-0 flex items-center">
                <a href="{{ route('home') }}" class="flex items-center gap-2" aria-label="{{ $websiteName }} - Home">
                    @if($logo)
                        <img src="{{ asset('storage/' . $logo) }}" alt="{{ $websiteName }}" class="h-10 w-auto">
                    @else
                        <span class="text-2xl font-bold text-primary">{{ $websiteName }}</span>
                    @endif
                </a>
            </div>

            <div class="hidden md:block">
                <div class="ml-10 flex items-center space-x-1">
                    @foreach($navItems as $item)
                        <a href="{{ $item->url }}"
                            class="px-4 py-2 text-sm font-medium text-slate-600 dark:text-slate-400 hover:text-primary dark:hover:text-primary rounded-lg transition-colors duration-200 relative group"
                            :class="{ 'bg-primary/10 dark:bg-primary/20 text-primary': window.location.pathname === '{{ $item->url }}' }">
                            {{ $item->label }}
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="hidden md:flex items-center gap-3">
                <a href="{{ route('contact') }}" class="btn btn-primary text-sm px-5 py-2">
                    Get In Touch
                </a>
            </div>

            <div class="md:hidden flex items-center">
                <button @click="mobileMenuOpen = true"
                    class="p-2 text-slate-600 dark:text-slate-400 hover:text-primary dark:hover:text-primary rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors"
                    aria-label="Toggle menu">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </nav>
</header>

<div x-data="{ open: false }" x-show="open" x-cloak
    class="fixed inset-0 z-50 md:hidden"
    style="display: none;" @click.away="open = false" @keydown.escape="open = false">
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" @click="open = false"></div>
    <div class="absolute top-0 right-0 h-full w-full max-w-sm bg-white dark:bg-slate-950 shadow-2xl overflow-y-auto animate-slide-in">
        <div class="p-6 border-b border-slate-200 dark:border-slate-800 flex justify-between items-center">
            <span class="font-bold text-xl">{{ $websiteName }}</span>
            <button @click="open = false" class="p-2 text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="p-6 space-y-4">
            @foreach($navItems as $item)
                <a href="{{ $item->url }}" @click="open = false"
                    class="block px-4 py-3 text-slate-700 dark:text-slate-300 hover:text-primary dark:hover:text-primary rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors font-medium">
                    {{ $item->label }}
                </a>
            @endforeach
            <div class="pt-4 border-t border-slate-200 dark:border-slate-800">
                <a href="{{ route('contact') }}" @click="open = false"
                    class="btn btn-primary w-full justify-center">
                    Get In Touch
                </a>
            </div>
        </div>
    </div>
</div>