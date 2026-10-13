<div x-data="{
    scrolled: false,
    mobileOpen: false
}" @scroll.window="scrolled = window.scrollY > 20">
    <header class="fixed w-full top-0 z-40 bg-white/95 backdrop-blur-md border-b border-[#E5E7EB] transition-all duration-300"
        :class="{ 'shadow-sm': scrolled }">
        <nav class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16 md:h-20">
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center gap-2.5 group" aria-label="{{ $websiteName }} - Home">
                        @if($logo)
                            <img src="{{ asset('storage/' . $logo) }}" alt="{{ $websiteName }}" class="h-9 sm:h-10 w-auto object-contain">
                        @else
                            <div class="w-9 h-9 rounded-xl bg-[#1B560B] flex items-center justify-center text-white font-bold text-base shadow-sm group-hover:bg-[#144208] transition-colors">
                                {{ substr($websiteName, 0, 1) }}
                            </div>
                            <span class="text-xl sm:text-2xl font-bold tracking-tight text-[#1F2937] group-hover:text-[#1B560B] transition-colors">
                                {{ $websiteName }}
                            </span>
                        @endif
                    </a>
                </div>

                @php
                    $effectiveNav = ($navItems && $navItems->isNotEmpty())
                        ? $navItems
                        : collect([
                            (object)['label' => 'Home', 'url' => '/'],
                            (object)['label' => 'About', 'url' => '/about'],
                            (object)['label' => 'Skills', 'url' => '/skills'],
                            (object)['label' => 'Projects', 'url' => '/projects'],
                            (object)['label' => 'Services', 'url' => '/services'],
                            (object)['label' => 'Resume', 'url' => '/resume'],
                            (object)['label' => 'Contact', 'url' => '/contact'],
                        ]);
                @endphp

                <div class="hidden md:flex items-center space-x-1 lg:space-x-1.5">
                    @foreach($effectiveNav as $item)
                        @php
                            $isActive = request()->is(ltrim($item->url, '/')) || (request()->routeIs('home') && $item->url === '/');
                        @endphp
                        <a href="{{ $item->url }}"
                            class="px-3.5 py-2 text-sm font-medium rounded-lg transition-all duration-150 {{ $isActive ? 'text-[#1B560B] bg-[#DCE8D6]/40 font-semibold' : 'text-[#667085] hover:text-[#1F2937] hover:bg-[#F5F7F2]' }}">
                            {{ $item->label }}
                        </a>
                    @endforeach
                </div>

                <div class="flex items-center gap-2 sm:gap-3">
                    @if($profile && $profile->whatsapp_url)
                        <a href="{{ $profile->whatsapp_url }}" target="_blank" rel="noopener noreferrer"
                            class="hidden sm:inline-flex items-center justify-center gap-1.5 px-3.5 py-2.5 font-medium rounded-lg border border-[#E5E7EB] text-[#1F2937] hover:bg-[#F5F7F2] transition-all duration-200 text-sm"
                            title="Chat on WhatsApp">
                            WhatsApp
                        </a>
                    @endif
                    <div class="hidden sm:block">
                        <a href="{{ route('contact') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 font-medium rounded-lg bg-[#1B560B] text-white hover:bg-[#144208] shadow-sm hover:shadow transition-all duration-200 text-sm">
                            Hire Me
                        </a>
                    </div>

                    <div class="md:hidden flex items-center">
                        <button @click="mobileOpen = true"
                            class="p-2 text-[#667085] hover:text-[#1B560B] rounded-lg hover:bg-[#F5F7F2] transition-colors"
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
        <div class="absolute top-0 right-0 h-full w-full max-w-xs bg-white shadow-2xl p-6 flex flex-col justify-between overflow-y-auto">
            <div>
                <div class="flex justify-between items-center pb-4 border-b border-[#E5E7EB] mb-6">
                    <span class="font-bold text-lg text-[#1F2937]">{{ $websiteName }}</span>
                    <button @click="mobileOpen = false" class="p-2 text-[#667085] hover:text-[#1F2937] rounded-lg hover:bg-[#F5F7F2] transition-colors" aria-label="Close menu">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div class="space-y-1">
                    @foreach($effectiveNav as $item)
                        @php
                            $isActive = request()->is(ltrim($item->url, '/')) || (request()->routeIs('home') && $item->url === '/');
                        @endphp
                        <a href="{{ $item->url }}" @click="mobileOpen = false"
                            class="block px-3.5 py-2.5 text-base font-medium rounded-lg transition-colors {{ $isActive ? 'text-[#1B560B] bg-[#DCE8D6]/40 font-semibold' : 'text-[#1F2937] hover:text-[#1B560B] hover:bg-[#F5F7F2]' }}">
                            {{ $item->label }}
                        </a>
                    @endforeach
                </div>
            </div>
            <div class="pt-6 border-t border-[#E5E7EB] space-y-3">
                @if($profile && $profile->whatsapp_url)
                    <a href="{{ $profile->whatsapp_url }}" target="_blank" rel="noopener noreferrer" @click="mobileOpen = false"
                        class="inline-flex items-center justify-center w-full px-5 py-3 font-medium rounded-lg border border-[#E5E7EB] text-[#1F2937] hover:bg-[#F5F7F2] transition-colors text-base text-center">
                        WhatsApp
                    </a>
                @endif
                <a href="{{ route('contact') }}" @click="mobileOpen = false"
                    class="inline-flex items-center justify-center w-full px-5 py-3 font-medium rounded-lg bg-[#1B560B] text-white hover:bg-[#144208] shadow-sm transition-colors text-base text-center">
                    Hire Me
                </a>
            </div>
        </div>
    </div>
</div>
