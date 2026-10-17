@extends('admin.layouts.master')

@section('title', 'Website Settings')
@section('header', 'Website & Portfolio Settings')

@section('admin-content')
@php
    $byKey = $settings->keyBy('key');
@endphp

<div x-data="{
    activeTab: window.location.hash ? window.location.hash.replace('#', '') : 'general',
    saved: false,
    setActive(tab) {
        this.activeTab = tab;
        window.location.hash = tab;
    }
}" @keydown.window.ctrl.s.prevent="$refs.settingsForm.submit()" @keydown.window.meta.s.prevent="$refs.settingsForm.submit()" class="space-y-6">

    <!-- Top Header Card -->
    <div class="flex flex-col gap-4 rounded-2xl border border-[#E5E1D5] bg-gradient-to-br from-white to-[#FAF9F5] p-5 shadow-xs sm:flex-row sm:items-center sm:justify-between sm:p-6">
        <div>
            <div class="flex items-center gap-2">
                <span class="inline-flex h-2 w-2 rounded-full bg-[#B85D19] animate-pulse"></span>
                <p class="text-xs font-mono font-bold uppercase tracking-wider text-[#B85D19]">Configuration Console</p>
            </div>
            <h2 class="mt-1 text-xl font-bold tracking-tight text-stone-900 sm:text-2xl">Manage Site &amp; Portfolio Settings</h2>
            <p class="mt-1 text-xs text-stone-500 sm:text-sm">Customize your website branding, contact methods, portfolio metrics, social profiles and SMTP credentials.</p>
        </div>
        <div class="flex items-center gap-2.5">
            <button type="button" @click="$refs.settingsForm.submit()" class="admin-btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>Save All Settings</span>
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
            <svg class="h-5 w-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="rounded-xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-800">
            <p class="font-bold">Please check the errors below:</p>
            <ul class="mt-1 list-disc list-inside space-y-0.5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form x-ref="settingsForm" method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-12">
            <!-- Left Tabs Navigation -->
            <div class="lg:col-span-4 xl:col-span-3">
                <div class="sticky top-24 space-y-1.5 rounded-2xl border border-[#E5E1D5] bg-white p-3 shadow-xs">
                    <p class="px-3 pb-2 pt-1 text-[11px] font-bold uppercase tracking-wider text-stone-400">Settings Categories</p>

                    <button type="button" @click="setActive('general')" :class="activeTab === 'general' ? 'admin-tab-btn-active' : 'admin-tab-btn-inactive'" class="admin-tab-btn">
                        <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        <div class="min-w-0 flex-1 text-left">
                            <div class="text-sm font-semibold">Branding &amp; Identity</div>
                            <div class="truncate text-[11px] text-stone-400">Name, logo, favicon, footer</div>
                        </div>
                    </button>

                    <button type="button" @click="setActive('contact')" :class="activeTab === 'contact' ? 'admin-tab-btn-active' : 'admin-tab-btn-inactive'" class="admin-tab-btn">
                        <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        <div class="min-w-0 flex-1 text-left">
                            <div class="text-sm font-semibold">Contact &amp; Location</div>
                            <div class="truncate text-[11px] text-stone-400">Email, phone, whatsapp, city</div>
                        </div>
                    </button>

                    <button type="button" @click="setActive('portfolio')" :class="activeTab === 'portfolio' ? 'admin-tab-btn-active' : 'admin-tab-btn-inactive'" class="admin-tab-btn">
                        <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        <div class="min-w-0 flex-1 text-left">
                            <div class="text-sm font-semibold">Portfolio Metrics</div>
                            <div class="truncate text-[11px] text-stone-400">Experience, badge, stats</div>
                        </div>
                    </button>

                    <button type="button" @click="setActive('social')" :class="activeTab === 'social' ? 'admin-tab-btn-active' : 'admin-tab-btn-inactive'" class="admin-tab-btn">
                        <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                        </svg>
                        <div class="min-w-0 flex-1 text-left">
                            <div class="text-sm font-semibold">Social Profiles</div>
                            <div class="truncate text-[11px] text-stone-400">GitHub, LinkedIn, Twitter/X</div>
                        </div>
                    </button>

                    <button type="button" @click="setActive('seo')" :class="activeTab === 'seo' ? 'admin-tab-btn-active' : 'admin-tab-btn-inactive'" class="admin-tab-btn">
                        <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <div class="min-w-0 flex-1 text-left">
                            <div class="text-sm font-semibold">SEO &amp; Metadata</div>
                            <div class="truncate text-[11px] text-stone-400">Meta tags, OG image, sitemap</div>
                        </div>
                    </button>

                    <button type="button" @click="setActive('email')" :class="activeTab === 'email' ? 'admin-tab-btn-active' : 'admin-tab-btn-inactive'" class="admin-tab-btn">
                        <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 01-2-2v12a2 2 0 002 2z"></path>
                        </svg>
                        <div class="min-w-0 flex-1 text-left">
                            <div class="text-sm font-semibold">Email &amp; SMTP</div>
                            <div class="truncate text-[11px] text-stone-400">Mailer, host, notifications</div>
                        </div>
                    </button>

                    <button type="button" @click="setActive('maintenance')" :class="activeTab === 'maintenance' ? 'admin-tab-btn-active' : 'admin-tab-btn-inactive'" class="admin-tab-btn">
                        <svg class="h-5 w-5 shrink-0 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        <div class="min-w-0 flex-1 text-left">
                            <div class="text-sm font-semibold">Maintenance Mode</div>
                            <div class="truncate text-[11px] text-stone-400">Lock site for visitors</div>
                        </div>
                    </button>
                </div>
            </div>

            <!-- Right Content Panels -->
            <div class="lg:col-span-8 xl:col-span-9 space-y-6">

                <!-- TAB 1: BRANDING & GENERAL -->
                <div x-show="activeTab === 'general'" x-cloak class="space-y-6">
                    <div class="admin-form-card">
                        <div class="admin-form-header">
                            <h3 class="text-base font-bold text-stone-900">Branding &amp; Identity</h3>
                            <p class="text-xs text-stone-500">Configure your website name, logo, favicon and general meta information.</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wider text-stone-600 mb-1.5">Website / Brand Name *</label>
                                <input type="text" name="website_name" value="{{ old('website_name', $byKey['website_name']->value ?? '') }}" class="admin-input" placeholder="e.g. Rohit Gannote">
                                <p class="text-[11px] text-stone-400 mt-1">Displayed in the header, footer, and browser title bar.</p>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wider text-stone-600 mb-1.5">Site Tagline / Headline</label>
                                <input type="text" name="site_description" value="{{ old('site_description', $byKey['site_description']->value ?? '') }}" class="admin-input" placeholder="e.g. Full Stack Web Developer | Laravel &amp; MySQL Specialist">
                                <p class="text-[11px] text-stone-400 mt-1">Short subtitle used across metadata and hero subtitles.</p>
                            </div>

                            <!-- Logo Upload -->
                            <div class="rounded-xl border border-[#E5E1D5] bg-[#FAF9F5] p-4">
                                <label class="block text-xs font-semibold uppercase tracking-wider text-stone-600 mb-2">Website Logo</label>
                                <div class="flex items-center gap-4">
                                    @if(!empty($byKey['website_logo']->value))
                                        <div class="h-14 w-14 rounded-xl border border-[#E5E1D5] bg-white p-2 flex items-center justify-center shrink-0 shadow-xs">
                                            <img src="{{ asset('storage/' . $byKey['website_logo']->value) }}" alt="Logo" class="max-h-full max-w-full object-contain">
                                        </div>
                                    @else
                                        <div class="h-14 w-14 rounded-xl border border-dashed border-stone-300 bg-white flex items-center justify-center shrink-0 text-stone-400 text-xs">
                                            No Logo
                                        </div>
                                    @endif
                                    <div class="flex-1 min-w-0">
                                        <input type="file" name="website_logo" accept="image/*" class="admin-input text-xs">
                                        <p class="text-[11px] text-stone-400 mt-1">PNG, SVG or WEBP with transparent background.</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Favicon Upload -->
                            <div class="rounded-xl border border-[#E5E1D5] bg-[#FAF9F5] p-4">
                                <label class="block text-xs font-semibold uppercase tracking-wider text-stone-600 mb-2">Browser Favicon</label>
                                <div class="flex items-center gap-4">
                                    @if(!empty($byKey['website_favicon']->value))
                                        <div class="h-14 w-14 rounded-xl border border-[#E5E1D5] bg-white p-2 flex items-center justify-center shrink-0 shadow-xs">
                                            <img src="{{ asset('storage/' . $byKey['website_favicon']->value) }}" alt="Favicon" class="max-h-full max-w-full object-contain">
                                        </div>
                                    @else
                                        <div class="h-14 w-14 rounded-xl border border-dashed border-stone-300 bg-white flex items-center justify-center shrink-0 text-stone-400 text-xs">
                                            No Icon
                                        </div>
                                    @endif
                                    <div class="flex-1 min-w-0">
                                        <input type="file" name="website_favicon" accept="image/*" class="admin-input text-xs">
                                        <p class="text-[11px] text-stone-400 mt-1">Square image (32x32px or 64x64px), PNG/ICO.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-xs font-semibold uppercase tracking-wider text-stone-600 mb-1.5">Footer Description / Bio</label>
                                <textarea name="footer_description" rows="3" class="admin-textarea" placeholder="Crafting high-performance web systems and digital experiences.">{{ old('footer_description', $byKey['footer_description']->value ?? '') }}</textarea>
                                <p class="text-[11px] text-stone-400 mt-1">Displayed in the footer column under your logo.</p>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-xs font-semibold uppercase tracking-wider text-stone-600 mb-1.5">Copyright Notice</label>
                                <input type="text" name="copyright_text" value="{{ old('copyright_text', $byKey['copyright_text']->value ?? '') }}" class="admin-input" placeholder="e.g. &copy; {{ date('Y') }} Rohit Gannote. All rights reserved.">
                                <p class="text-[11px] text-stone-400 mt-1">Leave blank to use the automatic copyright statement.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TAB 2: CONTACT & LOCATION -->
                <div x-show="activeTab === 'contact'" x-cloak class="space-y-6">
                    <div class="admin-form-card">
                        <div class="admin-form-header">
                            <h3 class="text-base font-bold text-stone-900">Contact Channels &amp; Location</h3>
                            <p class="text-xs text-stone-500">Provide direct communication links for prospective clients and recruiters.</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wider text-stone-600 mb-1.5">Primary Contact Email *</label>
                                <div class="relative">
                                    <input type="email" name="contact_email" value="{{ old('contact_email', $byKey['contact_email']->value ?? '') }}" class="admin-input pl-10" placeholder="hello@rohitgannote.com">
                                    <svg class="w-4 h-4 text-stone-400 absolute left-3.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 01-2-2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <p class="text-[11px] text-stone-400 mt-1">Used for the "Copy Email" button on the hero and footer.</p>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wider text-stone-600 mb-1.5">Phone Number</label>
                                <div class="relative">
                                    <input type="text" name="contact_phone" value="{{ old('contact_phone', $byKey['contact_phone']->value ?? '') }}" class="admin-input pl-10" placeholder="+91 98765 43210">
                                    <svg class="w-4 h-4 text-stone-400 absolute left-3.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                </div>
                                <p class="text-[11px] text-stone-400 mt-1">Direct call link (optional).</p>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wider text-stone-600 mb-1.5">WhatsApp Number</label>
                                <div class="relative">
                                    <input type="text" name="contact_whatsapp" value="{{ old('contact_whatsapp', $byKey['contact_whatsapp']->value ?? '') }}" class="admin-input pl-10" placeholder="+919876543210 (with country code)">
                                    <svg class="w-4 h-4 text-emerald-600 absolute left-3.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                    </svg>
                                </div>
                                <p class="text-[11px] text-stone-400 mt-1">Opens direct WhatsApp chat.</p>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wider text-stone-600 mb-1.5">Office / Base Location</label>
                                <div class="relative">
                                    <input type="text" name="website_address" value="{{ old('website_address', $byKey['website_address']->value ?? '') }}" class="admin-input pl-10" placeholder="Indore / Bangalore, India">
                                    <svg class="w-4 h-4 text-stone-400 absolute left-3.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                <p class="text-[11px] text-stone-400 mt-1">Displayed in contact details and footer.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TAB 3: PORTFOLIO & METRICS -->
                <div x-show="activeTab === 'portfolio'" x-cloak class="space-y-6">
                    <div class="admin-form-card">
                        <div class="admin-form-header">
                            <h3 class="text-base font-bold text-stone-900">Experience &amp; Portfolio Dynamic Metrics</h3>
                            <p class="text-xs text-stone-500">These values feed directly into the dynamic stat cards on the homepage hero and about sections.</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wider text-stone-600 mb-1.5">Years of Experience *</label>
                                <input type="text" name="years_experience" value="{{ old('years_experience', $byKey['years_experience']->value ?? '2.5+') }}" class="admin-input font-bold" placeholder="e.g. 2.5+">
                                <p class="text-[11px] text-stone-400 mt-1">Shown in the hero metric badge (#1) and about card.</p>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wider text-stone-600 mb-1.5">Specialization Tagline *</label>
                                <input type="text" name="specialization_text" value="{{ old('specialization_text', $byKey['specialization_text']->value ?? 'Laravel & MySQL Specialist') }}" class="admin-input" placeholder="e.g. Laravel &amp; MySQL Specialist">
                                <p class="text-[11px] text-stone-400 mt-1">Featured expertise tagline on the about section.</p>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-xs font-semibold uppercase tracking-wider text-stone-600 mb-1.5">Training / Certifications Badge</label>
                                <input type="text" name="training_text" value="{{ old('training_text', $byKey['training_text']->value ?? '+ 6 Months Intensive Training') }}" class="admin-input" placeholder="e.g. + 6 Months Intensive Training">
                                <p class="text-[11px] text-stone-400 mt-1">Secondary experience badge shown alongside your experience years.</p>
                            </div>

                            <!-- Available for Freelance Switch -->
                            <div class="md:col-span-2 rounded-xl border border-[#E5E1D5] bg-[#FAF9F5] p-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                                <div>
                                    <div class="flex items-center gap-2">
                                        <span class="inline-flex h-2.5 w-2.5 rounded-full bg-emerald-500 animate-ping"></span>
                                        <span class="text-sm font-bold text-stone-900">"Available for Work" Live Status Badge</span>
                                    </div>
                                    <p class="text-xs text-stone-500 mt-0.5">Displays a pulsing live green badge in the header and hero indicating active project availability.</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer shrink-0">
                                    <input type="checkbox" name="available_for_freelance" value="1" {{ ($byKey['available_for_freelance']->value ?? '1') == '1' ? 'checked' : '' }} class="sr-only peer">
                                    <div class="w-11 h-6 bg-stone-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-stone-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#B85D19]"></div>
                                </label>
                            </div>

                            @if(isset($byKey['terminal_status_text']))
                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wider text-stone-600 mb-1.5">Terminal System Status</label>
                                <input type="text" name="terminal_status_text" value="{{ old('terminal_status_text', $byKey['terminal_status_text']->value ?? 'PRODUCTION READY') }}" class="admin-input font-mono text-xs" placeholder="PRODUCTION READY">
                            </div>
                            @endif

                            @if(isset($byKey['terminal_sla_text']))
                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wider text-stone-600 mb-1.5">Response SLA Commitment</label>
                                <input type="text" name="terminal_sla_text" value="{{ old('terminal_sla_text', $byKey['terminal_sla_text']->value ?? '< 24H RESPONSE') }}" class="admin-input font-mono text-xs" placeholder="< 24H RESPONSE">
                            </div>
                            @endif

                            @if(isset($byKey['about_highlight_1']))
                            <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-3 gap-3 pt-2 border-t border-[#E5E1D5]">
                                <div>
                                    <label class="block text-[11px] font-semibold uppercase tracking-wider text-stone-500 mb-1">Highlight Point #1</label>
                                    <input type="text" name="about_highlight_1" value="{{ old('about_highlight_1', $byKey['about_highlight_1']->value ?? '') }}" class="admin-input text-xs" placeholder="Full-Stack Engineering">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-semibold uppercase tracking-wider text-stone-500 mb-1">Highlight Point #2</label>
                                    <input type="text" name="about_highlight_2" value="{{ old('about_highlight_2', $byKey['about_highlight_2']->value ?? '') }}" class="admin-input text-xs" placeholder="Scalable Database Schema">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-semibold uppercase tracking-wider text-stone-500 mb-1">Highlight Point #3</label>
                                    <input type="text" name="about_highlight_3" value="{{ old('about_highlight_3', $byKey['about_highlight_3']->value ?? '') }}" class="admin-input text-xs" placeholder="API & Performance Optimization">
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- TAB 4: SOCIAL PROFILES -->
                <div x-show="activeTab === 'social'" x-cloak class="space-y-6">
                    <div class="admin-form-card">
                        <div class="admin-form-header">
                            <h3 class="text-base font-bold text-stone-900">Social Media &amp; Developer Profiles</h3>
                            <p class="text-xs text-stone-500">Links appear in your website header, hero copy-box, and footer.</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wider text-stone-600 mb-1.5">GitHub Profile URL</label>
                                <input type="url" name="social_github" value="{{ old('social_github', $byKey['social_github']->value ?? '') }}" class="admin-input" placeholder="https://github.com/username">
                                <p class="text-[11px] text-stone-400 mt-1">Recommended: displays repo link on code cards.</p>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wider text-stone-600 mb-1.5">LinkedIn Profile URL</label>
                                <input type="url" name="social_linkedin" value="{{ old('social_linkedin', $byKey['social_linkedin']->value ?? '') }}" class="admin-input" placeholder="https://linkedin.com/in/username">
                                <p class="text-[11px] text-stone-400 mt-1">Direct professional networking link.</p>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wider text-stone-600 mb-1.5">Twitter / X Profile URL</label>
                                <input type="url" name="social_twitter" value="{{ old('social_twitter', $byKey['social_twitter']->value ?? '') }}" class="admin-input" placeholder="https://x.com/username">
                            </div>

                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wider text-stone-600 mb-1.5">Instagram Profile URL</label>
                                <input type="url" name="social_instagram" value="{{ old('social_instagram', $byKey['social_instagram']->value ?? '') }}" class="admin-input" placeholder="https://instagram.com/username">
                            </div>

                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wider text-stone-600 mb-1.5">YouTube Channel URL</label>
                                <input type="url" name="social_youtube" value="{{ old('social_youtube', $byKey['social_youtube']->value ?? '') }}" class="admin-input" placeholder="https://youtube.com/@channel">
                            </div>

                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wider text-stone-600 mb-1.5">Facebook Profile / Page URL</label>
                                <input type="url" name="social_facebook" value="{{ old('social_facebook', $byKey['social_facebook']->value ?? '') }}" class="admin-input" placeholder="https://facebook.com/username">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TAB 5: SEO & METADATA -->
                <div x-show="activeTab === 'seo'" x-cloak class="space-y-6">
                    <div class="admin-form-card">
                        <div class="admin-form-header">
                            <h3 class="text-base font-bold text-stone-900">Search Engine Optimization (SEO) &amp; Open Graph</h3>
                            <p class="text-xs text-stone-500">Configure how your website appears on Google, WhatsApp, LinkedIn, and Twitter shares.</p>
                        </div>

                        <div class="space-y-5">
                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wider text-stone-600 mb-1.5">Default SEO Title</label>
                                <input type="text" name="default_seo_title" value="{{ old('default_seo_title', $byKey['default_seo_title']->value ?? '') }}" class="admin-input" placeholder="Rohit Gannote - Full Stack Web Developer &amp; Laravel Specialist">
                                <p class="text-[11px] text-stone-400 mt-1">Recommended length: 50-60 characters.</p>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wider text-stone-600 mb-1.5">Default Meta Description</label>
                                <textarea name="default_seo_description" rows="3" class="admin-textarea" placeholder="Explore projects and technical expertise of Rohit Gannote, specializing in high-performance Laravel and database architectures.">{{ old('default_seo_description', $byKey['default_seo_description']->value ?? '') }}</textarea>
                                <p class="text-[11px] text-stone-400 mt-1">Recommended length: 150-160 characters for search snippet previews.</p>
                            </div>

                            <!-- Social Share Image (OG Image) -->
                            <div class="rounded-xl border border-[#E5E1D5] bg-[#FAF9F5] p-4">
                                <label class="block text-xs font-semibold uppercase tracking-wider text-stone-600 mb-2">Social Share Banner (Open Graph Image)</label>
                                <div class="flex items-center gap-4">
                                    @if(!empty($byKey['default_og_image']->value))
                                        <div class="h-20 w-32 rounded-xl border border-[#E5E1D5] bg-white p-1 overflow-hidden shrink-0 shadow-xs">
                                            <img src="{{ asset('storage/' . $byKey['default_og_image']->value) }}" alt="OG Banner" class="h-full w-full object-cover rounded-lg">
                                        </div>
                                    @else
                                        <div class="h-20 w-32 rounded-xl border border-dashed border-stone-300 bg-white flex items-center justify-center shrink-0 text-stone-400 text-xs">
                                            1200 x 630px
                                        </div>
                                    @endif
                                    <div class="flex-1 min-w-0">
                                        <input type="file" name="default_og_image" accept="image/*" class="admin-input text-xs">
                                        <p class="text-[11px] text-stone-400 mt-1">Recommended: 1200 &times; 630px JPG or PNG image for link previews.</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Sitemap Enabled -->
                            <div class="rounded-xl border border-[#E5E1D5] bg-[#FAF9F5] p-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                                <div>
                                    <span class="text-sm font-bold text-stone-900">XML Sitemap Generator</span>
                                    <p class="text-xs text-stone-500 mt-0.5">Automatically generates /sitemap.xml for search engines.</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer shrink-0">
                                    <input type="checkbox" name="sitemap_enabled" value="1" {{ ($byKey['sitemap_enabled']->value ?? '1') == '1' ? 'checked' : '' }} class="sr-only peer">
                                    <div class="w-11 h-6 bg-stone-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-stone-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#B85D19]"></div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TAB 6: EMAIL & SMTP -->
                <div x-show="activeTab === 'email'" x-cloak class="space-y-6">
                    <div class="admin-form-card">
                        <div class="admin-form-header">
                            <h3 class="text-base font-bold text-stone-900">Email &amp; SMTP Configuration</h3>
                            <p class="text-xs text-stone-500">Configure outbound SMTP credentials for contact form notifications and auto-replies.</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wider text-stone-600 mb-1.5">Mail Driver</label>
                                <input type="text" name="mail_mailer" value="{{ old('mail_mailer', $byKey['mail_mailer']->value ?? 'smtp') }}" class="admin-input" placeholder="smtp">
                            </div>

                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wider text-stone-600 mb-1.5">Mail Host</label>
                                <input type="text" name="mail_host" value="{{ old('mail_host', $byKey['mail_host']->value ?? 'smtp.mailtrap.io') }}" class="admin-input" placeholder="smtp.mailtrap.io / smtp.gmail.com">
                            </div>

                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wider text-stone-600 mb-1.5">Mail Port</label>
                                <input type="number" name="mail_port" value="{{ old('mail_port', $byKey['mail_port']->value ?? '587') }}" class="admin-input" placeholder="587">
                            </div>

                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wider text-stone-600 mb-1.5">Encryption</label>
                                <input type="text" name="mail_encryption" value="{{ old('mail_encryption', $byKey['mail_encryption']->value ?? 'tls') }}" class="admin-input" placeholder="tls / ssl">
                            </div>

                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wider text-stone-600 mb-1.5">SMTP Username</label>
                                <input type="text" name="mail_username" value="{{ old('mail_username', $byKey['mail_username']->value ?? '') }}" class="admin-input" placeholder="username / API key">
                            </div>

                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wider text-stone-600 mb-1.5">SMTP Password</label>
                                <input type="password" name="mail_password" value="" class="admin-input" placeholder="{{ !empty($byKey['mail_password']->value) ? '••••••••••••' : 'Enter password' }}">
                            </div>

                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wider text-stone-600 mb-1.5">From Email Address</label>
                                <input type="email" name="mail_from_address" value="{{ old('mail_from_address', $byKey['mail_from_address']->value ?? 'hello@example.com') }}" class="admin-input" placeholder="notifications@domain.com">
                            </div>

                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wider text-stone-600 mb-1.5">From Name</label>
                                <input type="text" name="mail_from_name" value="{{ old('mail_from_name', $byKey['mail_from_name']->value ?? 'Rohit Gannote') }}" class="admin-input" placeholder="Rohit Gannote Portfolio">
                            </div>

                            <!-- Notification Toggles -->
                            <div class="md:col-span-2 space-y-3 pt-2">
                                <div class="rounded-xl border border-[#E5E1D5] bg-[#FAF9F5] p-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                                    <div>
                                        <span class="text-sm font-bold text-stone-900">Admin Email Notifications</span>
                                        <p class="text-xs text-stone-500 mt-0.5">Send instant email alert to admin when a new enquiry is submitted on the contact form.</p>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer shrink-0">
                                        <input type="checkbox" name="notify_admin_on_enquiry" value="1" {{ ($byKey['notify_admin_on_enquiry']->value ?? '1') == '1' ? 'checked' : '' }} class="sr-only peer">
                                        <div class="w-11 h-6 bg-stone-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-stone-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#B85D19]"></div>
                                    </label>
                                </div>

                                <div class="rounded-xl border border-[#E5E1D5] bg-[#FAF9F5] p-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                                    <div>
                                        <span class="text-sm font-bold text-stone-900">Visitor Auto-Reply Confirmation</span>
                                        <p class="text-xs text-stone-500 mt-0.5">Send a polite automatic acknowledgment email to the visitor after submitting.</p>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer shrink-0">
                                        <input type="checkbox" name="send_enquiry_confirmation" value="1" {{ ($byKey['send_enquiry_confirmation']->value ?? '1') == '1' ? 'checked' : '' }} class="sr-only peer">
                                        <div class="w-11 h-6 bg-stone-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-stone-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#B85D19]"></div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TAB 7: MAINTENANCE MODE -->
                <div x-show="activeTab === 'maintenance'" x-cloak class="space-y-6">
                    <div class="admin-form-card border-amber-200 bg-amber-50/20">
                        <div class="admin-form-header border-amber-200">
                            <div class="flex items-center gap-2">
                                <span class="h-2.5 w-2.5 rounded-full bg-amber-500"></span>
                                <h3 class="text-base font-bold text-stone-900">Maintenance Mode &amp; Access Lockdown</h3>
                            </div>
                            <p class="text-xs text-stone-500">Enable this mode if you are performing major updates or database migrations.</p>
                        </div>

                        <div class="rounded-xl border border-amber-200 bg-white p-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <div>
                                <span class="text-sm font-bold text-stone-900">Enable Public Site Maintenance Mode</span>
                                <p class="text-xs text-stone-500 mt-1 max-w-xl">When enabled, visitors will see a clean "Under Scheduled Maintenance" landing screen. Logged-in administrators will still have full access to both the admin panel and public site.</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer shrink-0">
                                <input type="checkbox" name="maintenance_mode" value="1" {{ ($byKey['maintenance_mode']->value ?? '0') == '1' ? 'checked' : '' }} class="sr-only peer">
                                <div class="w-11 h-6 bg-stone-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-stone-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-amber-600"></div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Sticky Bottom Bar -->
                <div class="sticky bottom-4 z-20 flex items-center justify-between rounded-2xl border border-[#E5E1D5] bg-white/95 px-5 py-3.5 shadow-lg backdrop-blur">
                    <div class="flex items-center gap-2 text-xs text-stone-500">
                        <span class="inline-block h-2 w-2 rounded-full bg-stone-400"></span>
                        <span>Press <kbd class="rounded bg-stone-100 px-1.5 py-0.5 font-mono text-[10px] text-stone-700 border border-stone-200">Ctrl + S</kbd> anytime to save</span>
                    </div>

                    <div class="flex items-center gap-3">
                        <a href="{{ route('admin.settings.index') }}" class="admin-btn-secondary text-xs">
                            Reset Form
                        </a>
                        <button type="submit" class="admin-btn-primary">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Save All Settings</span>
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </form>
</div>
@endsection
