@extends('admin.layouts.master')

@section('title', 'SEO Settings')
@section('header', 'SEO Management')

@section('admin-content')
<form method="POST" action="{{ route('admin.seo.update') }}" enctype="multipart/form-data" class="space-y-6">
    @csrf
    @method('PUT')

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Default SEO Settings</h3>
        <p class="text-sm text-gray-500 mb-4">These are used as fallbacks when individual pages don't specify their own SEO metadata.</p>

        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Default SEO Title</label>
                <input type="text" name="default_seo_title"
                    value="{{ old('default_seo_title', $seoSettings['default_seo_title']->value ?? '') }}"
                    class="admin-input" placeholder="Title that appears in search results">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Default SEO Description</label>
                <textarea name="default_seo_description" rows="2" class="admin-textarea"
                    placeholder="Description for search results...">{{ old('default_seo_description', $seoSettings['default_seo_description']->value ?? '') }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Default Social Sharing Image</label>
                @if(isset($seoSettings['default_og_image']) && $seoSettings['default_og_image']->value)
                    <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($seoSettings['default_og_image']->value) }}" alt="OG Image" class="w-24 h-24 object-cover rounded-lg mb-2">
                @endif
                <input type="file" name="default_og_image" accept="image/*" class="admin-input">
                <p class="text-xs text-gray-500 mt-1">1200x630px recommended for social sharing.</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Sitemap</h3>
        <div class="flex items-center gap-3">
            <input type="checkbox" name="sitemap_enabled" value="1"
                {{ ($seoSettings['sitemap_enabled']->value ?? '1') == '1' ? 'checked' : '' }}>
            <label class="text-sm text-gray-700">Enable XML Sitemap</label>
        </div>
        <p class="text-xs text-gray-500 mt-1">Sitemap is available at <a href="{{ route('sitemap.xml') }}" class="text-emerald-700" target="_blank">/sitemap.xml</a></p>
    </div>

    <div class="flex justify-end">
        <button type="submit"
            class="bg-emerald-700 hover:bg-emerald-800 text-white px-6 py-3 rounded-lg font-medium transition-colors">
            Save SEO Settings
        </button>
    </div>
</form>
@endsection
