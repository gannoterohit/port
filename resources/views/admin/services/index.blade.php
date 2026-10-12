@extends('admin.layouts.master')

@section('title', 'Services')
@section('header', 'Services Management')

@section('admin-content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-semibold text-gray-900">Manage Services</h2>
    <a href="{{ route('admin.services.create') }}"
        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
        Add Service
    </a>
</div>

<div class="overflow-x-auto">
    <table class="w-full">
        <thead>
            <tr class="border-b border-gray-200">
                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase">Service</th>
                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase">Icon/Image</th>
                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase">CTA</th>
                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase">Featured</th>
                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase">Status</th>
                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase">Order</th>
                <th class="text-right py-3 px-4 text-xs font-semibold text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($services as $service)
                <tr class="border-b border-gray-100">
                    <td class="py-3 px-4">
                        <span class="font-medium text-gray-900">{{ $service->name }}</span>
                        <span class="text-xs text-gray-500 block">{{ Str::limit($service->description, 60) }}</span>
                    </td>
                    <td class="py-3 px-4">
                        @if($service->icon)
                            <i class="{{ $service->icon }} text-2xl"></i>
                        @elseif($service->image)
                            <img src="{{ $service->image_url }}" alt="{{ $service->name }}" class="w-10 h-10 rounded-lg object-cover">
                        @else
                            <span class="text-gray-400">—</span>
                        @endif
                    </td>
                    <td class="py-3 px-4 text-sm text-gray-500">
                        {{ $service->cta_text ?? '—' }}
                    </td>
                    <td class="py-3 px-4">
                        @if($service->is_featured)
                            <span class="inline-flex px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded-full">Yes</span>
                        @else
                            <span class="text-gray-400">No</span>
                        @endif
                    </td>
                    <td class="py-3 px-4">
                        @if($service->is_enabled)
                            <span class="inline-flex px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">Enabled</span>
                        @else
                            <span class="inline-flex px-2 py-1 text-xs bg-gray-100 text-gray-600 rounded-full">Disabled</span>
                        @endif
                    </td>
                    <td class="py-3 px-4 text-sm text-gray-500">{{ $service->display_order }}</td>
                    <td class="py-3 px-4 text-right">
                        <div class="flex justify-end items-center gap-2">
                            <a href="{{ route('services.show', $service->slug) }}" target="_blank" class="text-gray-500 hover:text-gray-700" title="View on site">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </a>
                            <a href="{{ route('admin.services.edit', $service) }}" class="text-blue-600 hover:text-blue-700" title="Edit service">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </a>
                        <form method="POST" action="{{ route('admin.services.destroy', $service) }}" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Delete this service?')"
                                class="text-red-600 hover:text-red-700">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.133A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.86L5 7m5 5v6m4-6v6m1-10V4a1 1 0 00-1-1h-2a1 1 0 00-1 1v3m-4 0h6"></path>
                                </svg>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center py-8 text-gray-500">No services found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($services->hasPages())
    <div class="mt-4">
        {{ $services->links() }}
    </div>
@endif
@endsection
