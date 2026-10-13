@extends('admin.layouts.master')

@section('title', 'Projects')
@section('header', 'Projects Management')

@section('admin-content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-semibold text-gray-900">Manage Projects</h2>
    <a href="{{ route('admin.projects.create') }}"
        class="bg-emerald-700 hover:bg-emerald-800 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
        Add Project
    </a>
</div>

<div class="bg-white rounded-xl border border-gray-200 p-4 mb-4">
    <form method="GET" class="flex gap-4 items-end">
        <div class="flex-1">
            <label class="block text-xs text-gray-500 mb-1">Search</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search projects..."
                class="admin-input">
        </div>
        <div>
            <label class="block text-xs text-gray-500 mb-1">Status</label>
            <select name="status_filter" class="admin-input">
                <option value="">All Statuses</option>
                <option value="published" {{ request('status_filter') === 'published' ? 'selected' : '' }}>Published</option>
                <option value="draft" {{ request('status_filter') === 'draft' ? 'selected' : '' }}>Draft</option>
            </select>
        </div>
        <button type="submit" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm">Filter</button>
    </form>
</div>

<div class="overflow-x-auto">
    <table class="w-full">
        <thead>
            <tr class="border-b border-gray-200">
                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase">Project</th>
                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase">Category</th>
                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase">Status</th>
                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase">Featured</th>
                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase">Order</th>
                <th class="text-right py-3 px-4 text-xs font-semibold text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($projects as $project)
                <tr class="border-b border-gray-100">
                    <td class="py-3 px-4">
                        <div class="flex items-center gap-3">
                            @if($project->thumbnail)
                                <img src="{{ $project->thumbnail_url }}" alt="{{ $project->title }}" class="w-10 h-10 rounded-lg object-cover">
                            @else
                                <div class="w-10 h-10 bg-gray-200 rounded-lg flex items-center justify-center text-gray-500">No Image</div>
                            @endif
                            <div>
                                <span class="font-medium text-gray-900">{{ $project->title }}</span>
                                <span class="text-xs text-gray-500 block">{{ $project->tech_stack ? implode(', ', $project->tech_stack) : '' }}</span>
                            </div>
                        </div>
                    </td>
                    <td class="py-3 px-4 text-sm text-gray-700">{{ $project->category ?? '—' }}</td>
                    <td class="py-3 px-4">
                        <span class="inline-flex px-2 py-1 text-xs rounded-full {{ $project->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ $project->status_label }}
                        </span>
                    </td>
                    <td class="py-3 px-4">
                        @if($project->is_featured)
                            <span class="inline-flex px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded-full">Yes</span>
                        @else
                            <span class="text-gray-400">No</span>
                        @endif
                    </td>
                    <td class="py-3 px-4 text-sm text-gray-500">{{ $project->display_order }}</td>
                    <td class="py-3 px-4 text-right">
                        <div class="flex justify-end items-center gap-2">
                            <a href="{{ route('projects.show', $project->slug) }}" target="_blank" class="text-gray-500 hover:text-gray-700" title="View on site">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </a>
                            <a href="{{ route('admin.projects.edit', $project) }}" class="text-emerald-700 hover:text-emerald-800" title="Edit project">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </a>
                            <form method="POST" action="{{ route('admin.projects.destroy', $project) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure you want to delete this project? This will also delete all associated screenshots.')"
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
                    <td colspan="6" class="text-center py-8 text-gray-500">No projects found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($projects->hasPages())
    <div class="mt-4">
        {{ $projects->links() }}
    </div>
@endif
@endsection

