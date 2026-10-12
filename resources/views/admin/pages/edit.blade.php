@extends('admin.layouts.master')

@section('title', 'Edit Page')
@section('header', 'Edit Page')

@section('admin-content')
<form method="POST" action="{{ route('admin.pages.update', $page) }}" enctype="multipart/form-data" class="space-y-6">
    @csrf
    @method('PUT')

    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm">
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Page Details</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Title *</label>
                <input type="text" name="title" value="{{ old('title', $page->title) }}" required class="admin-input">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
                <input type="text" name="slug" value="{{ old('slug', $page->slug) }}" class="admin-input"
                    placeholder="Leave empty to auto-generate">
            </div>
        </div>

        <div class="mt-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Content</label>
            <textarea name="content" id="content" rows="10" class="admin-textarea"
                placeholder="Page content...">{{ old('content', $page->content) }}</textarea>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Publishing</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" class="admin-input">
                    <option value="draft" {{ old('status', $page->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ old('status', $page->status) === 'published' ? 'selected' : '' }}>Published</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Display Order</label>
                <input type="number" name="display_order" value="{{ old('display_order', $page->display_order) }}"
                    class="admin-input w-20">
            </div>
            <div class="flex items-end">
                <label class="flex items-center gap-2 text-sm text-gray-700">
                    <input type="checkbox" name="show_in_nav" value="1" {{ $page->show_in_nav ? 'checked' : '' }}>
                    Show in Navigation
                </label>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">SEO Metadata</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">SEO Title</label>
                <input type="text" name="seo_title" value="{{ old('seo_title', $page->seo_title) }}" class="admin-input">
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">SEO Description</label>
                <textarea name="seo_description" rows="2" class="admin-textarea">{{ old('seo_description', $page->seo_description) }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">OG Title</label>
                <input type="text" name="og_title" value="{{ old('og_title', $page->og_title) }}" class="admin-input">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">OG Image</label>
                @if($page->og_image)
                    <img src="{{ asset('storage/' . $page->og_image) }}" alt="OG Image" class="w-20 h-20 object-cover rounded-lg mb-2">
                @endif
                <input type="file" name="og_image" accept="image/*" class="admin-input">
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">OG Description</label>
                <textarea name="og_description" rows="2" class="admin-textarea">{{ old('og_description', $page->og_description) }}</textarea>
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Canonical URL</label>
                <input type="url" name="canonical_url" value="{{ old('canonical_url', $page->canonical_url) }}" class="admin-input">
            </div>
            <div class="flex items-end">
                <label class="flex items-center gap-2 text-sm text-gray-700">
                    <input type="checkbox" name="no_index" value="1" {{ $page->no_index ? 'checked' : '' }}>
                    No Index (SEO)
                </label>
            </div>
        </div>
    </div>

    <div class="flex justify-end pt-4 gap-3">
        <a href="{{ route('admin.pages.index') }}" class="text-gray-600 hover:text-gray-900 px-4 py-2">Cancel</a>
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium">
            Update Page
        </button>
    </div>
</form>

<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/7/tinymce.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof tinymce !== 'undefined') {
        tinymce.init({
            selector: '#content',
            height: 400,
            menubar: false,
            plugins: 'lists link',
            toolbar: 'undo redo | bold italic underline | bullist numlist | heading | link',
            branding: false,
            setup: {
                init: function(editor) {
                    editor.on('change', function() {
                        // Sanitize output
                        const content = editor.getContent({ format: 'text' });
                    });
                }
            }
        });
    }
});
</script>
@endsection
