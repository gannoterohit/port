@extends('admin.layouts.master')

@section('title', 'Edit Service')
@section('header', 'Edit Service')

@section('admin-content')
<form method="POST" action="{{ route('admin.services.update', $service) }}" enctype="multipart/form-data" class="space-y-6">
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
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Basic Information</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Service Name *</label>
                <input type="text" name="name" value="{{ old('name', $service->name) }}" required class="admin-input">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
                <input type="text" name="slug" value="{{ old('slug', $service->slug) }}" class="admin-input">
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Icon Class</label>
                <input type="text" name="icon" value="{{ old('icon', $service->icon) }}" class="admin-input"
                    placeholder="e.g., fas fa-laravel, bi:code">
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Image</label>
                @if($service->image)
                    <img src="{{ $service->image_url }}" alt="{{ $service->name }}" class="w-16 h-16 object-cover rounded-lg mb-2">
                @endif
                <input type="file" name="image" accept="image/*" class="admin-input">
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Description</h3>
        <textarea name="description" id="description" rows="8" class="admin-textarea"
            placeholder="Full service description...">{{ old('description', $service->description) }}</textarea>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Features</h3>
        <div id="features-list" class="space-y-2">
            @if(old('features', $service->features))
                @foreach(old('features', $service->features) as $feature)
                    <div class="flex gap-2">
                        <input type="text" name="features[]" value="{{ $feature }}" class="admin-input flex-1"
                            placeholder="e.g., REST API Development">
                        <button type="button" onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700">Remove</button>
                    </div>
                @endforeach
            @else
                <div class="flex gap-2">
                    <input type="text" name="features[]" value="" class="admin-input flex-1"
                        placeholder="e.g., REST API Development">
                </div>
            @endif
        </div>
        <button type="button" onclick="addFeature()" class="mt-2 text-blue-600 hover:text-blue-700 text-sm font-medium">
            + Add Feature
        </button>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">CTA Settings</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">CTA Text</label>
                <input type="text" name="cta_text" value="{{ old('cta_text', $service->cta_text) }}" class="admin-input">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">CTA URL</label>
                <input type="text" name="cta_url" value="{{ old('cta_url', $service->cta_url) }}" class="admin-input">
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Publishing</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="is_enabled" class="admin-input">
                    <option value="1" {{ $service->is_enabled ? 'selected' : '' }}>Enabled</option>
                    <option value="0" {{ !$service->is_enabled ? 'selected' : '' }}>Disabled</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Display Order</label>
                <input type="number" name="display_order" value="{{ old('display_order', $service->display_order) }}"
                    class="admin-input w-20">
            </div>
        </div>
        <label class="flex items-center gap-2 text-sm text-gray-700 mt-2">
            <input type="checkbox" name="is_featured" value="1" {{ $service->is_featured ? 'checked' : '' }}>
            Feature on Homepage
        </label>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">SEO Metadata</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">SEO Title</label>
                <input type="text" name="seo_title" value="{{ old('seo_title', $service->seo_title) }}" class="admin-input">
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">SEO Description</label>
                <textarea name="seo_description" rows="2" class="admin-textarea">{{ old('seo_description', $service->seo_description) }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">OG Title</label>
                <input type="text" name="og_title" value="{{ old('og_title', $service->og_title) }}" class="admin-input">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">OG Image</label>
                @if($service->og_image)
                    <img src="{{ $service->og_image_url }}" alt="OG Image" class="w-16 h-16 object-cover rounded-lg mb-2">
                @endif
                <input type="file" name="og_image" accept="image/*" class="admin-input">
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">OG Description</label>
                <textarea name="og_description" rows="2" class="admin-textarea">{{ old('og_description', $service->og_description) }}</textarea>
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Canonical URL</label>
                <input type="url" name="canonical_url" value="{{ old('canonical_url', $service->canonical_url) }}" class="admin-input">
            </div>
        </div>
    </div>

    <div class="flex justify-end pt-4 gap-3">
        <a href="{{ route('admin.services.index') }}" class="text-gray-600 hover:text-gray-900 px-4 py-2">Cancel</a>
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium">
            Update Service
        </button>
    </div>
</form>

<script>
function addFeature() {
    const container = document.getElementById('features-list');
    const div = document.createElement('div');
    div.className = 'flex gap-2';
    div.innerHTML = '<input type="text" name="features[]" value="" class="admin-input flex-1" placeholder="e.g., REST API Development">' +
        '<button type="button" onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700">Remove</button>';
    container.appendChild(div);
}
</script>

<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/7/tinymce.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof tinymce !== 'undefined') {
        tinymce.init({
            selector: '#description',
            height: 300,
            menubar: false,
            plugins: 'lists link',
            toolbar: 'undo redo | bold italic underline | bullist numlist | link',
            branding: false,
        });
    }
});
</script>
@endsection
