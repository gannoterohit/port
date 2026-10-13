@extends('admin.layouts.master')

@section('title', 'Skills')
@section('header', 'Skills Management')

@section('admin-content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-semibold text-gray-900">Manage Skills</h2>
    <div class="flex gap-3">
        <a href="{{ route('admin.skill-categories.index') }}"
            class="bg-purple-100 hover:bg-purple-200 text-purple-700 px-4 py-2 rounded-lg text-sm font-medium transition-colors">
            Manage Categories
        </a>
        <a href="{{ route('admin.skills.create') }}"
            class="bg-emerald-700 hover:bg-emerald-800 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
            Add Skill
        </a>
    </div>
</div>

<div class="bg-white rounded-xl border border-gray-200 p-4 mb-4">
    <form method="GET" class="flex gap-4 items-end">
        <div class="flex-1">
            <label class="block text-xs text-gray-500 mb-1">Search</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search skills..."
                class="admin-input">
        </div>
        <div>
            <label class="block text-xs text-gray-500 mb-1">Category</label>
            <select name="category_id" class="admin-input">
                <option value="">All Categories</option>
                <option value="" disabled>---
                @foreach(\App\Models\SkillCategory::where('is_enabled', true)->get() as $cat)
                    <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-xs text-gray-500 mb-1">Status</label>
            <select name="status" class="admin-input">
                <option value="">All</option>
                <option value="enabled" {{ request('status') === 'enabled' ? 'selected' : '' }}>Enabled</option>
                <option value="disabled" {{ request('status') === 'disabled' ? 'selected' : '' }}>Disabled</option>
            </select>
        </div>
        <button type="submit" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm">Filter</button>
    </form>
</div>

<div class="overflow-x-auto">
    <table class="w-full">
        <thead>
            <tr class="border-b border-gray-200">
                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase">Skill</th>
                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase">Category</th>
                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase">Proficiency</th>
                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase">Featured</th>
                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase">Status</th>
                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase">Order</th>
                <th class="text-right py-3 px-4 text-xs font-semibold text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($skills as $skill)
                <tr class="border-b border-gray-100">
                    <td class="py-3 px-4">
                        <div>
                            <span class="font-medium text-gray-900">{{ $skill->name }}</span>
                            <span class="text-xs text-gray-500 block">{{ Str::limit($skill->description, 60) }}</span>
                        </div>
                    </td>
                    <td class="py-3 px-4">
                        @if($skill->category)
                            <span class="inline-flex px-2 py-1 text-xs rounded-full" style="background-color: {{ $skill->category->color }}20; color: {{ $skill->category->color }}">
                                {{ $skill->category->name }}
                            </span>
                        @else
                            <span class="text-gray-400">—</span>
                        @endif
                    </td>
                    <td class="py-3 px-4">
                        <span class="text-sm text-gray-700">{{ $skill->proficiency_label ?: '—' }}</span>
                    </td>
                    <td class="py-3 px-4">
                        @if($skill->is_featured)
                            <span class="inline-flex px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded-full">Yes</span>
                        @else
                            <span class="text-gray-400">No</span>
                        @endif
                    </td>
                    <td class="py-3 px-4">
                        @if($skill->is_enabled)
                            <span class="inline-flex px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">Enabled</span>
                        @else
                            <span class="inline-flex px-2 py-1 text-xs bg-gray-100 text-gray-600 rounded-full">Disabled</span>
                        @endif
                    </td>
                    <td class="py-3 px-4">
                        <span class="text-sm text-gray-500">{{ $skill->display_order }}</span>
                    </td>
                    <td class="py-3 px-4 text-right">
                        <div class="flex justify-end gap-1">
                            <a href="{{ route('admin.skills.edit', $skill) }}" class="text-emerald-700 hover:text-emerald-800" title="Edit skill">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </a>
                            <form method="POST" action="{{ route('admin.skills.destroy', $skill) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure?')"
                                    class="text-red-600 hover:text-red-700">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.133A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.86L5 7m5 5v6m4-6v6m1-10V4a1 1 0 00-1-1h-2a1 1 0 00-1 1v3m-4 0h6"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center py-8 text-gray-500">No skills found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($skills->hasPages())
    <div class="mt-4">
        {{ $skills->links() }}
    </div>
@endif
@endsection

