@extends('admin.layouts.master')

@section('title', 'Testimonials')
@section('header', 'Client Testimonials')

@section('admin-content')
<div class="space-y-6">

    <!-- Top Banner -->
    <div class="flex flex-col gap-4 rounded-2xl border border-[#E5E0D5] bg-gradient-to-br from-white to-[#FAF9F5] p-5 shadow-xs sm:flex-row sm:items-center sm:justify-between sm:p-6">
        <div>
            <div class="flex items-center gap-2">
                <span class="inline-flex h-2 w-2 rounded-full bg-[#B85D19]"></span>
                <p class="text-xs font-mono font-bold uppercase tracking-wider text-[#B85D19]">Social Proof</p>
            </div>
            <h2 class="mt-1 text-xl font-bold tracking-tight text-stone-900 sm:text-2xl">Client Testimonials &amp; Reviews</h2>
            <p class="mt-1 text-xs text-stone-500 sm:text-sm">Manage feedback quotes, author credentials, company logos, and display sequence on the homepage.</p>
        </div>
        <div class="flex items-center gap-2.5">
            <a href="{{ route('admin.testimonials.create') }}" class="admin-btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>Add Testimonial</span>
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
            <svg class="h-5 w-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Testimonials Table Card -->
    <div class="admin-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-stone-700">
                <thead class="border-b border-[#E5E0D5] bg-[#FAF9F5] text-xs font-semibold uppercase tracking-wider text-stone-500">
                    <tr>
                        <th class="px-5 py-3.5">Author</th>
                        <th class="px-5 py-3.5">Role / Company</th>
                        <th class="px-5 py-3.5">Feedback Snippet</th>
                        <th class="px-5 py-3.5">Status</th>
                        <th class="px-5 py-3.5">Order</th>
                        <th class="px-5 py-3.5 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E5E0D5]">
                    @forelse($testimonials as $testimonial)
                        <tr class="hover:bg-[#FAF9F5] transition-colors">
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    @if($testimonial->image)
                                        <img src="{{ $testimonial->image_url }}" alt="{{ $testimonial->name }}" class="w-10 h-10 rounded-full object-cover border border-[#E5E0D5] shrink-0">
                                    @else
                                        <div class="w-10 h-10 bg-[#B85D19]/10 text-[#B85D19] rounded-full flex items-center justify-center font-bold text-sm shrink-0 border border-[#B85D19]/20">
                                            {{ substr($testimonial->name, 0, 1) }}
                                        </div>
                                    @endif
                                    <span class="font-semibold text-stone-900">{{ $testimonial->name }}</span>
                                </div>
                            </td>
                            <td class="px-5 py-4 text-xs text-stone-600 font-medium">
                                {{ $testimonial->role_company ?? '—' }}
                            </td>
                            <td class="px-5 py-4">
                                <p class="text-xs text-stone-600 line-clamp-2 max-w-md italic leading-relaxed">
                                    "{{ Str::limit($testimonial->feedback, 90) }}"
                                </p>
                            </td>
                            <td class="px-5 py-4">
                                @if($testimonial->is_published)
                                    <span class="admin-badge-success">Published</span>
                                @else
                                    <span class="admin-badge-neutral">Draft</span>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-xs font-mono text-stone-500">
                                #{{ $testimonial->display_order }}
                            </td>
                            <td class="px-5 py-4 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('admin.testimonials.edit', $testimonial) }}" class="rounded-lg p-1.5 text-[#B85D19] hover:bg-[#B85D19]/10 transition" title="Edit Testimonial">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    <form method="POST" action="{{ route('admin.testimonials.destroy', $testimonial) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Delete this testimonial?')" class="rounded-lg p-1.5 text-stone-400 hover:bg-rose-50 hover:text-rose-600 transition" title="Delete">
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
                            <td colspan="6" class="px-5 py-12 text-center text-xs text-stone-400">
                                <div class="mx-auto max-w-sm text-center">
                                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-stone-100 text-stone-400">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                                    </div>
                                    <p class="mt-3 text-sm font-bold text-stone-900">No testimonials added yet</p>
                                    <p class="mt-1 text-xs text-stone-500">Showcase feedback and praise from clients and colleagues.</p>
                                    <a href="{{ route('admin.testimonials.create') }}" class="admin-btn-primary mt-4 text-xs">
                                        + Add Testimonial
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($testimonials->hasPages())
            <div class="border-t border-[#E5E0D5] px-5 py-3">
                {{ $testimonials->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
