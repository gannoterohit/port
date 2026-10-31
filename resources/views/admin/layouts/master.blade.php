@extends('admin.layouts.app')

@section('content')
<div class="min-h-screen bg-[#F8F7F4] text-[#18191B] lg:flex" x-data="{ sidebarOpen: false }" @keydown.escape.window="sidebarOpen = false">
    @php
        $currentRoute = request()->route()?->getName() ?? '';
        $activeClass = 'admin-sidebar-item-active';
        $inactiveClass = 'admin-sidebar-item-inactive';
        $isMaintenance = \App\Models\Setting::get('maintenance_mode', '0') === '1';
        $unreadEnquiryCount = \App\Models\Enquiry::whereNull('read_at')->count();
        $todayVisitsCount = \App\Models\VisitorLog::whereDate('created_at', today())->count();
    @endphp

    <!-- Mobile Drawer Backdrop -->
    <div x-cloak x-show="sidebarOpen" x-transition.opacity @click="sidebarOpen = false"
        class="fixed inset-0 z-40 bg-black/75 backdrop-blur-xs lg:hidden" aria-hidden="true"></div>

    <!-- Sidebar Navigation (SaaS Dark Obsidian Slate with Section Containers) -->
    <aside
        class="fixed inset-y-0 left-0 z-50 flex w-[min(86vw,290px)] flex-col border-r border-[#26282E] bg-[#141517] shadow-2xl transition-transform duration-200 lg:sticky lg:top-0 lg:z-auto lg:h-screen lg:w-[276px] lg:shrink-0 lg:translate-x-0 lg:shadow-none"
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        aria-label="Admin sidebar">
        
        <!-- Brand Header -->
        <div class="flex min-h-[72px] items-center justify-between border-b border-[#26282E] px-4 bg-[#111214]">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 group">
                <div class="relative flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-[#B85D19] to-[#8C410B] text-white font-extrabold shadow-md shadow-[#B85D19]/25 border border-[#D9772B]/30 transition-transform group-hover:scale-105">
                    {{ substr(\App\Models\Setting::get('website_name', 'CMS'), 0, 1) }}
                    <span class="absolute -bottom-0.5 -right-0.5 w-2.5 h-2.5 rounded-full {{ $isMaintenance ? 'bg-amber-400 ring-2 ring-[#111214]' : 'bg-emerald-400 ring-2 ring-[#111214]' }}"></span>
                </div>
                <div class="min-w-0">
                    <span class="block truncate text-sm font-bold text-white group-hover:text-[#FF9E54] transition-colors leading-snug">
                        {{ \App\Models\Setting::get('website_name', 'Portfolio CMS') }}
                    </span>
                    <div class="flex items-center gap-1.5 mt-0.5">
                        <span class="inline-block w-1.5 h-1.5 rounded-full {{ $isMaintenance ? 'bg-amber-400 animate-pulse' : 'bg-emerald-400' }}"></span>
                        <span class="text-[10px] font-mono font-bold tracking-wider text-[#8A8D96] uppercase">
                            {{ $isMaintenance ? 'Maintenance Active' : 'SaaS Console' }}
                        </span>
                    </div>
                </div>
            </a>
            <button type="button" @click="sidebarOpen = false" class="rounded-lg p-1.5 text-[#82848C] hover:bg-[#25272B] hover:text-white lg:hidden cursor-pointer" aria-label="Close navigation">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Grouped Navigation Links -->
        <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-4 custom-dark-scrollbar" @click="sidebarOpen = false">
            
            <!-- ==========================================
                 SECTION 1: OVERVIEW & ANALYTICS
                 ========================================== -->
            <div class="space-y-1.5">
                <div class="flex items-center justify-between px-2.5">
                    <span class="text-[10px] font-mono font-extrabold tracking-wider uppercase text-[#888A92] flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#B85D19]"></span>
                        Overview &amp; Metrics
                    </span>
                </div>
                <div class="rounded-xl bg-[#1A1C20]/70 p-1 border border-[#27292F] space-y-0.5 shadow-xs">
                    <a href="{{ route('admin.dashboard') }}" class="admin-sidebar-item {{ $currentRoute === 'admin.dashboard' ? $activeClass : $inactiveClass }}">
                        <svg class="admin-sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z"></path>
                        </svg>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('admin.analytics.index') }}" class="admin-sidebar-item {{ str_contains($currentRoute, 'analytics') ? $activeClass : $inactiveClass }}">
                        <svg class="admin-sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z"></path>
                        </svg>
                        <span class="flex-1">Visitor Traffic</span>
                        @if($todayVisitsCount > 0)
                            <span class="admin-nav-badge !bg-emerald-500/20 !text-emerald-300 !border !border-emerald-500/30">+{{ $todayVisitsCount }}</span>
                        @endif
                    </a>
                </div>
            </div>

            <!-- ==========================================
                 SECTION 2: WORK & SHOWCASE
                 ========================================== -->
            <div class="space-y-1.5">
                <div class="flex items-center justify-between px-2.5">
                    <span class="text-[10px] font-mono font-extrabold tracking-wider uppercase text-[#888A92] flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#3B82F6]"></span>
                        Work &amp; Showcase
                    </span>
                    <span class="text-[9px] font-mono text-[#6C6F78] px-1.5 py-0.2 rounded bg-[#1B1D21] border border-[#27292F]">5 items</span>
                </div>
                <div class="rounded-xl bg-[#1A1C20]/70 p-1 border border-[#27292F] space-y-0.5 shadow-xs">
                    <a href="{{ route('admin.projects.index') }}" class="admin-sidebar-item {{ str_contains($currentRoute, 'projects') ? $activeClass : $inactiveClass }}">
                        <svg class="admin-sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 0 1 4.5 9.75h15A2.25 2.25 0 0 1 21.75 12v.75m-8.69-6.44-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z"></path>
                        </svg>
                        <span>Projects Showcase</span>
                    </a>
                    <a href="{{ route('admin.services.index') }}" class="admin-sidebar-item {{ str_contains($currentRoute, 'services') ? $activeClass : $inactiveClass }}">
                        <svg class="admin-sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9"></path>
                        </svg>
                        <span>Services &amp; Packages</span>
                    </a>
                    <a href="{{ route('admin.skills.index') }}" class="admin-sidebar-item {{ str_contains($currentRoute, 'skills') || str_contains($currentRoute, 'skill-categories') ? $activeClass : $inactiveClass }}">
                        <svg class="admin-sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 6.75 22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3-4.5 16.5"></path>
                        </svg>
                        <span>Skills &amp; Stacks</span>
                    </a>
                    <a href="{{ route('admin.experiences.index') }}" class="admin-sidebar-item {{ str_contains($currentRoute, 'experiences') ? $activeClass : $inactiveClass }}">
                        <svg class="admin-sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z"></path>
                        </svg>
                        <span>Work Experience</span>
                    </a>
                    <a href="{{ route('admin.testimonials.index') }}" class="admin-sidebar-item {{ str_contains($currentRoute, 'testimonials') ? $activeClass : $inactiveClass }}">
                        <svg class="admin-sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.502 49.188 49.188 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z"></path>
                        </svg>
                        <span>Client Testimonials</span>
                    </a>
                </div>
            </div>

            <!-- ==========================================
                 SECTION 3: CONTENT & BIO
                 ========================================== -->
            <div class="space-y-1.5">
                <div class="flex items-center justify-between px-2.5">
                    <span class="text-[10px] font-mono font-extrabold tracking-wider uppercase text-[#888A92] flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#10B981]"></span>
                        Content &amp; Identity
                    </span>
                    <span class="text-[9px] font-mono text-[#6C6F78] px-1.5 py-0.2 rounded bg-[#1B1D21] border border-[#27292F]">4 items</span>
                </div>
                <div class="rounded-xl bg-[#1A1C20]/70 p-1 border border-[#27292F] space-y-0.5 shadow-xs">
                    <a href="{{ route('admin.profile.edit') }}" class="admin-sidebar-item {{ str_contains($currentRoute, 'profile') ? $activeClass : $inactiveClass }}">
                        <svg class="admin-sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"></path>
                        </svg>
                        <span>Profile &amp; Biography</span>
                    </a>
                    <a href="{{ route('admin.homepage.edit') }}" class="admin-sidebar-item {{ str_contains($currentRoute, 'homepage') ? $activeClass : $inactiveClass }}">
                        <svg class="admin-sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"></path>
                        </svg>
                        <span>Homepage Layout</span>
                    </a>
                    <a href="{{ route('admin.work-processes.index') }}" class="admin-sidebar-item {{ str_contains($currentRoute, 'work-processes') ? $activeClass : $inactiveClass }}">
                        <svg class="admin-sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"></path>
                        </svg>
                        <span>Delivery Workflow</span>
                    </a>
                    <a href="{{ route('admin.pages.index') }}" class="admin-sidebar-item {{ str_contains($currentRoute, 'pages') ? $activeClass : $inactiveClass }}">
                        <svg class="admin-sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"></path>
                        </svg>
                        <span>Custom Pages</span>
                    </a>
                </div>
            </div>

            <!-- ==========================================
                 SECTION 4: COMMUNICATIONS
                 ========================================== -->
            <div class="space-y-1.5">
                <div class="flex items-center justify-between px-2.5">
                    <span class="text-[10px] font-mono font-extrabold tracking-wider uppercase text-[#888A92] flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#F59E0B]"></span>
                        Communications
                    </span>
                    @if($unreadEnquiryCount > 0)
                        <span class="text-[9px] font-mono font-bold text-white px-2 py-0.5 rounded-full bg-[#B85D19] shadow-xs">
                            {{ $unreadEnquiryCount }} new
                        </span>
                    @endif
                </div>
                <div class="rounded-xl bg-[#1A1C20]/70 p-1 border border-[#27292F] space-y-0.5 shadow-xs">
                    <a href="{{ route('admin.enquiries.index') }}" class="admin-sidebar-item {{ str_contains($currentRoute, 'enquiries') ? $activeClass : $inactiveClass }}">
                        <svg class="admin-sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75"></path>
                        </svg>
                        <span class="flex-1">Client Inquiries</span>
                        @if($unreadEnquiryCount > 0)
                            <span class="admin-nav-badge">{{ $unreadEnquiryCount > 99 ? '99+' : $unreadEnquiryCount }}</span>
                        @endif
                    </a>
                </div>
            </div>

            <!-- ==========================================
                 SECTION 5: SYSTEM & SETTINGS
                 ========================================== -->
            <div class="space-y-1.5">
                <div class="flex items-center justify-between px-2.5">
                    <span class="text-[10px] font-mono font-extrabold tracking-wider uppercase text-[#888A92] flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#8B5CF6]"></span>
                        System &amp; Settings
                    </span>
                    <span class="text-[9px] font-mono text-[#6C6F78] px-1.5 py-0.2 rounded bg-[#1B1D21] border border-[#27292F]">6 items</span>
                </div>
                <div class="rounded-xl bg-[#1A1C20]/70 p-1 border border-[#27292F] space-y-0.5 shadow-xs">
                    <a href="{{ route('admin.settings.index') }}" class="admin-sidebar-item {{ str_contains($currentRoute, 'settings') ? $activeClass : $inactiveClass }}">
                        <svg class="admin-sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 0 1 0 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 0 1 0-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281Z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"></path>
                        </svg>
                        <span>Site Configuration</span>
                    </a>
                    <a href="{{ route('admin.navigation.index') }}" class="admin-sidebar-item {{ str_contains($currentRoute, 'navigation') ? $activeClass : $inactiveClass }}">
                        <svg class="admin-sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25H12"></path>
                        </svg>
                        <span>Header Navbar</span>
                    </a>
                    <a href="{{ route('admin.footer.widgets.index') }}" class="admin-sidebar-item {{ str_contains($currentRoute, 'footer') ? $activeClass : $inactiveClass }}">
                        <svg class="admin-sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 0 1 1.242 7.244l-4.5 4.5a4.5 4.5 0 0 1-6.364-6.364l1.757-1.757m13.35-.622 1.757-1.757a4.5 4.5 0 0 0-6.364-6.364l-4.5 4.5a4.5 4.5 0 0 0 1.242 7.244"></path>
                        </svg>
                        <span>Footer &amp; Links</span>
                    </a>
                    <a href="{{ route('admin.seo.edit') }}" class="admin-sidebar-item {{ str_contains($currentRoute, 'seo') ? $activeClass : $inactiveClass }}">
                        <svg class="admin-sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607ZM10.5 7.5v6m3-3h-6"></path>
                        </svg>
                        <span>SEO &amp; Tracking</span>
                    </a>
                    <a href="{{ route('admin.sitemap') }}" class="admin-sidebar-item {{ str_contains($currentRoute, 'sitemap') ? $activeClass : $inactiveClass }}">
                        <svg class="admin-sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.333A12.018 12.018 0 0 0 12 9c-2.475 0-4.804.75-6.75 2.033V21"></path>
                        </svg>
                        <span>Sitemap Index</span>
                    </a>
                    <a href="{{ route('admin.maintenance.edit') }}" class="admin-sidebar-item {{ str_contains($currentRoute, 'maintenance') ? $activeClass : $inactiveClass }}">
                        <svg class="admin-sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17 17.25 21A2.652 2.652 0 0 0 21 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 1 1-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 0 0 4.486-6.32l-3.276 3.277a3.004 3.004 0 0 1-2.25-2.25l3.276-3.276a4.5 4.5 0 0 0-6.32 4.486c.091.762.077 1.535-.14 2.274l-4.5 4.5"></path>
                        </svg>
                        <span class="flex-1">Maintenance</span>
                        <span class="inline-flex h-2 w-2 rounded-full {{ $isMaintenance ? 'bg-amber-400 animate-ping' : 'bg-emerald-400' }}"></span>
                    </a>
                </div>
            </div>

        </nav>

        <!-- Bottom User Card & Logout -->
        <div class="border-t border-[#26282E] p-3 bg-[#101113]">
            <div class="flex items-center justify-between gap-3 p-2.5 rounded-xl bg-[#18191C] border border-[#2A2C32] shadow-xs">
                <div class="flex items-center gap-2.5 min-w-0">
                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-gradient-to-br from-[#B85D19] to-[#8C410B] text-xs font-bold text-white shadow-xs">
                        {{ substr(Auth::user()?->name ?? 'Admin', 0, 1) }}
                    </div>
                    <div class="min-w-0">
                        <p class="truncate text-xs font-bold text-white leading-tight">{{ Auth::user()?->name ?? 'Administrator' }}</p>
                        <p class="truncate text-[10px] text-[#8E909A] font-mono">Superadmin</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('admin.logout') }}" class="shrink-0">
                    @csrf
                    <button type="submit" class="p-1.5 text-[#8E909A] hover:text-rose-400 hover:bg-rose-500/10 rounded-lg transition-colors cursor-pointer" title="Sign out of Admin">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9"></path>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Main Workspace -->
    <main class="min-w-0 flex-1 flex flex-col">
        <!-- Modern Topbar -->
        <header class="sticky top-0 z-30 flex min-h-[64px] items-center justify-between border-b border-[#E5E0D5] bg-white/90 px-4 backdrop-blur-md sm:px-6 lg:px-8 shadow-2xs">
            <div class="flex min-w-0 items-center gap-3">
                <button type="button" @click="sidebarOpen = true" class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-xl border border-stone-200 text-stone-600 hover:bg-stone-50 lg:hidden cursor-pointer" aria-label="Open navigation">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25H12"></path>
                    </svg>
                </button>
                
                <div class="flex items-center gap-2 min-w-0">
                    <a href="{{ route('admin.dashboard') }}" class="hidden sm:inline-flex text-xs font-semibold text-stone-400 hover:text-stone-700 transition">Console</a>
                    <span class="hidden sm:inline-block text-stone-300 text-xs">/</span>
                    <h1 class="truncate text-base font-bold text-stone-900 sm:text-lg">@yield('header', 'Dashboard')</h1>
                </div>
            </div>

            <!-- Header Actions -->
            <div class="flex shrink-0 items-center gap-2.5 sm:gap-4">
                <!-- System Status Indicator -->
                <div class="hidden md:inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold border {{ $isMaintenance ? 'bg-amber-50 text-amber-800 border-amber-200' : 'bg-emerald-50 text-emerald-800 border-emerald-200' }}">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full {{ $isMaintenance ? 'bg-amber-400' : 'bg-emerald-400' }} opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 {{ $isMaintenance ? 'bg-amber-500' : 'bg-emerald-500' }}"></span>
                    </span>
                    <span>{{ $isMaintenance ? 'Maintenance Active' : 'System Live' }}</span>
                </div>

                <!-- View Public Website Button -->
                <a href="{{ route('home') }}" target="_blank" rel="noopener noreferrer"
                   class="inline-flex items-center gap-1.5 rounded-xl border border-[#E5E0D5] bg-[#FAF9F5] px-3.5 py-1.5 text-xs font-semibold text-stone-700 transition-all hover:bg-white hover:border-stone-400 hover:text-[#B85D19] shadow-2xs">
                    <svg class="w-3.5 h-3.5 text-[#B85D19]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"></path>
                    </svg>
                    <span class="hidden sm:inline">View Live Site</span>
                </a>
            </div>
        </header>

        <!-- Dynamic Content Body -->
        <div class="admin-content-wrap flex-1 px-4 py-6 sm:px-6 lg:px-8 lg:py-7">
            @yield('admin-content')
        </div>
    </main>
</div>
@endsection
