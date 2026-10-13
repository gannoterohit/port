@extends('admin.layouts.master')

@section('title', 'Edit Testimonial')
@section('header', 'Edit Testimonial')

@section('admin-content')
<form method="POST" action="{{ route('admin.testimonials.update', $testimonial) }}" enctype="multipart/form-data" class="max-w-3xl">
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

    <div class="bg-white rounded-xl border border-gray-200 p-6 space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="md:col-span-1">
                <label class="block text-sm font-medium text-gray-700 mb-1">Image</label>
                <div class="w-24 h-24 bg-gray-100 rounded-lg flex items-center justify-center mb-2 overflow-hidden">
                    @if($testimonial->image)
                        <img src="{{ $testimonial->image_url }}" alt="{{ $testimonial->name }}" class="w-24 h-24 object-cover">
                    @else
                        <span class="text-gray-400 text-xs text-center">{{ substr($testimonial->name, 0, 1) }}</span>
                    @endif
                </div>
                <input type="file" name="image" accept="image/*" class="admin-input">
                <p class="text-xs text-gray-500 mt-1">Upload new image (recommended: 100x100px)</p>
            </div>
            <div class="md:col-span-2 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Name *</label>
                    <input type="text" name="name" value="{{ old('name', $testimonial->name) }}" required class="admin-input">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Role / Company</label>
                    <input type="text" name="role_company" value="{{ old('role_company', $testimonial->role_company) }}" class="admin-input">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Feedback *</label>
                    <textarea name="feedback" rows="4" class="admin-textarea"
                        placeholder="What did they say about your work?">{{ old('feedback', $testimonial->feedback) }}</textarea>
                </div>
            </div>
        </div>

        <div class="flex gap-6">
            <label class="flex items-center gap-2 text-sm text-gray-700">
                <input type="checkbox" name="is_published" value="1" {{ $testimonial->is_published ? 'checked' : '' }}>
                Published
            </label>
        </div>
    </div>

    <div class="flex justify-end pt-4 gap-3">
        <a href="{{ route('admin.testimonials.index') }}" class="text-gray-600 hover:text-gray-900 px-4 py-2">Cancel</a>
        <button type="submit" class="bg-emerald-700 hover:bg-emerald-800 text-white px-6 py-3 rounded-lg font-medium">
            Update Testimonial
        </button>
    </div>
</form>
@endsection

