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
                        <div class="flex justify-end gap-1">
                            <a href="{{ $page->show_in_nav ? '#' : '#' }}" class="text-gray-400 cursor-not-allowed">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.441-9.5L11 13.55L6.44 19H5.44L0.88 13.44L5.44 8.88L10.56 13.44L15.12 7.44L19.5 11.82V8L21.44 6.44L18 3L15.12 7.44Z"></path>
                                </svg>
                            </a>
                            <a href="{{ route('admin.pages.edit', $page) }}" class="text-blue-600 hover:text-blue-700">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.441-9.5L11 13.55L6.44 19H5.44L0.88 13.44L5.44 8.88L10.56 13.44L15.12 7.44L19.5 11.82V8L21.44 6.44L18 3L15.12 7.44Z"></path>
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
