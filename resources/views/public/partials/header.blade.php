<div x-data="{
    scrolled: false,
    mobileOpen: false
}" @scroll.window.passive="scrolled = (window.scrollY || document.documentElement.scrollTop) > 20">
    <header class="fixed w-full top-0 z-40 bg-[#080C14]/85 backdrop-blur-md border-b border-slate-800/80 transition-all duration-300"
        :class="{ 'shadow-lg shadow-black/30 bg-[#080C14]/95': scrolled }">
        <nav class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16 md:h-20">
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center gap-2.5 group" aria-label="{{ $websiteName }} - Home">
                        @if($logo)
                            <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($logo) }}" alt="{{ $websiteName }}" class="h-9 sm:h-10 w-auto object-contain">
                        @else
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center text-white font-bold text-lg shadow-md shadow-emerald-500/25 group-hover:scale-105 transition-transform">
                                {{ substr($websiteName, 0, 1) }}
                            </div>
                            <span class="text-xl sm:text-2xl font-bold tracking-tight text-white group-hover:text-emerald-400 transition-colors">
                                {{ $websiteName }}
                            </span>
                        @endif
                    </a>
                </div>

                @php
                    $isHomePage = request()->routeIs('home');

                    $onePageNav = collect([
                        (object)['label' => 'Home',     'url' => $isHomePage ? '#hero'     : route('home') . '#hero',     'hash' => '#hero'],
                        (object)['label' => 'About',    'url' => $isHomePage ? '#about'    : route('home') . '#about',    'hash' => '#about'],
                        (object)['label' => 'Skills',   'url' => $isHomePage ? '#skills'   : route('home') . '#skills',   'hash' => '#skills'],
                        (object)['label' => 'Projects', 'url' => $isHomePage ? '#projects' : route('home') . '#projects', 'hash' => '#projects'],
                        (object)['label' => 'Services', 'url' => $isHomePage ? '#services' : route('home') . '#services', 'hash' => '#services'],
                        (object)['label' => 'Contact',  'url' => $isHomePage ? '#contact'  : route('home') . '#contact',  'hash' => '#contact'],
                    ]);

                    $effectiveNav = $onePageNav->map(function ($item) {
                        return (object) [
                            'label' => $item->label,
                            'url' => $item->url,
                            'isActive' => false,
                        ];
                    });
                @endphp

                <div class="hidden md:flex items-center space-x-1 lg:space-x-1.5">
                    @foreach($effectiveNav as $item)
                        <a href="{{ $item->url }}"
                            class="px-3.5 py-2 text-sm font-medium rounded-lg transition-all duration-150 text-slate-300 hover:text-emerald-400 hover:bg-slate-800/60">
                            {{ $item->label }}
                        </a>
                    @endforeach
                </div>

                <div class="flex items-center gap-2 sm:gap-3">
                    @if($profile && $profile->whatsapp_url)
                        <a href="{{ $profile->whatsapp_url }}" target="_blank" rel="noopener noreferrer"
                            class="hidden sm:inline-flex items-center justify-center gap-1.5 px-3.5 py-2 font-medium rounded-lg border border-slate-700 bg-slate-900/60 text-slate-300 hover:text-white hover:border-emerald-500/50 hover:bg-slate-800 transition-all duration-200 text-sm"
                            title="Chat on WhatsApp">
                            <svg class="w-4 h-4 text-emerald-400" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.435 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                            <span>WhatsApp</span>
                        </a>
                    @endif
                    <div class="hidden sm:block">
                        <a href="{{ route('contact') }}" class="btn-shimmer-effect inline-flex items-center justify-center gap-2 px-5 py-2 font-semibold rounded-lg bg-gradient-to-r from-emerald-600 to-teal-500 hover:from-emerald-500 hover:to-teal-400 text-white shadow-md shadow-emerald-500/25 hover:shadow-emerald-500/40 hover:-translate-y-0.5 transition-all duration-200 text-sm">
                            Hire Me
                        </a>
                    </div>

                    <div class="md:hidden flex items-center">
                        <button @click="mobileOpen = true"
                            class="p-2 text-slate-400 hover:text-white rounded-lg hover:bg-slate-800 transition-colors"
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
        <div class="fixed inset-0 bg-black/80 backdrop-blur-sm transition-opacity" @click="mobileOpen = false"></div>
        <div class="absolute top-0 right-0 h-full w-full max-w-xs bg-[#0D131F] border-l border-slate-800 shadow-2xl p-6 flex flex-col justify-between overflow-y-auto">
            <div>
                <div class="flex justify-between items-center pb-4 border-b border-slate-800 mb-6">
                    <span class="font-bold text-lg text-white">{{ $websiteName }}</span>
                    <button @click="mobileOpen = false" class="p-2 text-slate-400 hover:text-white rounded-lg hover:bg-slate-800 transition-colors" aria-label="Close menu">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div class="space-y-1">
                    @foreach($effectiveNav as $item)
                        <a href="{{ $item->url }}" @click="mobileOpen = false"
                            class="block px-3.5 py-2.5 text-base font-medium rounded-lg transition-colors {{ $item->isActive ? 'text-emerald-400 bg-emerald-500/10 font-semibold border border-emerald-500/30' : 'text-slate-300 hover:text-white hover:bg-slate-800' }}">
                            {{ $item->label }}
                        </a>
                    @endforeach
                </div>
            </div>
            <div class="pt-6 border-t border-slate-800 space-y-3">
                @if($profile && $profile->whatsapp_url)
                    <a href="{{ $profile->whatsapp_url }}" target="_blank" rel="noopener noreferrer" @click="mobileOpen = false"
                        class="inline-flex items-center justify-center w-full px-5 py-3 font-medium rounded-lg border border-slate-700 bg-slate-900/60 text-slate-200 hover:bg-slate-800 transition-colors text-base text-center">
                        WhatsApp
                    </a>
                @endif
                <a href="{{ route('contact') }}" @click="mobileOpen = false"
                    class="inline-flex items-center justify-center w-full px-5 py-3 font-semibold rounded-lg bg-gradient-to-r from-emerald-600 to-teal-500 hover:from-emerald-500 hover:to-teal-400 text-white shadow-md shadow-emerald-500/25 transition-colors text-base text-center">
                    Hire Me
                </a>
            </div>
        </div>
    </div>
</div>
