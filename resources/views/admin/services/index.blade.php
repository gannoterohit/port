@extends('admin.layouts.master')

@section('title', 'Services')
@section('header', 'Services Management')

@section('admin-content')
<div class="space-y-6">

    <!-- Top Banner -->
    <div class="flex flex-col gap-4 rounded-2xl border border-[#E5E1D5] bg-gradient-to-br from-white to-[#FAF9F5] p-5 shadow-xs sm:flex-row sm:items-center sm:justify-between sm:p-6">
        <div>
            <div class="flex items-center gap-2">
                <span class="inline-flex h-2 w-2 rounded-full bg-[#B85D19]"></span>
                <p class="text-xs font-mono font-bold uppercase tracking-wider text-[#B85D19]">Service Offerings</p>
            </div>
            <h2 class="mt-1 text-xl font-bold tracking-tight text-stone-900 sm:text-2xl">Client Services &amp; Packages</h2>
            <p class="mt-1 text-xs text-stone-500 sm:text-sm">Manage development offerings, feature breakdowns, icons and call-to-actions.</p>
        </div>
        <div class="flex items-center gap-2.5">
            <a href="{{ route('admin.services.create') }}" class="admin-btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>Add Service</span>
            </a>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-hidden rounded-2xl border border-[#E5E1D5] bg-white shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-stone-700">
                <thead class="border-b border-[#E5E1D5] bg-[#FAF9F5] text-xs font-semibold uppercase tracking-wider text-stone-500">
                    <tr>
                        <th class="px-5 py-3.5">Service Offering</th>
                        <th class="px-5 py-3.5">CTA Text</th>
                        <th class="px-5 py-3.5">Featured</th>
                        <th class="px-5 py-3.5">Status</th>
                        <th class="px-5 py-3.5">Order</th>
                        <th class="px-5 py-3.5 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E5E1D5]">
                    @forelse($services as $service)
                        <tr class="hover:bg-[#FAF9F5] transition-colors">
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3.5">
                                    <div class="h-10 w-10 rounded-xl border border-[#E5E1D5] bg-[#FAF9F5] flex items-center justify-center text-[#B85D19] shrink-0 font-bold shadow-xs">
                                        @if($service->image)
                                            <img src="{{ $service->image_url }}" alt="{{ $service->name }}" class="h-full w-full object-cover rounded-xl">
                                        @elseif($service->icon)
                                            <i class="{{ $service->icon }} text-lg"></i>
                                        @else
                                            <svg class="w-5 h-5 text-[#B85D19]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <span class="block font-bold text-stone-900 truncate">{{ $service->name }}</span>
                                        <span class="text-xs text-stone-500 line-clamp-1 max-w-sm">{{ Str::limit($service->description, 70) }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-4">
                                <span class="rounded-lg bg-stone-100 px-2.5 py-1 text-xs font-semibold text-stone-700 border border-stone-200">
                                    {{ $service->cta_text ?? 'Contact for Inquiry' }}
                                </span>
                            </td>
                            <td class="px-5 py-4">
                                @if($service->is_featured)
                                    <span class="inline-flex items-center gap-1 text-xs font-bold text-[#B85D19]">
                                        <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                        Featured
                                    </span>
                                @else
                                    <span class="text-xs text-stone-400">—</span>
                                @endif
                            </td>
                            <td class="px-5 py-4">
                                @if($service->is_enabled)
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
                                #{{ $service->display_order }}
                            </td>
                            <td class="px-5 py-4 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('services.show', $service->slug) }}" target="_blank" class="rounded-lg p-1.5 text-stone-400 hover:bg-stone-100 hover:text-stone-700 transition" title="Preview service">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                        </svg>
                                    </a>
                                    <a href="{{ route('admin.services.edit', $service) }}" class="rounded-lg p-1.5 text-[#B85D19] hover:bg-[#B85D19]/10 transition" title="Edit service">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    <form method="POST" action="{{ route('admin.services.destroy', $service) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Delete this service?')" class="rounded-lg p-1.5 text-stone-400 hover:bg-rose-50 hover:text-rose-600 transition" title="Delete service">
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
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                        </svg>
                                    </div>
                                    <p class="mt-3 text-sm font-bold text-stone-900">No services created yet</p>
                                    <p class="mt-1 text-xs text-stone-500">Create services like Full Stack Web App, API Development, etc.</p>
                                    <a href="{{ route('admin.services.create') }}" class="admin-btn-primary mt-4 text-xs">
                                        + Add Service
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($services->hasPages())
            <div class="border-t border-[#E5E1D5] px-5 py-3">
                {{ $services->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
