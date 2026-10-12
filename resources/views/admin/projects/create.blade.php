@extends('admin.layouts.master')

@section('title', 'Add Project')
@section('header', 'Add Project')

@section('admin-content')
<form method="POST" action="{{ route('admin.projects.store') }}" enctype="multipart/form-data" class="space-y-6">
    @csrf

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
                <label class="block text-sm font-medium text-gray-700 mb-1">Project Title *</label>
                <input type="text" name="title" value="{{ old('title') }}" required class="admin-input">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
                <input type="text" name="slug" value="{{ old('slug') }}" class="admin-input"
                    placeholder="Leave empty to auto-generate">
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                <input type="text" name="category" value="{{ old('category') }}" class="admin-input"
                    placeholder="e.g., E-commerce, Web Application, Mobile App">
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Thumbnail</h3>
        <div class="flex items-center gap-6">
            <div class="flex items-center justify-center w-32 h-32 bg-gray-100 rounded-lg border-2 border-dashed border-gray-300">
                <span class="text-gray-400 text-sm text-center">Thumbnail Preview</span>
            </div>
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-1">Upload Thumbnail</label>
                <input type="file" name="thumbnail" accept="image/*" class="admin-input">
                <p class="text-xs text-gray-500 mt-1">Recommended size: 800x600px. Max: 5MB.</p>
                <div class="mt-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alt Text</label>
                    <input type="text" name="thumbnail_alt" value="{{ old('thumbnail_alt') }}" class="admin-input">
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Project Description</h3>
        <textarea name="description" id="description" rows="8" class="admin-textarea"
            placeholder="Full project description...">{{ old('description') }}</textarea>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Technology Stack</h3>
        <div id="tech-stack" class="space-y-2">
            <div class="flex gap-2">
                <input type="text" name="tech_stack[]" value="" class="admin-input flex-1"
                    placeholder="e.g., Laravel, React, MySQL">
            </div>
        </div>
        <button type="button" onclick="addTechStack()"
            class="mt-2 text-blue-600 hover:text-blue-700 text-sm font-medium">
            + Add Another
        </button>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Details</h3>
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Purpose</label>
                <textarea name="purpose" rows="3" class="admin-textarea"
                    placeholder="What was the project purpose?">{{ old('purpose') }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Key Features</label>
                <textarea name="key_features" rows="3" class="admin-textarea"
                    placeholder="List the key features...">{{ old('key_features') }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Your Role</label>
                <textarea name="role" rows="3" class="admin-textarea"
                    placeholder="Describe your role and contributions...">{{ old('role') }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Challenges & Solutions</label>
                <textarea name="challenges" rows="3" class="admin-textarea"
                    placeholder="What challenges did you face?">{{ old('challenges') }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Solutions</label>
                <textarea name="solutions" rows="3" class="admin-textarea"
                    placeholder="How did you solve the challenges?">{{ old('solutions') }}</textarea>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Links</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Live Demo URL</label>
                <input type="url" name="demo_url" value="{{ old('demo_url') }}" class="admin-input"
                    placeholder="https://example.com">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">GitHub URL</label>
                <input type="url" name="github_url" value="{{ old('github_url') }}" class="admin-input"
                    placeholder="https://github.com/username/repo">
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Screenshots</h3>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Upload Screenshots</label>
            <input type="file" name="screenshots[]" accept="image/*" multiple class="admin-input">
            <p class="text-xs text-gray-500 mt-1">Upload multiple screenshots. Max 5MB each.</p>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Publishing</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" class="admin-input">
                    <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Published</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Display Order</label>
                <input type="number" name="display_order" value="{{ old('display_order', \App\Models\Project::max('display_order') + 1) }}"
                    class="admin-input w-20">
            </div>
        </div>

        <div class="flex gap-6 mt-3">
            <label class="flex items-center gap-2 text-sm text-gray-700">
                <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                Feature on Homepage
            </label>
            <label class="flex items-center gap-2 text-sm text-gray-700">
                <input type="checkbox" name="no_index" value="1" {{ old('no_index') ? 'checked' : '' }}>
                No Index (SEO)
            </label>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">SEO Metadata</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">SEO Title</label>
                <input type="text" name="seo_title" value="{{ old('seo_title') }}" class="admin-input"
                    placeholder="Defaults to project title">
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">SEO Description</label>
                <textarea name="seo_description" rows="2" class="admin-textarea"
                    placeholder="Meta description for search engines...">{{ old('seo_description') }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">OG Title</label>
                <input type="text" name="og_title" value="{{ old('og_title') }}" class="admin-input">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">OG Image</label>
                <input type="file" name="og_image" accept="image/*" class="admin-input">
                <p class="text-xs text-gray-500 mt-1">1200x630px recommended</p>
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">OG Description</label>
                <textarea name="og_description" rows="2" class="admin-textarea">{{ old('og_description') }}</textarea>
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Canonical URL</label>
                <input type="url" name="canonical_url" value="{{ old('canonical_url') }}" class="admin-input"
                    placeholder="https://example.com/canonical-url">
            </div>
        </div>
    </div>

    <div class="flex justify-end pt-4 gap-3">
        <a href="{{ route('admin.projects.index') }}" class="text-gray-600 hover:text-gray-900 px-4 py-2">Cancel</a>
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium">
            Create Project
        </button>
    </div>
</form>

<script>
function addTechStack() {
    const container = document.getElementById('tech-stack');
    const div = document.createElement('div');
    div.className = 'flex gap-2';
    div.innerHTML = '<input type="text" name="tech_stack[]" value="" class="admin-input flex-1" placeholder="e.g., Laravel, Vue, AWS">' +
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
