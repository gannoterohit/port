@extends('admin.layouts.master')

@section('title', 'Homepage Management')
@section('header', 'Homepage Configuration')

@section('admin-content')
<div class="space-y-6">

    <!-- Top Banner -->
    <div class="flex flex-col gap-4 rounded-2xl border border-[#E5E1D5] bg-gradient-to-br from-white to-[#FAF9F5] p-5 shadow-xs sm:flex-row sm:items-center sm:justify-between sm:p-6">
        <div>
            <div class="flex items-center gap-2">
                <span class="inline-flex h-2 w-2 rounded-full bg-[#B85D19]"></span>
                <p class="text-xs font-mono font-bold uppercase tracking-wider text-[#B85D19]">Landing Experience</p>
            </div>
            <h2 class="mt-1 text-xl font-bold tracking-tight text-stone-900 sm:text-2xl">Homepage Layout &amp; Section Controls</h2>
            <p class="mt-1 text-xs text-stone-500 sm:text-sm">Manage Hero copywriting, primary CTA actions, section visibility toggles, and display order.</p>
        </div>
        <div class="flex items-center gap-2.5">
            <button type="submit" form="homepage-form" class="admin-btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>Save Homepage Settings</span>
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

    <form id="homepage-form" method="POST" action="{{ route('admin.homepage.update') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Hero Section Configuration -->
        <div class="admin-form-card space-y-5">
            <div class="admin-form-header flex items-center justify-between">
                <div>
                    <h3 class="text-base font-bold text-stone-900">Hero Section Content</h3>
                    <p class="text-xs text-stone-500">First impression banner displayed above the fold.</p>
                </div>
                <div class="flex items-center gap-3 bg-stone-100/70 px-3 py-1.5 rounded-xl border border-stone-200">
                    <span class="text-xs font-semibold text-stone-700">Enable Hero</span>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="hero_section_enabled" value="1" {{ $settings->hero_section_enabled ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-10 h-5 bg-stone-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-stone-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-[#B85D19]"></div>
                    </label>
                </div>
            </div>

            <div class="space-y-4 pt-2">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="md:col-span-2 space-y-4">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-stone-600 mb-1">Hero Sub-heading / Eyebrow</label>
                            <input type="text" name="hero_heading" value="{{ old('hero_heading', $settings->hero_heading) }}"
                                class="admin-input" placeholder="e.g. Senior Full Stack Engineer &amp; Architect">
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-stone-600 mb-1">Hero Main Title <span class="text-rose-500">*</span></label>
                            <input type="text" name="hero_title" value="{{ old('hero_title', $settings->hero_title) }}"
                                class="admin-input" placeholder="e.g. Building robust digital products with precision">
                        </div>
                    </div>

                    <div class="md:col-span-1 space-y-2">
                        <label class="block text-xs font-bold uppercase tracking-wider text-stone-600">Hero Side Image</label>
                        <div class="h-28 rounded-xl border border-[#E5E0D5] bg-stone-50 flex items-center justify-center overflow-hidden">
                            @if($settings->hero_image)
                                <img src="{{ $settings->hero_image_url }}" alt="Hero Image" class="w-full h-full object-cover">
                            @else
                                <span class="text-stone-400 text-xs text-center font-medium">No Image Uploaded</span>
                            @endif
                        </div>
                        <input type="file" name="hero_image" accept="image/*" class="admin-input text-xs">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-stone-600 mb-1">Hero Bio Description</label>
                    <textarea name="hero_description" rows="3"
                        class="admin-textarea" placeholder="Brief 2-3 sentence overview of who you are and what you build...">{{ old('hero_description', $settings->hero_description) }}</textarea>
                </div>
            </div>
        </div>

        <!-- Call-to-Action Buttons -->
        <div class="admin-form-card space-y-5">
            <div class="admin-form-header">
                <h3 class="text-base font-bold text-stone-900">Hero Call-to-Action Buttons</h3>
                <p class="text-xs text-stone-500">Configure destination links and button labels for the hero section.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 pt-2">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-stone-600 mb-1">Primary Button Text</label>
                    <input type="text" name="primary_cta_text" value="{{ old('primary_cta_text', $settings->primary_cta_text) }}"
                        class="admin-input" placeholder="e.g., Hire Me">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-stone-600 mb-1">Primary Button URL</label>
                    <input type="text" name="primary_cta_url" value="{{ old('primary_cta_url', $settings->primary_cta_url) }}"
                        class="admin-input font-mono text-xs" placeholder="#contact or /contact">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-stone-600 mb-1">Secondary Button Text</label>
                    <input type="text" name="secondary_cta_text" value="{{ old('secondary_cta_text', $settings->secondary_cta_text) }}"
                        class="admin-input" placeholder="e.g., View Portfolio">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-stone-600 mb-1">Secondary Button URL</label>
                    <input type="text" name="secondary_cta_url" value="{{ old('secondary_cta_url', $settings->secondary_cta_url) }}"
                        class="admin-input font-mono text-xs" placeholder="#projects or /projects">
                </div>
            </div>
        </div>

        <!-- Section Visibility Toggles -->
        <div class="admin-form-card space-y-5">
            <div class="admin-form-header">
                <h3 class="text-base font-bold text-stone-900">Section Visibility Toggles</h3>
                <p class="text-xs text-stone-500">Turn on or off entire sections displayed on the homepage.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3.5 pt-2">
                @php
                    $sections = [
                        ['name' => 'about_section_enabled', 'title' => 'About Section', 'desc' => 'Bio, story & stats', 'checked' => $settings->about_section_enabled],
                        ['name' => 'skills_section_enabled', 'title' => 'Skills Section', 'desc' => 'Tech stack marquee & grid', 'checked' => $settings->skills_section_enabled],
                        ['name' => 'projects_section_enabled', 'title' => 'Projects Section', 'desc' => 'Featured portfolio showcase', 'checked' => $settings->projects_section_enabled],
                        ['name' => 'services_section_enabled', 'title' => 'Services Section', 'desc' => 'Client offerings & packages', 'checked' => $settings->services_section_enabled],
                        ['name' => 'work_process_section_enabled', 'title' => 'Work Process Section', 'desc' => 'Step-by-step workflow stages', 'checked' => $settings->work_process_section_enabled],
                        ['name' => 'testimonials_section_enabled', 'title' => 'Testimonials Section', 'desc' => 'Client reviews & praise', 'checked' => $settings->testimonials_section_enabled],
                    ];
                @endphp

                @foreach($sections as $sec)
                    <div class="flex items-center justify-between p-3.5 rounded-xl border border-[#E5E0D5] bg-[#FAF9F5] hover:border-[#B85D19]/30 transition-all">
                        <div>
                            <span class="text-xs font-bold text-stone-900 block">{{ $sec['title'] }}</span>
                            <span class="text-[11px] text-stone-500">{{ $sec['desc'] }}</span>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer shrink-0">
                            <input type="checkbox" name="{{ $sec['name'] }}" value="1" {{ $sec['checked'] ? 'checked' : '' }} class="sr-only peer">
                            <div class="w-10 h-5 bg-stone-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-stone-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-[#B85D19]"></div>
                        </label>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Contact CTA Section -->
        <div class="admin-form-card space-y-5">
            <div class="admin-form-header flex items-center justify-between">
                <div>
                    <h3 class="text-base font-bold text-stone-900">Bottom Contact CTA Block</h3>
                    <p class="text-xs text-stone-500">Banner placed just above the footer to prompt enquiries.</p>
                </div>
                <div class="flex items-center gap-3 bg-stone-100/70 px-3 py-1.5 rounded-xl border border-stone-200">
                    <span class="text-xs font-semibold text-stone-700">Enable CTA</span>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="contact_cta_section_enabled" value="1" {{ $settings->contact_cta_section_enabled ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-10 h-5 bg-stone-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-stone-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-[#B85D19]"></div>
                    </label>
                </div>
            </div>

            <div class="space-y-4 pt-2">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-stone-600 mb-1">CTA Heading</label>
                    <input type="text" name="contact_cta_heading" value="{{ old('contact_cta_heading', $settings->contact_cta_heading) }}"
                        class="admin-input" placeholder="e.g., Have a project in mind? Let's build something together.">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-stone-600 mb-1">CTA Sub-text</label>
                    <textarea name="contact_cta_description" rows="2"
                        class="admin-textarea" placeholder="Brief supporting copy urging visitors to reach out...">{{ old('contact_cta_description', $settings->contact_cta_description) }}</textarea>
                </div>
            </div>
        </div>

        <!-- Section Order Layout -->
        <div class="admin-form-card space-y-4">
            <div class="admin-form-header">
                <h3 class="text-base font-bold text-stone-900">Homepage Vertical Section Order</h3>
                <p class="text-xs text-stone-500">Configure the top-to-bottom order of sections on the homepage (one key per line).</p>
            </div>

            <div class="flex flex-wrap gap-1.5 pt-1 text-xs">
                <span class="text-stone-500 font-medium">Valid keys:</span>
                @foreach(['hero', 'services', 'projects', 'about', 'work_process', 'skills', 'testimonials', 'contact_cta'] as $key)
                    <span class="font-mono bg-stone-100 px-2 py-0.5 rounded border border-stone-200 text-stone-700 text-[11px]">{{ $key }}</span>
                @endforeach
            </div>

            @php
                $orderLines = old('section_order_text');
                if ($orderLines === null) {
                    $rawOrder = $settings->section_order;
                    if (is_string($rawOrder)) {
                        $rawOrder = json_decode($rawOrder, true);
                    }
                    $orderLines = is_array($rawOrder) ? implode("\n", $rawOrder) : "hero\nservices\nprojects\nabout\nwork_process\nskills\ntestimonials\ncontact_cta";
                }
            @endphp
            <textarea name="section_order_text" rows="8" class="admin-textarea font-mono text-xs">{{ $orderLines }}</textarea>
        </div>

        <div class="flex items-center justify-end gap-3 pt-2">
            <button type="submit" class="admin-btn-primary">
                Save All Homepage Settings
            </button>
        </div>
    </form>
</div>
@endsection
