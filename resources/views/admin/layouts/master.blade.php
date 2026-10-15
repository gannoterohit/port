@extends('admin.layouts.app')

@section('content')
<div class="min-h-screen bg-[#F6F8F7] text-[#1F2937] lg:flex" x-data="{ sidebarOpen: false }" @keydown.escape.window="sidebarOpen = false">
        @php
            $currentRoute = request()->route()?->getName() ?? '';
            $activeClass = 'admin-sidebar-item-active';
            $inactiveClass = 'admin-sidebar-item-inactive';
        @endphp

    <div x-cloak x-show="sidebarOpen" x-transition.opacity @click="sidebarOpen = false"
        class="fixed inset-0 z-40 bg-gray-950/40 backdrop-blur-[2px] lg:hidden" aria-hidden="true"></div>

    <aside
        class="fixed inset-y-0 left-0 z-50 flex w-[min(84vw,288px)] flex-col border-r border-[#E7EBE8] bg-white shadow-xl transition-transform duration-200 lg:sticky lg:top-0 lg:z-auto lg:h-screen lg:w-[272px] lg:shrink-0 lg:translate-x-0 lg:shadow-none"
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        aria-label="Admin navigation">
        <div class="flex min-h-[76px] items-center justify-between border-b border-[#E7EBE8] px-5">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-emerald-600 to-teal-600 text-white font-bold shadow-xs">
                    {{ substr(\App\Models\Setting::get('website_name', 'CMS'), 0, 1) }}
                </div>
                <div class="min-w-0">
                    <span class="block truncate text-sm font-bold text-slate-800">{{ \App\Models\Setting::get('website_name', 'Portfolio CMS') }}</span>
                    <span class="mt-0.5 block text-[10px] font-semibold tracking-wider text-slate-400">ADMIN CONTROL PANEL</span>
                </div>
            </div>
            <button type="button" @click="sidebarOpen = false" class="rounded-lg p-2 text-gray-500 hover:bg-gray-100 lg:hidden" aria-label="Close navigation">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <nav class="flex-1 overflow-y-auto px-3 py-4" @click="sidebarOpen = false">
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="admin-sidebar-item {{ $currentRoute === 'admin.dashboard' ? $activeClass : $inactiveClass }}">
                        <svg class="admin-sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <rect x="3" y="3" width="8" height="8" rx="1.5"></rect>
                            <rect x="13" y="3" width="8" height="5" rx="1.5"></rect>
                            <rect x="13" y="10" width="8" height="11" rx="1.5"></rect>
                            <rect x="3" y="13" width="8" height="8" rx="1.5"></rect>
                        </svg>
                        Dashboard
                    </a>
                </li>
                <li class="admin-sidebar-heading">WEBSITE CONTENT</li>
                <li>
                    <a href="{{ route('admin.profile.edit') }}" class="admin-sidebar-item {{ str_contains($currentRoute, 'profile') ? $activeClass : $inactiveClass }}">
                        <svg class="admin-sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Profile & About
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.homepage.edit') }}" class="admin-sidebar-item {{ str_contains($currentRoute, 'homepage') ? $activeClass : $inactiveClass }}">
                        <svg class="admin-sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m3 10 9-7 9 7v10a1 1 0 0 1-1 1h-6v-7h-4v7H5a1 1 0 0 1-1-1V10"></path>
                        </svg>
                        Homepage
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.skills.index') }}" class="admin-sidebar-item {{ str_contains($currentRoute, 'skills') ? $activeClass : $inactiveClass }}">
                        <svg class="admin-sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m12 3-1.9 5.8L4 11l6.1 2.2L12 19l1.9-5.8L20 11l-6.1-2.2L12 3Z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 14-.9 2.1L16 17l2.1.9L19 20l.9-2.1L22 17l-2.1-.9L19 14Z"></path>
                        </svg>
                        Skills
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.skill-categories.index') }}" class="admin-sidebar-item {{ str_contains($currentRoute, 'skill-categories') ? $activeClass : $inactiveClass }}">
                        <svg class="admin-sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <rect x="3" y="3" width="7" height="7" rx="1.5"></rect>
                            <rect x="14" y="3" width="7" height="7" rx="1.5"></rect>
                            <rect x="3" y="14" width="7" height="7" rx="1.5"></rect>
                            <rect x="14" y="14" width="7" height="7" rx="1.5"></rect>
                        </svg>
                        Skill Categories
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.projects.index') }}" class="admin-sidebar-item {{ str_contains($currentRoute, 'projects') ? $activeClass : $inactiveClass }}">
                        <svg class="admin-sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11V9a6 6 0 00-6-6H8a6 6 0 00-6 6v6l2 2v4a2 2 0 002 2h8a2 2 0 002-2v-4l2-2z"></path>
                        </svg>
                        Projects
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.services.index') }}" class="admin-sidebar-item {{ str_contains($currentRoute, 'services') ? $activeClass : $inactiveClass }}">
                        <svg class="admin-sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15a4 4 0 0 1-4 4H7l-4 2V7a4 4 0 0 1 4-4h10a4 4 0 0 1 4 4v8Z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9h8M8 13h5"></path>
                        </svg>
                        Services
                    </a>
                </li>
                {{-- Testimonials hidden until real client feedback exists --}}
                <li>
                    <a href="{{ route('admin.pages.index') }}" class="admin-sidebar-item {{ str_contains($currentRoute, 'pages') ? $activeClass : $inactiveClass }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6M9 12l2-2M9 12l2 2"></path>
                        </svg>
                        Pages
                    </a>
                </li>
                <li class="admin-sidebar-heading">MESSAGES</li>
                <li>
                    <a href="{{ route('admin.enquiries.index') }}" class="admin-sidebar-item {{ str_contains($currentRoute, 'enquiries') ? $activeClass : $inactiveClass }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M3 8a2 2 0 012-2h16a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8"></path>
                        </svg>
                        <span>Enquiries</span>
                        @php($unreadEnquiryCount = \App\Models\Enquiry::whereNull('read_at')->count())
                        @if($unreadEnquiryCount > 0)
                            <span class="admin-nav-badge">{{ $unreadEnquiryCount > 99 ? '99+' : $unreadEnquiryCount }}</span>
                        @endif
                    </a>
                </li>
                <li class="admin-sidebar-heading">SITE APPEARANCE</li>
                <li>
                    <a href="{{ route('admin.navigation.index') }}" class="admin-sidebar-item {{ str_contains($currentRoute, 'navigation') ? $activeClass : $inactiveClass }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                        Navigation
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.footer.widgets.index') }}" class="admin-sidebar-item {{ str_contains($currentRoute, 'footer') ? $activeClass : $inactiveClass }}">
                        <svg class="admin-sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5h16M4 12h16M4 19h16"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 3-4 2 4 2m8 3 4 2-4 2m-8 3-4 2 4 2"></path>
                        </svg>
                        Footer
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.work-processes.index') }}" class="admin-sidebar-item {{ str_contains($currentRoute, 'work-processes') ? $activeClass : $inactiveClass }}">
                        <svg class="admin-sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01"></path>
                        </svg>
                        Work Process
                    </a>
                </li>
                <li class="admin-sidebar-heading">PREFERENCES</li>
                <li>
                    <a href="{{ route('admin.settings.index') }}" class="admin-sidebar-item {{ str_contains($currentRoute, 'settings') ? $activeClass : $inactiveClass }}">
                        <svg class="admin-sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <circle cx="12" cy="12" r="3"></circle>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19.4 15 .1.1a1.7 1.7 0 1 1-2.4 2.4l-.1-.1a1.7 1.7 0 0 0-2.9 1.2v.3a1.7 1.7 0 1 1-3.4 0v-.2a1.7 1.7 0 0 0-2.9-1.2l-.1.1a1.7 1.7 0 1 1-2.4-2.4l.1-.1a1.7 1.7 0 0 0-1.2-2.9h-.3a1.7 1.7 0 1 1 0-3.4h.2a1.7 1.7 0 0 0 1.2-2.9l-.1-.1a1.7 1.7 0 1 1 2.4-2.4l.1.1a1.7 1.7 0 0 0 2.9-1.2v-.3a1.7 1.7 0 1 1 3.4 0v.2a1.7 1.7 0 0 0 2.9 1.2l.1-.1a1.7 1.7 0 1 1 2.4 2.4l-.1.1a1.7 1.7 0 0 0 1.2 2.9h.3a1.7 1.7 0 1 1 0 3.4h-.2a1.7 1.7 0 0 0-1.2 2.9Z"></path>
                        </svg>
                        Settings
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.seo.edit') }}" class="admin-sidebar-item {{ str_contains($currentRoute, 'seo') ? $activeClass : $inactiveClass }}">
                        <svg class="admin-sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <circle cx="11" cy="11" r="7"></circle>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m20 20-4-4M8.5 11h5M11 8.5v5"></path>
                        </svg>
                        SEO
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.maintenance.edit') }}" class="admin-sidebar-item {{ str_contains($currentRoute, 'maintenance') ? $activeClass : $inactiveClass }}">
                        <svg class="admin-sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v2m0 14v2m9-9h-2M5 12H3m15.4 6.4-1.4-1.4M7 7 5.6 5.6m12.8 0L17 7M7 17l-1.4 1.4"></path>
                            <circle cx="12" cy="12" r="4"></circle>
                        </svg>
                        Maintenance
                    </a>
                </li>
            </ul>
        </nav>

        <div class="border-t border-[#E7EBE8] p-3">
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="admin-sidebar-item w-full text-red-600 hover:bg-red-50">
                    <svg class="admin-sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 17l5-5-5-5M15 12H3m9-9h6a3 3 0 0 1 3 3v12a3 3 0 0 1-3 3h-6"></path>
                    </svg>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <main class="min-w-0 flex-1">
        <header class="sticky top-0 z-30 flex min-h-[72px] items-center justify-between border-b border-[#E7EBE8] bg-white/95 px-4 backdrop-blur sm:px-6 lg:px-8">
            <div class="flex min-w-0 items-center gap-3">
                <button type="button" @click="sidebarOpen = true" class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-gray-200 text-gray-600 hover:bg-gray-50 lg:hidden" aria-label="Open navigation">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                <div class="min-w-0">
                    <p class="hidden text-xs font-medium uppercase tracking-[0.14em] text-[#84908A] sm:block">Portfolio / Admin</p>
                    <h1 class="truncate text-lg font-semibold text-gray-900 sm:text-xl">@yield('header', 'Admin Panel')</h1>
                </div>
            </div>
            <div class="flex shrink-0 items-center gap-2 sm:gap-4">
                <a href="{{ route('home') }}" target="_blank"
                   rel="noopener noreferrer"
                   class="inline-flex items-center gap-1.5 rounded-xl border border-emerald-200 bg-emerald-50/80 px-3 py-2 text-xs font-semibold text-emerald-800 transition-colors hover:bg-emerald-100 sm:text-sm">
                    <svg class="w-4 h-4 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                    </svg>
                    <span class="hidden sm:inline">View Website</span>
                </a>
                <div class="hidden h-8 w-px bg-slate-200 sm:block"></div>
                <div class="flex items-center gap-2">
                    <span class="hidden max-w-32 truncate text-sm font-medium text-slate-700 md:block">{{ Auth::user()?->name ?? 'Admin' }}</span>
                    <div class="flex h-9 w-9 items-center justify-center rounded-full bg-gradient-to-br from-emerald-600 to-teal-600 text-xs font-bold text-white shadow-xs">
                        {{ substr(Auth::user()?->name ?? 'Admin', 0, 1) }}
                    </div>
                </div>
            </div>
        </header>
        <div class="admin-content-wrap px-4 py-6 sm:px-6 lg:px-8 lg:py-8">
            @yield('admin-content')
        </div>
    </main>
</div>
@endsection
