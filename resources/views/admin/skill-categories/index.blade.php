@extends('admin.layouts.master')

@section('title', 'Skill Categories')
@section('header', 'Skill Categories')

@section('admin-content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-semibold text-gray-900">Manage Skill Categories</h2>
    <a href="{{ route('admin.skill-categories.create') }}"
        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
        Add Category
    </a>
</div>

<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    <table class="w-full">
        <thead>
            <tr class="border-b border-gray-200">
                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase">Name</th>
                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase">Slug</th>
                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase">Color</th>
                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase">Skills Count</th>
                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase">Order</th>
                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase">Status</th>
                <th class="text-right py-3 px-4 text-xs font-semibold text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $category)
                <tr class="border-b border-gray-100">
                    <td class="py-3 px-4 font-medium text-gray-900">{{ $category->name }}</td>
                    <td class="py-3 px-4 text-sm text-gray-500">{{ $category->slug }}</td>
                    <td class="py-3 px-4">
                        <div class="w-5 h-5 rounded-full" style="background-color: {{ $category->color }}"></div>
                    </td>
                    <td class="py-3 px-4 text-sm text-gray-500">{{ $category->skills->count() }}</td>
                    <td class="py-3 px-4 text-sm text-gray-500">{{ $category->display_order }}</td>
                    <td class="py-3 px-4">
                        @if($category->is_enabled)
                            <span class="inline-flex px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">Enabled</span>
                        @else
                            <span class="inline-flex px-2 py-1 text-xs bg-gray-100 text-gray-600 rounded-full">Disabled</span>
                        @endif
                    </td>
                    <td class="py-3 px-4 text-right">
                        <div class="flex justify-end gap-1">
                            <a href="{{ route('admin.skill-categories.edit', $category) }}" class="text-blue-600 hover:text-blue-700" title="Edit category">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </a>
                            <form method="POST" action="{{ route('admin.skill-categories.destroy', $category) }}" class="inline">
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
                    <td colspan="7" class="text-center py-8 text-gray-500">No categories found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
