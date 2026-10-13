@extends('admin.layouts.master')

@section('title', 'Edit Skill')
@section('header', 'Edit Skill')

@section('admin-content')
<form method="POST" action="{{ route('admin.skills.update', $skill) }}" class="max-w-3xl">
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

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Skill Name *</label>
                <input type="text" name="name" value="{{ old('name', $skill->name) }}" required class="admin-input">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                <select name="category_id" class="admin-input">
                    <option value="">Select Category</option>
                    @foreach(\App\Models\SkillCategory::where('is_enabled', true)->orderBy('display_order')->get() as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id', $skill->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
            <textarea name="description" rows="2" class="admin-textarea"
                placeholder="Brief description of your expertise...">{{ old('description', $skill->description) }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Proficiency Level</label>
            <select name="proficiency" class="admin-input w-32">
                <option value="">Select Level</option>
                @for($i = 1; $i <= 5; $i++)
                    <option value="{{ $i }}" {{ old('proficiency', $skill->proficiency) == $i ? 'selected' : '' }}>
                        {{ $i }} - {{ ['','Beginner','Basic','Intermediate','Advanced','Expert'][$i] }}
                    </option>
                @endfor
            </select>
        </div>

        <div class="flex gap-6">
            <label class="flex items-center gap-2 text-sm text-gray-700">
                <input type="checkbox" name="is_featured" value="1" {{ $skill->is_featured ? 'checked' : '' }}>
                Feature on Homepage
            </label>
            <label class="flex items-center gap-2 text-sm text-gray-700">
                <input type="checkbox" name="is_enabled" value="1" {{ $skill->is_enabled ? 'checked' : '' }}>
                Enabled
            </label>
        </div>
    </div>

    <div class="flex justify-end pt-4 gap-3">
        <a href="{{ route('admin.skills.index') }}" class="text-gray-600 hover:text-gray-900 px-4 py-2">Cancel</a>
        <button type="submit" class="bg-emerald-700 hover:bg-emerald-800 text-white px-6 py-3 rounded-lg font-medium">
            Update Skill
        </button>
    </div>
</form>
@endsection

