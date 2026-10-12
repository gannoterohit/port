@extends('admin.layouts.master')

@section('title', 'Edit Project')
@section('header', 'Edit Project')

@section('admin-content')
<form method="POST" action="{{ route('admin.projects.update', $project) }}" enctype="multipart/form-data" class="space-y-6">
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
                <label class="block text-sm font-medium text-gray-700 mb-1">Project Title *</label>
                <input type="text" name="title" value="{{ old('title', $project->title) }}" required class="admin-input">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
                <input type="text" name="slug" value="{{ old('slug', $project->slug) }}" class="admin-input">
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                <input type="text" name="category" value="{{ old('category', $project->category) }}" class="admin-input">
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Thumbnail</h3>
        <div class="flex items-center gap-6">
            <div class="flex items-center justify-center w-32 h-32 bg-gray-100 rounded-lg border-2 border-dashed border-gray-300 overflow-hidden">
                @if($project->thumbnail)
                    <img src="{{ $project->thumbnail_url }}" alt="Thumbnail" class="w-32 h-32 object-cover">
                @else
                    <span class="text-gray-400 text-sm">No Thumbnail</span>
                @endif
            </div>
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-1">Change Thumbnail</label>
                <input type="file" name="thumbnail" accept="image/*" class="admin-input">
                <p class="text-xs text-gray-500 mt-1">Recommended size: 800x600px. Max: 5MB.</p>
                <div class="mt-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alt Text</label>
                    <input type="text" name="thumbnail_alt" value="{{ old('thumbnail_alt', $project->thumbnail_alt) }}" class="admin-input">
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Project Description</h3>
        <textarea name="description" id="description" rows="8" class="admin-textarea"
            placeholder="Full project description...">{{ old('description', $project->description) }}</textarea>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Technology Stack</h3>
        <div id="tech-stack" class="space-y-2">
            @if(old('tech_stack', $project->tech_stack))
                @foreach(old('tech_stack', $project->tech_stack) as $tech)
                    <div class="flex gap-2">
                        <input type="text" name="tech_stack[]" value="{{ $tech }}" class="admin-input flex-1"
                            placeholder="e.g., Laravel, React, MySQL">
                        <button type="button" onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700">Remove</button>
                    </div>
                @endforeach
            @else
                <div class="flex gap-2">
                    <input type="text" name="tech_stack[]" value="" class="admin-input flex-1"
                        placeholder="e.g., Laravel, React, MySQL">
                </div>
            @endif
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
                    placeholder="What was the project purpose?">{{ old('purpose', $project->purpose) }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Key Features</label>
                <textarea name="key_features" rows="3" class="admin-textarea"
                    placeholder="List the key features...">{{ old('key_features', $project->key_features) }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Your Role</label>
                <textarea name="role" rows="3" class="admin-textarea"
                    placeholder="Describe your role and contributions...">{{ old('role', $project->role) }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Challenges</label>
                <textarea name="challenges" rows="3" class="admin-textarea"
                    placeholder="What challenges did you face?">{{ old('challenges', $project->challenges) }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Solutions</label>
                <textarea name="solutions" rows="3" class="admin-textarea"
                    placeholder="How did you solve the challenges?">{{ old('solutions', $project->solutions) }}</textarea>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Links</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Live Demo URL</label>
                <input type="url" name="demo_url" value="{{ old('demo_url', $project->demo_url) }}" class="admin-input">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">GitHub URL</label>
                <input type="url" name="github_url" value="{{ old('github_url', $project->github_url) }}" class="admin-input">
            </div>
        </div>
    </div>

    @if($project->screenshots && $project->screenshots->count() > 0)
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Existing Screenshots</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach($project->screenshots as $screenshot)
                    <div class="relative group">
                        <img src="{{ $screenshot->image_url }}" alt="{{ $screenshot->alt_text }}" class="w-full h-24 object-cover rounded-lg">
                        <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 rounded-lg flex items-center justify-center transition-opacity">
                            <form method="POST" action="{{ route('admin.project-screenshots.destroy', $screenshot) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Delete this screenshot?')"
                                    class="text-white hover:text-red-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.133A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.86L5 7m5 5v6m4-6v6m1-10V4a1 1 0 00-1-1h-2a1 1 0 00-1 1v3m-4 0h6"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Add More Screenshots</h3>
        <input type="file" name="screenshots[]" accept="image/*" multiple class="admin-input">
        <p class="text-xs text-gray-500 mt-1">Upload additional screenshots. Max 5MB each.</p>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Publishing</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" class="admin-input">
                    <option value="draft" {{ old('status', $project->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ old('status', $project->status) === 'published' ? 'selected' : '' }}>Published</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Display Order</label>
                <input type="number" name="display_order" value="{{ old('display_order', $project->display_order) }}"
                    class="admin-input w-20">
            </div>
        </div>
        <div class="flex gap-6 mt-3">
            <label class="flex items-center gap-2 text-sm text-gray-700">
                <input type="checkbox" name="is_featured" value="1" {{ $project->is_featured ? 'checked' : '' }}>
                Feature on Homepage
            </label>
            <label class="flex items-center gap-2 text-sm text-gray-700">
                <input type="checkbox" name="no_index" value="1" {{ $project->no_index ? 'checked' : '' }}>
                No Index (SEO)
            </label>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">SEO Metadata</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">SEO Title</label>
                <input type="text" name="seo_title" value="{{ old('seo_title', $project->seo_title) }}" class="admin-input">
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">SEO Description</label>
                <textarea name="seo_description" rows="2" class="admin-textarea">{{ old('seo_description', $project->seo_description) }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">OG Title</label>
                <input type="text" name="og_title" value="{{ old('og_title', $project->og_title) }}" class="admin-input">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">OG Image</label>
                @if($project->og_image)
                    <img src="{{ $project->og_image_url }}" alt="OG Image" class="w-20 h-20 object-cover rounded-lg mb-2">
                @endif
                <input type="file" name="og_image" accept="image/*" class="admin-input">
                <p class="text-xs text-gray-500 mt-1">1200x630px recommended</p>
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">OG Description</label>
                <textarea name="og_description" rows="2" class="admin-textarea">{{ old('og_description', $project->og_description) }}</textarea>
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Canonical URL</label>
                <input type="url" name="canonical_url" value="{{ old('canonical_url', $project->canonical_url) }}" class="admin-input">
            </div>
        </div>
    </div>

    <div class="flex justify-end pt-4 gap-3">
        <a href="{{ route('admin.projects.index') }}" class="text-gray-600 hover:text-gray-900 px-4 py-2">Cancel</a>
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium">
            Update Project
        </button>
    </div>
</form>

<script>
function addTechStack() {
    const container = document.getElementById('tech-stack');
    const div = document.createElement('div');
    div.className = 'flex gap-2';
    div.innerHTML = '<input type="text" name="tech_stack[]" value="" class="admin-input flex-1" placeholder="e.g., Laravel, React, MySQL">' +
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
