@extends('admin.layouts.master')

@section('title', 'Testimonials')
@section('header', 'Testimonials Management')

@section('admin-content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-semibold text-gray-900">Manage Testimonials</h2>
    <a href="{{ route('admin.testimonials.create') }}"
        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
        Add Testimonial
    </a>
</div>

<div class="overflow-x-auto">
    <table class="w-full">
        <thead>
            <tr class="border-b border-gray-200">
                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase">Author</th>
                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase">Role/Company</th>
                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase">Feedback</th>
                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase">Status</th>
                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase">Order</th>
                <th class="text-right py-3 px-4 text-xs font-semibold text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($testimonials as $testimonial)
                <tr class="border-b border-gray-100">
                    <td class="py-3 px-4">
                        <div class="flex items-center gap-3">
                            @if($testimonial->image)
                                <img src="{{ $testimonial->image_url }}" alt="{{ $testimonial->name }}" class="w-10 h-10 rounded-full object-cover">
                            @else
                                <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center">{{ substr($testimonial->name, 0, 1) }}</div>
                            @endif
                            <span class="font-medium text-gray-900">{{ $testimonial->name }}</span>
                        </div>
                    </td>
                    <td class="py-3 px-4 text-sm text-gray-500">{{ $testimonial->role_company ?? '—' }}</td>
                    <td class="py-3 px-4">
                        <p class="text-sm text-gray-700 line-clamp-2">{{ Str::limit($testimonial->feedback, 80) }}</p>
                    </td>
                    <td class="py-3 px-4">
                        @if($testimonial->is_published)
                            <span class="inline-flex px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">Published</span>
                        @else
                            <span class="inline-flex px-2 py-1 text-xs bg-gray-100 text-gray-600 rounded-full">Draft</span>
                        @endif
                    </td>
                    <td class="py-3 px-4 text-sm text-gray-500">{{ $testimonial->display_order }}</td>
                    <td class="py-3 px-4 text-right">
                        <div class="flex justify-end gap-1">
                            <a href="{{ route('admin.testimonials.edit', $testimonial) }}" class="text-blue-600 hover:text-blue-700">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.441-9.5L11 13.55L6.44 19H5.44L0.88 13.44L5.44 8.88L10.56 13.44L15.12 7.44L19.5 11.82V8L21.44 6.44L18 3L15.12 7.44Z"></path>
                                </svg>
                            </a>
                            <form method="POST" action="{{ route('admin.testimonials.destroy', $testimonial) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Delete this testimonial?')"
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
                    <td colspan="6" class="text-center py-8 text-gray-500">No testimonials found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($testimonials->hasPages())
    <div class="mt-4">
        {{ $testimonials->links() }}
    </div>
@endif
@endsection
