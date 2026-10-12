@extends('admin.layouts.master')

@section('title', 'Sitemap')
@section('header', 'Sitemap')

@section('admin-content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="text-xl font-semibold text-gray-900">Sitemap URLs</h2>
        <a href="{{ route('sitemap.xml') }}" target="_blank"
            class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium">
            View XML Sitemap
        </a>
    </div>

    <div class="bg-white rounded-xl border border-gray-200">
        <div class="p-4 border-b border-gray-200">
            <p class="text-sm text-gray-500">
                Total URLs: <span class="font-bold text-gray-900">{{ count($urls) }}</span>
            </p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase">URL</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase">Change Freq.</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase">Priority</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase">Last Modified</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($urls as $url)
                        <tr class="border-b border-gray-100">
                            <td class="py-3 px-4 text-sm text-gray-700 font-mono truncate max-w-md">
                                {{ $url['loc'] }}
                            </td>
                            <td class="py-3 px-4 text-sm text-gray-500">{{ $url['changefreq'] }}</td>
                            <td class="py-3 px-4 text-sm text-gray-500">{{ $url['priority'] }}</td>
                            <td class="py-3 px-4 text-sm text-gray-500">{{ \Carbon\Carbon::parse($url['lastmod'])->format('M d, Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
