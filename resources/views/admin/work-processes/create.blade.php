@extends('admin.layouts.master')

@section('title', 'Add Work Process')
@section('header', 'Add Work Process Step')

@section('admin-content')
<form method="POST" action="{{ route('admin.work-processes.store') }}" enctype="multipart/form-data" class="max-w-2xl">
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

    <div class="bg-white rounded-xl border border-gray-200 p-6 space-y-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Title *</label>
            <input type="text" name="title" value="{{ old('title') }}" required class="admin-input">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
            <textarea name="description" rows="3" class="admin-textarea"
                placeholder="What happens in this step?">{{ old('description') }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Icon</label>
            <input type="file" name="icon" accept="image/*" class="admin-input">
            <p class="text-xs text-gray-500 mt-1">Recommended: 64x64px. Max: 1MB.</p>
        </div>

        <div class="flex items-center gap-2">
            <input type="checkbox" name="is_enabled" value="1" checked>
            <label class="text-sm text-gray-700">Enabled</label>
        </div>
    </div>

    <div class="flex justify-end pt-4 gap-3">
        <a href="{{ route('admin.work-processes.index') }}" class="text-gray-600 hover:text-gray-900 px-4 py-2">Cancel</a>
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium">
            Create Step
        </button>
    </div>
</form>
@endsection
