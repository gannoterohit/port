@extends('admin.layouts.master')

@section('title', 'Skills & Tools')
@section('header', 'Technical Skills & Tools')

@section('admin-content')
<div class="space-y-6">

    <!-- Top Banner -->
    <div class="flex flex-col gap-4 rounded-2xl border border-[#E5E1D5] bg-gradient-to-br from-white to-[#FAF9F5] p-5 shadow-xs sm:flex-row sm:items-center sm:justify-between sm:p-6">
        <div>
            <div class="flex items-center gap-2">
                <span class="inline-flex h-2 w-2 rounded-full bg-[#B85D19]"></span>
                <p class="text-xs font-mono font-bold uppercase tracking-wider text-[#B85D19]">Expertise &amp; Tooling</p>
            </div>
            <h2 class="mt-1 text-xl font-bold tracking-tight text-stone-900 sm:text-2xl">Core Skills &amp; Stack Masteries</h2>
            <p class="mt-1 text-xs text-stone-500 sm:text-sm">Manage programming languages, frameworks, databases, and proficiency rankings.</p>
        </div>
        <div class="flex items-center gap-2.5">
            <a href="{{ route('admin.skill-categories.index') }}" class="admin-btn-secondary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                <span>Categories</span>
            </a>
            <a href="{{ route('admin.skills.create') }}" class="admin-btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>Add Skill</span>
            </a>
        </div>
    </div>

    <!-- Filters & Search -->
    <div class="rounded-2xl border border-[#E5E1D5] bg-white p-4 shadow-xs">
        <form method="GET" class="flex flex-col gap-3 sm:flex-row sm:items-center">
            <div class="flex-1">
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search skills by name or keyword..." class="admin-input pl-10 text-xs sm:text-sm">
                    <svg class="w-4 h-4 text-stone-400 absolute left-3.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="w-full sm:w-48">
                <select name="category_id" class="admin-input text-xs sm:text-sm">
                    <option value="">All Categories</option>
                    @foreach(\App\Models\SkillCategory::where('is_enabled', true)->get() as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="w-full sm:w-36">
                <select name="status" class="admin-input text-xs sm:text-sm">
                    <option value="">All Statuses</option>
                    <option value="enabled" {{ request('status') === 'enabled' ? 'selected' : '' }}>Enabled Only</option>
                    <option value="disabled" {{ request('status') === 'disabled' ? 'selected' : '' }}>Disabled</option>
                </select>
            </div>
            <div class="flex items-center gap-2">
                <button type="submit" class="admin-btn-primary text-xs py-2.5">
                    Filter
                </button>
                @if(request('search') || request('category_id') || request('status'))
                    <a href="{{ route('admin.skills.index') }}" class="admin-btn-secondary text-xs py-2.5">
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
                        <th class="px-5 py-3.5">Skill Name</th>
                        <th class="px-5 py-3.5">Category</th>
                        <th class="px-5 py-3.5">Proficiency</th>
                        <th class="px-5 py-3.5">Featured</th>
                        <th class="px-5 py-3.5">Status</th>
                        <th class="px-5 py-3.5">Order</th>
                        <th class="px-5 py-3.5 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E5E1D5]">
                    @forelse($skills as $skill)
                        <tr class="hover:bg-[#FAF9F5] transition-colors">
                            <td class="px-5 py-4">
                                <div class="font-bold text-stone-900">{{ $skill->name }}</div>
                                @if($skill->description)
                                    <div class="text-xs text-stone-500 line-clamp-1 max-w-sm">{{ $skill->description }}</div>
                                @endif
                            </td>
                            <td class="px-5 py-4">
                                @if($skill->category)
                                    <span class="inline-flex rounded-lg px-2.5 py-1 text-xs font-semibold" style="background-color: {{ $skill->category->color }}15; color: {{ $skill->category->color }}">
                                        {{ $skill->category->name }}
                                    </span>
                                @else
                                    <span class="text-xs text-stone-400">—</span>
                                @endif
                            </td>
                            <td class="px-5 py-4">
                                <span class="rounded-lg bg-stone-100 px-2 py-0.5 text-xs font-medium text-stone-700 border border-stone-200">
                                    {{ $skill->proficiency_label ?: 'Proficient' }}
                                </span>
                            </td>
                            <td class="px-5 py-4">
                                @if($skill->is_featured)
                                    <span class="inline-flex items-center gap-1 text-xs font-bold text-[#B85D19]">
                                        <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                        Hero
                                    </span>
                                @else
                                    <span class="text-xs text-stone-400">—</span>
                                @endif
                            </td>
                            <td class="px-5 py-4">
                                @if($skill->is_enabled)
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
                                #{{ $skill->display_order }}
                            </td>
                            <td class="px-5 py-4 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('admin.skills.edit', $skill) }}" class="rounded-lg p-1.5 text-[#B85D19] hover:bg-[#B85D19]/10 transition" title="Edit skill">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    <form method="POST" action="{{ route('admin.skills.destroy', $skill) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Delete this skill?')" class="rounded-lg p-1.5 text-stone-400 hover:bg-rose-50 hover:text-rose-600 transition" title="Delete skill">
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
                                    <p class="text-sm font-bold text-stone-900">No skills found</p>
                                    <p class="mt-1 text-xs text-stone-500">Add technical skills like Laravel, PHP, MySQL, Docker, etc.</p>
                                    <a href="{{ route('admin.skills.create') }}" class="admin-btn-primary mt-4 text-xs">
                                        + Add Skill
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($skills->hasPages())
            <div class="border-t border-[#E5E1D5] px-5 py-3">
                {{ $skills->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
