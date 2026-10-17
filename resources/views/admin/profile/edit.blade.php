@extends('admin.layouts.master')

@section('title', 'Profile & About')
@section('header', 'Profile & Biography')

@section('admin-content')
<div x-data="{
    activeTab: window.location.hash ? window.location.hash.replace('#', '') : 'personal',
    setActive(tab) {
        this.activeTab = tab;
        window.location.hash = tab;
    }
}" @keydown.window.ctrl.s.prevent="$refs.profileForm.submit()" @keydown.window.meta.s.prevent="$refs.profileForm.submit()" class="space-y-6">

    <!-- Top Header -->
    <div class="flex flex-col gap-4 rounded-2xl border border-[#E5E1D5] bg-gradient-to-br from-white to-[#FAF9F5] p-5 shadow-xs sm:flex-row sm:items-center sm:justify-between sm:p-6">
        <div>
            <div class="flex items-center gap-2">
                <span class="inline-flex h-2 w-2 rounded-full bg-[#B85D19]"></span>
                <p class="text-xs font-mono font-bold uppercase tracking-wider text-[#B85D19]">Bio &amp; Resume Management</p>
            </div>
            <h2 class="mt-1 text-xl font-bold tracking-tight text-stone-900 sm:text-2xl">Developer Profile &amp; Experience</h2>
            <p class="mt-1 text-xs text-stone-500 sm:text-sm">Keep your professional title, biography, headshot, and downloadable resume up to date.</p>
        </div>
        <div class="flex items-center gap-2.5">
            <button type="button" @click="$refs.profileForm.submit()" class="admin-btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>Save Profile Changes</span>
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

    <form x-ref="profileForm" method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-12">
            <!-- Left Tabs -->
            <div class="lg:col-span-4 xl:col-span-3">
                <div class="sticky top-24 space-y-1.5 rounded-2xl border border-[#E5E1D5] bg-white p-3 shadow-xs">
                    <p class="px-3 pb-2 pt-1 text-[11px] font-bold uppercase tracking-wider text-stone-400">Profile Sections</p>

                    <button type="button" @click="setActive('personal')" :class="activeTab === 'personal' ? 'admin-tab-btn-active' : 'admin-tab-btn-inactive'" class="admin-tab-btn">
                        <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <div class="min-w-0 flex-1 text-left">
                            <div class="text-sm font-semibold">Personal &amp; Titles</div>
                            <div class="truncate text-[11px] text-stone-400">Name, job title, headline</div>
                        </div>
                    </button>

                    <button type="button" @click="setActive('biography')" :class="activeTab === 'biography' ? 'admin-tab-btn-active' : 'admin-tab-btn-inactive'" class="admin-tab-btn">
                        <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <div class="min-w-0 flex-1 text-left">
                            <div class="text-sm font-semibold">Bio &amp; Experience Text</div>
                            <div class="truncate text-[11px] text-stone-400">Detailed story &amp; tenure</div>
                        </div>
                    </button>

                    <button type="button" @click="setActive('media')" :class="activeTab === 'media' ? 'admin-tab-btn-active' : 'admin-tab-btn-inactive'" class="admin-tab-btn">
                        <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <div class="min-w-0 flex-1 text-left">
                            <div class="text-sm font-semibold">Photo &amp; Resume PDF</div>
                            <div class="truncate text-[11px] text-stone-400">Headshot &amp; CV file</div>
                        </div>
                    </button>

                    <button type="button" @click="setActive('contact_info')" :class="activeTab === 'contact_info' ? 'admin-tab-btn-active' : 'admin-tab-btn-inactive'" class="admin-tab-btn">
                        <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 01-2-2v12a2 2 0 002 2z"></path>
                        </svg>
                        <div class="min-w-0 flex-1 text-left">
                            <div class="text-sm font-semibold">Direct Details</div>
                            <div class="truncate text-[11px] text-stone-400">Email, location &amp; socials</div>
                        </div>
                    </button>
                </div>
            </div>

            <!-- Right Content -->
            <div class="lg:col-span-8 xl:col-span-9 space-y-6">

                <!-- TAB: Personal -->
                <div x-show="activeTab === 'personal'" x-cloak class="admin-form-card space-y-5">
                    <div class="admin-form-header">
                        <h3 class="text-base font-bold text-stone-900">Personal Information &amp; Headlines</h3>
                        <p class="text-xs text-stone-500">Your primary identity displayed prominently on the hero and portfolio pages.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-stone-600 mb-1.5">Full Name *</label>
                            <input type="text" name="name" value="{{ old('name', $profile->name) }}" required class="admin-input" placeholder="Rohit Gannote">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-stone-600 mb-1.5">Professional Title *</label>
                            <input type="text" name="title" value="{{ old('title', $profile->title) }}" required class="admin-input" placeholder="Full Stack Web Developer">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-xs font-semibold uppercase tracking-wider text-stone-600 mb-1.5">Subtitle / Headline</label>
                            <input type="text" name="subtitle" value="{{ old('subtitle', $profile->subtitle) }}" class="admin-input" placeholder="Full Stack Developer | 2.5+ Years Experience &amp; Laravel Specialist">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-xs font-semibold uppercase tracking-wider text-stone-600 mb-1.5">Hero Short Introduction</label>
                            <textarea name="intro" rows="3" class="admin-textarea" placeholder="Short 2-line intro displayed beneath the hero headline...">{{ old('intro', $profile->intro) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- TAB: Bio & Experience -->
                <div x-show="activeTab === 'biography'" x-cloak class="admin-form-card space-y-5">
                    <div class="admin-form-header">
                        <h3 class="text-base font-bold text-stone-900">Biography &amp; Professional Experience</h3>
                        <p class="text-xs text-stone-500">Comprehensive overview of your journey, engineering philosophy, and stack mastery.</p>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-stone-600 mb-1.5">Experience Summary Sentence *</label>
                        <input type="text" name="experience_text" value="{{ old('experience_text', $profile->experience_text) }}" required class="admin-input font-medium" placeholder="2.5+ years of hands-on full-stack development experience + 6 months intensive training">
                        <p class="text-[11px] text-stone-400 mt-1">Shown in the about section highlight bar.</p>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-stone-600 mb-1.5">Detailed Biography</label>
                        <textarea name="biography" id="biography" rows="8" class="admin-textarea" placeholder="Full biography text...">{{ old('biography', $profile->biography) }}</textarea>
                    </div>
                </div>

                <!-- TAB: Photo & Resume PDF -->
                <div x-show="activeTab === 'media'" x-cloak class="space-y-6">
                    <div class="admin-form-card space-y-5">
                        <div class="admin-form-header">
                            <h3 class="text-base font-bold text-stone-900">Profile Photo (Headshot)</h3>
                            <p class="text-xs text-stone-500">Square portrait photo used on the about page and author credits.</p>
                        </div>

                        <div class="flex items-center gap-5">
                            @if($profile->profile_photo)
                                <img src="{{ $profile->profile_photo_url }}" alt="Profile Photo" class="w-20 h-20 rounded-2xl object-cover border border-[#E5E1D5] shadow-xs shrink-0">
                            @else
                                <div class="w-20 h-20 bg-stone-100 rounded-2xl border border-dashed border-stone-300 flex items-center justify-center text-stone-400 text-xs shrink-0">No Photo</div>
                            @endif
                            <div class="flex-1">
                                <label class="block text-xs font-semibold uppercase tracking-wider text-stone-600 mb-1.5">Upload New Photo</label>
                                <input type="file" name="profile_photo" accept="image/*" class="admin-input text-xs">
                                <p class="text-[11px] text-stone-400 mt-1">Recommended: 400 &times; 400px (JPG, PNG or WEBP).</p>
                            </div>
                        </div>
                    </div>

                    <div class="admin-form-card space-y-5">
                        <div class="admin-form-header">
                            <h3 class="text-base font-bold text-stone-900">Resume / CV Document</h3>
                            <p class="text-xs text-stone-500">Provide a downloadable PDF for recruiters and hiring managers.</p>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wider text-stone-600 mb-1.5">Upload Resume PDF</label>
                                <input type="file" name="resume_pdf" accept="application/pdf" class="admin-input text-xs">
                                <p class="text-[11px] text-stone-400 mt-1">PDF format only. Maximum file size: 10MB.</p>
                            </div>

                            @if($profile->resume_pdf)
                                <div class="rounded-xl border border-[#E5E1D5] bg-[#FAF9F5] p-3.5 flex items-center justify-between">
                                    <div class="flex items-center gap-2 text-xs font-semibold text-stone-700">
                                        <svg class="w-4 h-4 text-[#B85D19]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        <span>Current Resume Uploaded</span>
                                    </div>
                                    <a href="{{ $profile->resume_url }}" target="_blank" class="text-xs font-bold text-[#B85D19] hover:underline">
                                        View Resume PDF &rarr;
                                    </a>
                                </div>
                            @endif

                            <div class="rounded-xl border border-[#E5E1D5] bg-[#FAF9F5] p-4 flex items-center justify-between">
                                <div>
                                    <span class="text-sm font-bold text-stone-900">Show "Download CV" Button Publicly</span>
                                    <p class="text-xs text-stone-500 mt-0.5">When checked, a prominent download button appears on your homepage hero.</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer shrink-0">
                                    <input type="checkbox" name="resume_button_visible" value="1" {{ $profile->resume_button_visible ? 'checked' : '' }} class="sr-only peer">
                                    <div class="w-11 h-6 bg-stone-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-stone-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#B85D19]"></div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TAB: Direct Details -->
                <div x-show="activeTab === 'contact_info'" x-cloak class="space-y-6">
                    <div class="admin-form-card space-y-5">
                        <div class="admin-form-header">
                            <h3 class="text-base font-bold text-stone-900">Contact Details</h3>
                            <p class="text-xs text-stone-500">Direct contact info shown on the public profile.</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wider text-stone-600 mb-1.5">Direct Email</label>
                                <input type="email" name="contact_email" value="{{ old('contact_email', $profile->contact_email) }}" class="admin-input">
                            </div>

                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wider text-stone-600 mb-1.5">Direct Phone</label>
                                <input type="text" name="contact_phone" value="{{ old('contact_phone', $profile->contact_phone) }}" class="admin-input">
                            </div>

                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wider text-stone-600 mb-1.5">WhatsApp</label>
                                <input type="text" name="contact_whatsapp" value="{{ old('contact_whatsapp', $profile->contact_whatsapp) }}" class="admin-input">
                            </div>

                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wider text-stone-600 mb-1.5">Location</label>
                                <input type="text" name="location" value="{{ old('location', $profile->location) }}" class="admin-input" placeholder="Indore, India">
                            </div>

                            <div class="md:col-span-2 rounded-xl border border-[#E5E1D5] bg-[#FAF9F5] p-4 flex items-center justify-between">
                                <div>
                                    <span class="text-sm font-bold text-stone-900">Display Location on Website</span>
                                    <p class="text-xs text-stone-500 mt-0.5">Show your city location on the public portfolio.</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer shrink-0">
                                    <input type="checkbox" name="location_visible" value="1" {{ $profile->location_visible ? 'checked' : '' }} class="sr-only peer">
                                    <div class="w-11 h-6 bg-stone-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-stone-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#B85D19]"></div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sticky Bottom Save Bar -->
                <div class="sticky bottom-4 z-20 flex items-center justify-between rounded-2xl border border-[#E5E1D5] bg-white/95 px-5 py-3.5 shadow-lg backdrop-blur">
                    <div class="flex items-center gap-2 text-xs text-stone-500">
                        <span class="inline-block h-2 w-2 rounded-full bg-stone-400"></span>
                        <span>Press <kbd class="rounded bg-stone-100 px-1.5 py-0.5 font-mono text-[10px] text-stone-700 border border-stone-200">Ctrl + S</kbd> to save</span>
                    </div>

                    <div class="flex items-center gap-3">
                        <button type="submit" class="admin-btn-primary">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Save Profile Changes</span>
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </form>
</div>
@endsection
