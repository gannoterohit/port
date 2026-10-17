@extends('admin.layouts.master')

@section('title', 'Pages')
@section('header', 'Custom Pages')

@section('admin-content')
<div class="space-y-6">

    <!-- Top Banner -->
    <div class="flex flex-col gap-4 rounded-2xl border border-[#E5E1D5] bg-gradient-to-br from-white to-[#FAF9F5] p-5 shadow-xs sm:flex-row sm:items-center sm:justify-between sm:p-6">
        <div>
            <div class="flex items-center gap-2">
                <span class="inline-flex h-2 w-2 rounded-full bg-[#B85D19]"></span>
                <p class="text-xs font-mono font-bold uppercase tracking-wider text-[#B85D19]">Content Management</p>
            </div>
            <h2 class="mt-1 text-xl font-bold tracking-tight text-stone-900 sm:text-2xl">Custom Website Pages</h2>
            <p class="mt-1 text-xs text-stone-500 sm:text-sm">Manage standalone pages such as Privacy Policy, Terms of Service, or Custom Landing pages.</p>
        </div>
        <div class="flex items-center gap-2.5">
            <a href="{{ route('admin.pages.create') }}" class="admin-btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>Add Page</span>
            </a>
        </div>
    </div>

    <!-- Filters & Search -->
    <div class="rounded-2xl border border-[#E5E1D5] bg-white p-4 shadow-xs">
        <form method="GET" class="flex flex-col gap-3 sm:flex-row sm:items-center">
            <div class="flex-1">
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search pages by title or slug..." class="admin-input pl-10 text-xs sm:text-sm">
                    <svg class="w-4 h-4 text-stone-400 absolute left-3.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="w-full sm:w-48">
                <select name="status" class="admin-input text-xs sm:text-sm">
                    <option value="">All Statuses</option>
                    <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published Only</option>
                    <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Drafts Only</option>
                </select>
            </div>
            <div class="flex items-center gap-2">
                <button type="submit" class="admin-btn-primary text-xs py-2.5">
                    Filter
                </button>
                @if(request('search') || request('status'))
                    <a href="{{ route('admin.pages.index') }}" class="admin-btn-secondary text-xs py-2.5">
                        Clear
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="overflow-hidden rounded-2xl border border-[#E5E1D5] bg-white shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-stone-700">
                <thead class="border-b border-[#E5E1D5] bg-[#FAF9F5] text-xs font-semibold uppercase tracking-wider text-stone-500">
                    <tr>
                        <th class="px-5 py-3.5">Page Title</th>
                        <th class="px-5 py-3.5">Slug URL</th>
                        <th class="px-5 py-3.5">Status</th>
                        <th class="px-5 py-3.5">Order</th>
                        <th class="px-5 py-3.5 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E5E1D5]">
                    @forelse($pages as $page)
                        <tr class="hover:bg-[#FAF9F5] transition-colors">
                            <td class="px-5 py-4 font-bold text-stone-900">
                                {{ $page->title }}
                            </td>
                            <td class="px-5 py-4 font-mono text-xs text-stone-500">
                                /{{ $page->slug }}
                            </td>
                            <td class="px-5 py-4">
                                @if($page->status === 'published')
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-bold text-emerald-700 border border-emerald-200">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                        Published
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 px-2.5 py-0.5 text-xs font-bold text-amber-700 border border-amber-200">
                                        Draft
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-4 font-mono text-xs text-stone-500">
                                #{{ $page->display_order }}
                            </td>
                            <td class="px-5 py-4 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('page', $page->slug) }}" target="_blank" class="rounded-lg p-1.5 text-stone-400 hover:bg-stone-100 hover:text-stone-700 transition" title="Preview page">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                        </svg>
                                    </a>
                                    <a href="{{ route('admin.pages.edit', $page) }}" class="rounded-lg p-1.5 text-[#B85D19] hover:bg-[#B85D19]/10 transition" title="Edit page">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    <form method="POST" action="{{ route('admin.pages.destroy', $page) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Delete this page?')" class="rounded-lg p-1.5 text-stone-400 hover:bg-rose-50 hover:text-rose-600 transition" title="Delete page">
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
                            <td colspan="5" class="px-5 py-12 text-center">
                                <div class="mx-auto max-w-sm text-center">
                                    <p class="text-sm font-bold text-stone-900">No custom pages found</p>
                                    <p class="mt-1 text-xs text-stone-500">Create custom pages like Privacy Policy or Terms.</p>
                                    <a href="{{ route('admin.pages.create') }}" class="admin-btn-primary mt-4 text-xs">
                                        + Add Page
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($pages->hasPages())
            <div class="border-t border-[#E5E1D5] px-5 py-3">
                {{ $pages->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
