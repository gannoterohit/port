@extends('admin.layouts.master')

@section('title', 'Edit Skill Category')
@section('header', 'Edit Category')

@section('admin-content')
<form method="POST" action="{{ route('admin.skill-categories.update', $skillCategory) }}" class="max-w-2xl">
    @csrf
    @method('PUT')

    <div class="bg-white rounded-xl border border-gray-200 p-6 space-y-4">
        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm">
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Name *</label>
            <input type="text" name="name" value="{{ old('name', $skillCategory->name) }}" required class="admin-input">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Color</label>
            <input type="color" name="color" value="{{ old('color', $skillCategory->color ?? '#3b82f6') }}" class="w-12 h-8 p-0 border border-gray-300 rounded cursor-pointer">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Display Order</label>
            <input type="number" name="display_order" value="{{ old('display_order', $skillCategory->display_order) }}"
                class="admin-input w-20">
        </div>

        <label class="flex items-center gap-2 text-sm text-gray-700">
            <input type="checkbox" name="is_enabled" value="1" {{ $skillCategory->is_enabled ? 'checked' : '' }}>
            Enabled
        </label>
    </div>

    <div class="flex justify-end pt-4 gap-3">
        <a href="{{ route('admin.skill-categories.index') }}" class="text-gray-600 hover:text-gray-900 px-4 py-2">Cancel</a>
        <button type="submit" class="bg-emerald-700 hover:bg-emerald-800 text-white px-6 py-3 rounded-lg font-medium">
            Update Category
        </button>
    </div>
</form>
@endsection

