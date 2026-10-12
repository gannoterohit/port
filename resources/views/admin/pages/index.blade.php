@extends('admin.layouts.master')

@section('title', 'Pages')
@section('header', 'CMS Pages')

@section('admin-content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-semibold text-gray-900">Manage Pages</h2>
    <a href="{{ route('admin.pages.create') }}"
        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
        Add Page
    </a>
</div>

<div class="bg-white rounded-xl border border-gray-200 p-4 mb-4">
    <form method="GET" class="flex gap-4 items-end">
        <div class="flex-1">
            <label class="block text-xs text-gray-500 mb-1">Search</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search pages..."
                class="admin-input">
        </div>
        <div>
            <label class="block text-xs text-gray-500 mb-1">Status</label>
            <select name="status" class="admin-input">
                <option value="">All</option>
                <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
                <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
            </select>
        </div>
        <button type="submit" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm">Filter</button>
    </form>
</div>

<div class="overflow-x-auto">
    <table class="w-full">
        <thead>
            <tr class="border-b border-gray-200">
                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase">Title</th>
                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase">Slug</th>
                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase">Nav Visible</th>
                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase">Status</th>
                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase">Order</th>
                <th class="text-right py-3 px-4 text-xs font-semibold text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pages as $page)
                <tr class="border-b border-gray-100">
                    <td class="py-3 px-4 font-medium text-gray-900">{{ $page->title }}</td>
                    <td class="py-3 px-4 text-sm text-gray-500">{{ $page->slug }}</td>
                    <td class="py-3 px-4">
                        @if($page->show_in_nav)
                            <span class="inline-flex px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">Yes</span>
                        @else
                            <span class="text-gray-400">No</span>
                        @endif
                    </td>
                    <td class="py-3 px-4">
                        @if($page->status === 'published')
                            <span class="inline-flex px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">Published</span>
                        @else
                            <span class="inline-flex px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded-full">Draft</span>
                        @endif
                    </td>
                    <td class="py-3 px-4 text-sm text-gray-500">{{ $page->display_order }}</td>
                    <td class="py-3 px-4 text-right">
                        <div class="flex justify-end items-center gap-2">
                            <a href="{{ route('page', $page->slug) }}" target="_blank" class="text-gray-500 hover:text-gray-700" title="View page">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </a>
                            <a href="{{ route('admin.pages.edit', $page) }}" class="text-blue-600 hover:text-blue-700" title="Edit page">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </a>
                            <form method="POST" action="{{ route('admin.pages.destroy', $page) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Delete this page?')"
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
                    <td colspan="6" class="text-center py-8 text-gray-500">No pages found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($pages->hasPages())
    <div class="mt-4">
        {{ $pages->links() }}
    </div>
@endif
@endsection
