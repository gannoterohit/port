@extends('admin.layouts.master')

@section('title', 'Add Skill')
@section('header', 'Add Skill')

@section('admin-content')
<form method="POST" action="{{ route('admin.skills.store') }}" class="max-w-3xl">
    @csrf

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

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Skill Name *</label>
                <input type="text" name="name" value="{{ old('name') }}" required class="admin-input">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                <select name="category_id" class="admin-input">
                    <option value="">Select Category</option>
                    @foreach(\App\Models\SkillCategory::where('is_enabled', true)->orderBy('display_order')->get() as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
            <textarea name="description" rows="2" class="admin-textarea"
                placeholder="Brief description of your expertise...">{{ old('description') }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Proficiency Level</label>
            <select name="proficiency" class="admin-input w-32">
                <option value="">Select Level</option>
                <option value="1" {{ old('proficiency') == 1 ? 'selected' : '' }}>1 - Beginner</option>
                <option value="2" {{ old('proficiency') == 2 ? 'selected' : '' }}>2 - Basic</option>
                <option value="3" {{ old('proficiency') == 3 ? 'selected' : '' }}>3 - Intermediate</option>
                <option value="4" {{ old('proficiency') == 4 ? 'selected' : '' }}>4 - Advanced</option>
                <option value="5" {{ old('proficiency') == 5 ? 'selected' : '' }}>5 - Expert</option>
            </select>
        </div>

        <div class="flex gap-6">
            <label class="flex items-center gap-2 text-sm text-gray-700">
                <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                Feature on Homepage
            </label>
            <label class="flex items-center gap-2 text-sm text-gray-700">
                <input type="checkbox" name="is_enabled" value="1" checked={{ !old('is_enabled', true) ? '' : 'checked' }}>
                Enabled
            </label>
        </div>
    </div>

    <div class="flex justify-end pt-4 gap-3">
        <a href="{{ route('admin.skills.index') }}" class="text-gray-600 hover:text-gray-900 px-4 py-2">Cancel</a>
        <button type="submit" class="bg-emerald-700 hover:bg-emerald-800 text-white px-6 py-3 rounded-lg font-medium">
            Create Skill
        </button>
    </div>
</form>
@endsection

