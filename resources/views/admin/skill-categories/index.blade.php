@extends('admin.layouts.master')

@section('title', 'Skill Categories')
@section('header', 'Skill Categories')

@section('admin-content')
<div class="space-y-6">

    <!-- Top Banner -->
    <div class="flex flex-col gap-4 rounded-2xl border border-[#E5E1D5] bg-gradient-to-br from-white to-[#FAF9F5] p-5 shadow-xs sm:flex-row sm:items-center sm:justify-between sm:p-6">
        <div>
            <div class="flex items-center gap-2">
                <span class="inline-flex h-2 w-2 rounded-full bg-[#B85D19]"></span>
                <p class="text-xs font-mono font-bold uppercase tracking-wider text-[#B85D19]">Taxonomy &amp; Grouping</p>
            </div>
            <h2 class="mt-1 text-xl font-bold tracking-tight text-stone-900 sm:text-2xl">Skill Categories</h2>
            <p class="mt-1 text-xs text-stone-500 sm:text-sm">Group your tools into Backend, Frontend, Databases, DevOps, etc.</p>
        </div>
        <div class="flex items-center gap-2.5">
            <a href="{{ route('admin.skills.index') }}" class="admin-btn-secondary">
                Back to Skills
            </a>
            <a href="{{ route('admin.skill-categories.create') }}" class="admin-btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>Add Category</span>
            </a>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-hidden rounded-2xl border border-[#E5E1D5] bg-white shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-stone-700">
                <thead class="border-b border-[#E5E1D5] bg-[#FAF9F5] text-xs font-semibold uppercase tracking-wider text-stone-500">
                    <tr>
                        <th class="px-5 py-3.5">Category Name</th>
                        <th class="px-5 py-3.5">Slug</th>
                        <th class="px-5 py-3.5">Color Accent</th>
                        <th class="px-5 py-3.5">Skills Count</th>
                        <th class="px-5 py-3.5">Status</th>
                        <th class="px-5 py-3.5">Order</th>
                        <th class="px-5 py-3.5 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E5E1D5]">
                    @forelse($categories as $category)
                        <tr class="hover:bg-[#FAF9F5] transition-colors">
                            <td class="px-5 py-4 font-bold text-stone-900">
                                {{ $category->name }}
                            </td>
                            <td class="px-5 py-4 font-mono text-xs text-stone-500">
                                {{ $category->slug }}
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-2">
                                    <div class="h-4 w-4 rounded-full shadow-xs border border-black/10" style="background-color: {{ $category->color }}"></div>
                                    <span class="font-mono text-xs text-stone-600">{{ $category->color }}</span>
                                </div>
                            </td>
                            <td class="px-5 py-4">
                                <span class="rounded-lg bg-stone-100 px-2.5 py-0.5 text-xs font-bold text-stone-700 border border-stone-200">
                                    {{ $category->skills->count() }} skills
                                </span>
                            </td>
                            <td class="px-5 py-4">
                                @if($category->is_enabled)
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-bold text-emerald-700 border border-emerald-200">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                        Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-stone-100 px-2.5 py-0.5 text-xs font-bold text-stone-600 border border-stone-200">
                                        Disabled
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-4 font-mono text-xs text-stone-500">
                                #{{ $category->display_order }}
                            </td>
                            <td class="px-5 py-4 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('admin.skill-categories.edit', $category) }}" class="rounded-lg p-1.5 text-[#B85D19] hover:bg-[#B85D19]/10 transition" title="Edit category">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    <form method="POST" action="{{ route('admin.skill-categories.destroy', $category) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Delete this category?')" class="rounded-lg p-1.5 text-stone-400 hover:bg-rose-50 hover:text-rose-600 transition" title="Delete category">
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
                            <td colspan="7" class="px-5 py-12 text-center">
                                <div class="mx-auto max-w-sm text-center">
                                    <p class="text-sm font-bold text-stone-900">No categories found</p>
                                    <a href="{{ route('admin.skill-categories.create') }}" class="admin-btn-primary mt-4 text-xs">
                                        + Add Category
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
