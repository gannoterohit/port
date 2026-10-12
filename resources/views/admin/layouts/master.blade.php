@extends('admin.layouts.app')

@section('content')
<div class="flex h-screen overflow-hidden">
    @php
        $currentRoute = request()->route()->getName();
        $activeClass = 'bg-blue-100 text-blue-700 font-semibold';
        $inactiveClass = 'text-gray-600 hover:bg-gray-100';
    @endphp

    <aside class="w-64 bg-white border-r border-gray-200 flex flex-col overflow-y-auto">
        <div class="p-4 border-b border-gray-200">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center text-white font-bold">
                    {{ substr(\App\Models\Setting::get('website_name', 'CMS'), 0, 1) }}
                </div>
                <div>
                    <span class="font-bold text-lg">{{ \App\Models\Setting::get('website_name', 'Portfolio CMS') }}</span>
                    <span class="text-xs text-gray-500 block">Admin Panel</span>
                </div>
            </div>
        </div>

        <nav class="flex-1 p-3">
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="admin-sidebar-item {{ $currentRoute === 'admin.dashboard' ? $activeClass : $inactiveClass }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V7"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a4 4 0 018 0v5.172a1 1 0 01-.337.727l-2 1.5a1 1 0 01-1.326-1.454V7a2 2 0 10-4 0v6.286a1 1 0 01-1.326 1.454l-2-1.5A1 1 0 015 12.172V7"></path>
                        </svg>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.profile.edit') }}" class="admin-sidebar-item {{ str_contains($currentRoute, 'profile') ? $activeClass : $inactiveClass }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Profile & About
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.homepage.edit') }}" class="admin-sidebar-item {{ str_contains($currentRoute, 'homepage') ? $activeClass : $inactiveClass }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2v8a2 2 0 002 2h10a2 2 0 002-2V10l2-2"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12V2h14v10"></path>
                        </svg>
                        Homepage
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.skills.index') }}" class="admin-sidebar-item {{ str_contains($currentRoute, 'skills') ? $activeClass : $inactiveClass }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.983 3C6.45 4.15 2 9.05 2 15v5l3-3 7-1 7 1 7 3v-5c0-5.95-4.45-10.85-10-12z"></path>
                        </svg>
                        Skills
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.skill-categories.index') }}" class="admin-sidebar-item {{ str_contains($currentRoute, 'skill-categories') ? $activeClass : $inactiveClass }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7l10 10M7 7l10 10M7 7l10 10"></path>
                        </svg>
                        Skill Categories
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.projects.index') }}" class="admin-sidebar-item {{ str_contains($currentRoute, 'projects') ? $activeClass : $inactiveClass }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11V9a6 6 0 00-6-6H8a6 6 0 00-6 6v6l2 2v4a2 2 0 002 2h8a2 2 0 002-2v-4l2-2z"></path>
                        </svg>
                        Projects
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.services.index') }}" class="admin-sidebar-item {{ str_contains($currentRoute, 'services') ? $activeClass : $inactiveClass }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.27V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2h12.59l-2.7 2.7a1 1 0 00.7 1.7h3.07a2 2 0 002-2v-4.73"></path>
                        </svg>
                        Services
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.testimonials.index') }}" class="admin-sidebar-item {{ str_contains($currentRoute, 'testimonials') ? $activeClass : $inactiveClass }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l3 3v1a6 6 0 01-3-3V9z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4v4a4 4 0 10-8 0V7"></path>
                        </svg>
                        Testimonials
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.pages.index') }}" class="admin-sidebar-item {{ str_contains($currentRoute, 'pages') ? $activeClass : $inactiveClass }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6M9 12l2-2M9 12l2 2"></path>
                        </svg>
                        Pages
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.enquiries.index') }}" class="admin-sidebar-item {{ str_contains($currentRoute, 'enquiries') ? $activeClass : $inactiveClass }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M3 8a2 2 0 012-2h16a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8"></path>
                        </svg>
                        Enquiries ({{ \App\Models\Enquiry::whereNull('read_at')->count() }})
                    </a>
                </li>
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
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 Mui7v10M8 7l4 4m-4 0l4-4m-4 4h8a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V7a2 2 0 012-2h8a2 2 0 012 2v4"></path>
                        </svg>
                        Footer
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.work-processes.index') }}" class="admin-sidebar-item {{ str_contains($currentRoute, 'work-processes') ? $activeClass : $inactiveClass }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-2-2m0 0l-2 2m4 0V7m-2 8l-2-2m0 0l2-2m2-2h2a2 2 0 110 4h-2"></path>
                        </svg>
                        Work Process
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.settings.index') }}" class="admin-sidebar-item {{ str_contains($currentRoute, 'settings') ? $activeClass : $inactiveClass }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.717c.05.05.1.097.215.21l3.558 3.558a.05.05 0 01.042.044v2.705a.05.05 0 01-.032.047l-2.705 2.212a.05.05 0 01-.056-.018 4.747 4.747 0 01-2.55-5.12 4.747 4.747 0 01.57-1.47z"></path>
                        </svg>
                        Settings
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.seo.edit') }}" class="admin-sidebar-item {{ str_contains($currentRoute, 'seo') ? $activeClass : $inactiveClass }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 11-9 9 9 9 0 019-9z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 10a3 3 0 116 0 3 3 0 01-6 0z"></path>
                        </svg>
                        SEO
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.maintenance.edit') }}" class="admin-sidebar-item {{ str_contains($currentRoute, 'maintenance') ? $activeClass : $inactiveClass }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.983 3C6.45 4.15 2 9.05 2 15v5l3-3 7-1 7 1 7 3v-5c0-5.95-4.45-10.85-10-12z"></path>
                        </svg>
                        Maintenance
                    </a>
                </li>
            </ul>
        </nav>

        <div class="p-4 border-t border-gray-200">
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="w-full admin-sidebar-item text-red-600 hover:bg-red-50">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 11-12 0v-1m12-4v1a2 2 0 11-12 0v-1"></path>
                    </svg>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 overflow-y-auto">
        <header class="bg-white border-b border-gray-200 px-6 py-4 flex justify-between items-center">
            <h1 class="text-xl font-semibold text-gray-900">@yield('header', 'Admin Panel')</h1>
            <div class="flex items-center gap-3">
                <span class="text-sm text-gray-600">{{ Auth::user()->name }}</span>
                <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center">
                    {{ Auth::user()->name ? substr(Auth::user()->name, 0, 1) : 'A' }}
                </div>
            </div>
        </header>
        <div class="p-6">
            @yield('admin-content')
        </div>
    </main>
</div>
@endsection
