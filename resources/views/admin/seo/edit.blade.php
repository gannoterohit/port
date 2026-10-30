@extends('admin.layouts.master')

@section('title', 'SEO Management')
@section('header', 'Search Engine Optimization')

@section('admin-content')
<div class="space-y-6">

    <!-- Top Banner -->
    <div class="flex flex-col gap-4 rounded-2xl border border-[#E5E1D5] bg-gradient-to-br from-white to-[#FAF9F5] p-5 shadow-xs sm:flex-row sm:items-center sm:justify-between sm:p-6">
        <div>
            <div class="flex items-center gap-2">
                <span class="inline-flex h-2 w-2 rounded-full bg-[#B85D19]"></span>
                <p class="text-xs font-mono font-bold uppercase tracking-wider text-[#B85D19]">Search &amp; Social Previews</p>
            </div>
            <h2 class="mt-1 text-xl font-bold tracking-tight text-stone-900 sm:text-2xl">Global SEO &amp; Open Graph Configuration</h2>
            <p class="mt-1 text-xs text-stone-500 sm:text-sm">Default meta tags, social share banner cards, and XML sitemap settings.</p>
        </div>
        <div class="flex items-center gap-2.5">
            <button type="submit" form="seo-form" class="admin-btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>Save SEO Settings</span>
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

    <form id="seo-form" method="POST" action="{{ route('admin.seo.update') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="admin-form-card space-y-5">
            <div class="admin-form-header">
                <h3 class="text-base font-bold text-stone-900">Default Meta Metadata</h3>
                <p class="text-xs text-stone-500">Fallback tags applied across any portfolio page lacking custom metadata.</p>
            </div>

            <div class="space-y-5">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-stone-600 mb-1.5">Default SEO Title</label>
                    <input type="text" name="default_seo_title" value="{{ old('default_seo_title', $seoSettings['default_seo_title']->value ?? '') }}" class="admin-input" placeholder="Title that appears in Google search results">
                    <p class="text-[11px] text-stone-400 mt-1">Recommended length: 50-60 characters.</p>
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-stone-600 mb-1.5">Default SEO Meta Description</label>
                    <textarea name="default_seo_description" rows="3" class="admin-textarea" placeholder="Description shown below search titles...">{{ old('default_seo_description', $seoSettings['default_seo_description']->value ?? '') }}</textarea>
                    <p class="text-[11px] text-stone-400 mt-1">Recommended: 150-160 characters for crisp search snippet display.</p>
                </div>

                <div class="rounded-xl border border-[#E5E1D5] bg-[#FAF9F5] p-4">
                    <label class="block text-xs font-semibold uppercase tracking-wider text-stone-600 mb-2">Default Social Sharing Image (OG Banner)</label>
                    <div class="flex items-center gap-5">
                        @if(isset($seoSettings['default_og_image']) && $seoSettings['default_og_image']->value)
                            <div class="h-20 w-32 rounded-xl border border-[#E5E1D5] bg-white p-1 overflow-hidden shrink-0 shadow-xs">
                                <img src="{{ asset('storage/' . $seoSettings['default_og_image']->value) }}" alt="OG Banner" class="h-full w-full object-cover rounded-lg">
                            </div>
                        @else
                            <div class="h-20 w-32 rounded-xl border border-dashed border-stone-300 bg-white flex items-center justify-center shrink-0 text-stone-400 text-xs">
                                1200 &times; 630px
                            </div>
                        @endif
                        <div class="flex-1 min-w-0">
                            <input type="file" name="default_og_image" accept="image/*" class="admin-input text-xs">
                            <p class="text-[11px] text-stone-400 mt-1">1200 &times; 630px JPG or PNG image used on Twitter/X, LinkedIn and WhatsApp previews.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="admin-form-card space-y-4">
            <div class="admin-form-header">
                <h3 class="text-base font-bold text-stone-900">XML Search Engine Sitemap</h3>
                <p class="text-xs text-stone-500">Allows search engines like Google and Bing to crawl and index your portfolio routes.</p>
            </div>

            <div class="rounded-xl border border-[#E5E1D5] bg-[#FAF9F5] p-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div>
                    <span class="text-sm font-bold text-stone-900">Generate Dynamic XML Sitemap</span>
                    <p class="text-xs text-stone-500 mt-0.5">
                        Sitemap URL: <a href="{{ route('sitemap.xml') }}" target="_blank" class="font-mono text-[#B85D19] hover:underline font-bold">{{ url('/sitemap.xml') }}</a>
                    </p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer shrink-0">
                    <input type="checkbox" name="sitemap_enabled" value="1" {{ ($seoSettings['sitemap_enabled']->value ?? '1') == '1' ? 'checked' : '' }} class="sr-only peer">
                    <div class="w-11 h-6 bg-stone-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-stone-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#B85D19]"></div>
                </label>
            </div>
        </div>

        <!-- Google Analytics & Google Search Console Card -->
        <div class="admin-form-card space-y-5">
            <div class="admin-form-header">
                <div class="flex items-center gap-2">
                    <span class="inline-flex h-2 w-2 rounded-full bg-emerald-500"></span>
                    <h3 class="text-base font-bold text-stone-900">Google Analytics &amp; Search Console</h3>
                </div>
                <p class="text-xs text-stone-500">Connect Google tracking and domain verification directly without editing any code.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-stone-600 mb-1.5">
                        Google Analytics (GA4) Measurement ID
                    </label>
                    <input type="text" name="google_analytics_id" value="{{ old('google_analytics_id', $seoSettings['google_analytics_id']->value ?? '') }}" class="admin-input font-mono text-sm" placeholder="G-XXXXXXXXXX">
                    <p class="text-[11px] text-stone-400 mt-1">Found in Google Analytics ➔ Admin ➔ Data Streams ➔ Measurement ID. Injects the official Google tag (gtag.js).</p>
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-stone-600 mb-1.5">
                        Google Search Console Verification
                    </label>
                    <input type="text" name="google_search_console_code" value="{{ old('google_search_console_code', $seoSettings['google_search_console_code']->value ?? '') }}" class="admin-input font-mono text-sm" placeholder="e.g. google-site-verification code or meta tag">
                    <p class="text-[11px] text-stone-400 mt-1">Paste your verification string or HTML tag from Search Console. Injects &lt;meta name="google-site-verification"&gt; in &lt;head&gt;.</p>
                </div>
            </div>
        </div>

        <!-- Custom Head & Footer Tracking Scripts -->
        <div class="admin-form-card space-y-5">
            <div class="admin-form-header">
                <h3 class="text-base font-bold text-stone-900">Custom Tracking &amp; Head/Body Scripts</h3>
                <p class="text-xs text-stone-500">Optional custom scripts for Microsoft Clarity (session recording), Meta Pixel, Google Tag Manager, etc.</p>
            </div>

            <div class="space-y-5">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-stone-600 mb-1.5">Custom Header Scripts (&lt;head&gt;)</label>
                    <textarea name="custom_head_scripts" rows="3" class="admin-textarea font-mono text-xs" placeholder="<script>...your tracking code...</script>">{{ old('custom_head_scripts', $seoSettings['custom_head_scripts']->value ?? '') }}</textarea>
                    <p class="text-[11px] text-stone-400 mt-1">Raw scripts or styles injected right before the closing &lt;/head&gt; tag on every public page.</p>
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-stone-600 mb-1.5">Custom Footer / Body Scripts (&lt;/body&gt;)</label>
                    <textarea name="custom_body_scripts" rows="3" class="admin-textarea font-mono text-xs" placeholder="<script>...chat widget or footer analytics...</script>">{{ old('custom_body_scripts', $seoSettings['custom_body_scripts']->value ?? '') }}</textarea>
                    <p class="text-[11px] text-stone-400 mt-1">Raw scripts injected right before the closing &lt;/body&gt; tag on every public page.</p>
                </div>
            </div>
        </div>

        <div class="flex justify-end pt-2">
            <button type="submit" class="admin-btn-primary">
                Save SEO Settings
            </button>
        </div>
    </form>

</div>
@endsection
