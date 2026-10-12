@extends('admin.layouts.master')

@section('title', 'Dashboard')
@section('header', 'Dashboard')

@section('admin-content')
<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl p-5 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Total Projects</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $stats['total_projects'] }}</p>
                </div>
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11V9a6 6 0 00-6-6H8a6 6 0 00-6 6v6l2 2v4a2 2 0 002 2h8a2 2 0 002-2v-4l2-2z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-5 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Published Projects</p>
                    <p class="text-3xl font-bold text-green-600">{{ $stats['published_projects'] }}</p>
                </div>
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618y9.05A3.5 3.5 0 0112 16.5a3.5 3.5 0 01-3.5-3.5 3.5 3.5 0 117 0 3.5 3.5 0 01-3.5 3.5z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-5 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Draft Projects</p>
                    <p class="text-3xl font-bold text-yellow-600">{{ $stats['draft_projects'] }}</p>
                </div>
                <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17h2M11 7h2v6h-2zM9 9h6m-3 0l3-3m-3 0L9 9z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-5 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Total Services</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $stats['total_services'] }}</p>
                </div>
                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.27V6a2 2 0 00-2-2H5a2 2 0 010-4c.55 0 1 .45 1 1v2h12a1 1 0 011 1v2.23l-1.5 1.5A3.5 3.5 0 019 13.27V6a3 3 0 013-3h6a3 3 0 013 3v7.27z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl p-5 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Total Enquiries</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $stats['total_enquiries'] }}</p>
                </div>
                <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 01-2-2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-5 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">New Enquiries</p>
                    <p class="text-3xl font-bold text-blue-600">{{ $stats['new_enquiries'] }}</p>
                </div>
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-5 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Unread Enquiries</p>
                    <p class="text-3xl font-bold text-red-600">{{ $stats['unread_enquiries'] }}</p>
                </div>
                <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.983 3C6.45 4.15 2 9.05 2 15v5l3-3 7-1 7 1 7 3v-5c0-5.95-4.45-10.85-10-12z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-5 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Total Testimonials</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $stats['total_testimonials'] }}</p>
                </div>
                <div class="w-10 h-10 bg-teal-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l3 3v1a6 6 0 01-3-3V9z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl border border-gray-200">
            <div class="p-5 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Recent Enquiries</h2>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse($recentEnquiries as $enquiry)
                    <div class="p-4 hover:bg-gray-50 transition-colors">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="font-medium text-gray-900">{{ $enquiry->name }}</p>
                                <p class="text-sm text-gray-500">{{ $enquiry->email }}</p>
                                <p class="text-sm text-gray-600 mt-1 line-clamp-2">{{ Str::limit($enquiry->message, 80) }}</p>
                                <p class="text-xs text-gray-400 mt-1">{{ $enquiry->created_at->diffForHumans() }}</p>
                            </div>
                            @php
                                $statusClasses = [
                                    'new' => 'bg-blue-100 text-blue-800',
                                    'in_progress' => 'bg-amber-100 text-amber-800',
                                    'contacted' => 'bg-emerald-100 text-emerald-800',
                                    'converted' => 'bg-purple-100 text-purple-800',
                                    'closed' => 'bg-slate-100 text-slate-800',
                                ];
                            @endphp
                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full {{ $statusClasses[$enquiry->status] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ $enquiry->status_label }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="p-4 text-center text-gray-500">No enquiries yet.</div>
                @endforelse
            </div>
            @if($recentEnquiries->count())
                <div class="p-3 border-t border-gray-200">
                    <a href="{{ route('admin.enquiries.index') }}" class="text-sm text-blue-600 hover:text-blue-700">View all enquiries</a>
                </div>
            @endif
        </div>

        <div class="bg-white rounded-xl border border-gray-200">
            <div class="p-5 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Recent Projects</h2>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse($recentProjects as $project)
                    <div class="p-4 hover:bg-gray-50 transition-colors">
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 bg-gray-200 rounded-lg flex-shrink-0">
                                @if($project->thumbnail)
                                    <img src="{{ $project->thumbnail_url }}" alt="{{ $project->title }}" class="w-10 h-10 object-cover rounded-lg">
                                @endif
                            </div>
                            <div class="flex-1">
                                <p class="font-medium text-gray-900">{{ $project->title }}</p>
                                <span class="px-2 py-1 text-xs rounded-full bg-{{ $project->status === 'published' ? 'green' : 'yellow' }}-100 text-{{ $project->status === 'published' ? 'green' : 'yellow' }}-800">
                                    {{ $project->status_label }}
                                </span>
                                <p class="text-xs text-gray-400 mt-1">{{ $project->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-4 text-center text-gray-500">No projects yet.</div>
                @endforelse
            </div>
            @if($recentProjects->count())
                <div class="p-3 border-t border-gray-200">
                    <a href="{{ route('admin.projects.index') }}" class="text-sm text-blue-600 hover:text-blue-700">View all projects</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Ensure status color classes work correctly
    document.addEventListener('DOMContentLoaded', function() {});
</script>
@endsection
