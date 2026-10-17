@extends('admin.layouts.master')

@section('title', 'Projects')
@section('header', 'Portfolio Projects')

@section('admin-content')
<div class="space-y-6">

    <!-- Top Banner -->
    <div class="flex flex-col gap-4 rounded-2xl border border-[#E5E1D5] bg-gradient-to-br from-white to-[#FAF9F5] p-5 shadow-xs sm:flex-row sm:items-center sm:justify-between sm:p-6">
        <div>
            <div class="flex items-center gap-2">
                <span class="inline-flex h-2 w-2 rounded-full bg-[#B85D19]"></span>
                <p class="text-xs font-mono font-bold uppercase tracking-wider text-[#B85D19]">Work Showcase</p>
            </div>
            <h2 class="mt-1 text-xl font-bold tracking-tight text-stone-900 sm:text-2xl">Project Catalog &amp; Case Studies</h2>
            <p class="mt-1 text-xs text-stone-500 sm:text-sm">Manage featured showcase items, technology stacks, galleries, and live demo links.</p>
        </div>
        <div class="flex items-center gap-2.5">
            <a href="{{ route('admin.projects.create') }}" class="admin-btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>Add New Project</span>
            </a>
        </div>
    </div>

    <!-- Filters & Search -->
    <div class="rounded-2xl border border-[#E5E1D5] bg-white p-4 shadow-xs">
        <form method="GET" class="flex flex-col gap-3 sm:flex-row sm:items-center">
            <div class="flex-1">
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by title, technology or category..." class="admin-input pl-10 text-xs sm:text-sm">
                    <svg class="w-4 h-4 text-stone-400 absolute left-3.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="w-full sm:w-48">
                <select name="status_filter" class="admin-input text-xs sm:text-sm">
                    <option value="">All Statuses</option>
                    <option value="published" {{ request('status_filter') === 'published' ? 'selected' : '' }}>Published Only</option>
                    <option value="draft" {{ request('status_filter') === 'draft' ? 'selected' : '' }}>Drafts Only</option>
                </select>
            </div>
            <div class="flex items-center gap-2">
                <button type="submit" class="admin-btn-primary text-xs py-2.5">
                    Filter
                </button>
                @if(request('search') || request('status_filter'))
                    <a href="{{ route('admin.projects.index') }}" class="admin-btn-secondary text-xs py-2.5">
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
                        <th class="px-5 py-3.5">Project Details</th>
                        <th class="px-5 py-3.5">Category</th>
                        <th class="px-5 py-3.5">Status</th>
                        <th class="px-5 py-3.5">Featured</th>
                        <th class="px-5 py-3.5">Order</th>
                        <th class="px-5 py-3.5 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E5E1D5]">
                    @forelse($projects as $project)
                        <tr class="hover:bg-[#FAF9F5] transition-colors">
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3.5">
                                    @if($project->thumbnail)
                                        <img src="{{ $project->thumbnail_url }}" alt="{{ $project->title }}" class="h-12 w-14 rounded-xl border border-[#E5E1D5] object-cover shrink-0 shadow-xs">
                                    @else
                                        <div class="h-12 w-14 rounded-xl border border-dashed border-stone-300 bg-stone-50 flex items-center justify-center text-stone-400 text-[10px] shrink-0 font-medium">
                                            No Img
                                        </div>
                                    @endif
                                    <div class="min-w-0">
                                        <span class="block font-bold text-stone-900 truncate max-w-xs">{{ $project->title }}</span>
                                        @if($project->tech_stack && is_array($project->tech_stack))
                                            <div class="flex flex-wrap gap-1 mt-1">
                                                @foreach(array_slice($project->tech_stack, 0, 3) as $tech)
                                                    <span class="rounded bg-stone-100 px-1.5 py-0.5 text-[10px] font-medium text-stone-600 border border-stone-200">{{ $tech }}</span>
                                                @endforeach
                                                @if(count($project->tech_stack) > 3)
                                                    <span class="text-[10px] text-stone-400">+{{ count($project->tech_stack) - 3 }}</span>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-4">
                                <span class="rounded-lg bg-stone-100 px-2.5 py-1 text-xs font-semibold text-stone-700 border border-stone-200">
                                    {{ $project->category ?? 'General' }}
                                </span>
                            </td>
                            <td class="px-5 py-4">
                                @if($project->status === 'published')
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-bold text-emerald-700 border border-emerald-200">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                        Published
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 px-2.5 py-0.5 text-xs font-bold text-amber-700 border border-amber-200">
                                        <span class="h-1.5 w-1.5 rounded-full bg-amber-400"></span>
                                        Draft
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-4">
                                @if($project->is_featured)
                                    <span class="inline-flex items-center gap-1 text-xs font-bold text-[#B85D19]">
                                        <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                        Homepage
                                    </span>
                                @else
                                    <span class="text-xs text-stone-400">—</span>
                                @endif
                            </td>
                            <td class="px-5 py-4 font-mono text-xs text-stone-500">
                                #{{ $project->display_order }}
                            </td>
                            <td class="px-5 py-4 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('projects.show', $project->slug) }}" target="_blank" class="rounded-lg p-1.5 text-stone-400 hover:bg-stone-100 hover:text-stone-700 transition" title="Preview on live site">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                        </svg>
                                    </a>
                                    <a href="{{ route('admin.projects.edit', $project) }}" class="rounded-lg p-1.5 text-[#B85D19] hover:bg-[#B85D19]/10 transition" title="Edit project">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    <form method="POST" action="{{ route('admin.projects.destroy', $project) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Delete this project and its screenshots?')" class="rounded-lg p-1.5 text-stone-400 hover:bg-rose-50 hover:text-rose-600 transition" title="Delete project">
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
                            <td colspan="6" class="px-5 py-12 text-center">
                                <div class="mx-auto max-w-sm text-center">
                                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-stone-100 text-stone-400">
                                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                        </svg>
                                    </div>
                                    <p class="mt-3 text-sm font-bold text-stone-900">No projects found</p>
                                    <p class="mt-1 text-xs text-stone-500">Get started by creating your first showcase project.</p>
                                    <a href="{{ route('admin.projects.create') }}" class="admin-btn-primary mt-4 text-xs">
                                        + Add Project
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($projects->hasPages())
            <div class="border-t border-[#E5E1D5] px-5 py-3">
                {{ $projects->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
