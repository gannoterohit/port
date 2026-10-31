@extends('admin.layouts.master')

@section('title', 'Sitemap')
@section('header', 'Sitemap & Indexing')

@section('admin-content')
<div class="space-y-6">

    <!-- Top Banner -->
    <div class="flex flex-col gap-4 rounded-2xl border border-[#E5E0D5] bg-gradient-to-br from-white to-[#FAF9F5] p-5 shadow-xs sm:flex-row sm:items-center sm:justify-between sm:p-6">
        <div>
            <div class="flex items-center gap-2">
                <span class="inline-flex h-2 w-2 rounded-full bg-[#B85D19]"></span>
                <p class="text-xs font-mono font-bold uppercase tracking-wider text-[#B85D19]">Search Engine Indexing</p>
            </div>
            <h2 class="mt-1 text-xl font-bold tracking-tight text-stone-900 sm:text-2xl">XML Sitemap Registry</h2>
            <p class="mt-1 text-xs text-stone-500 sm:text-sm">Auto-generated XML sitemap URLs for Google, Bing and search engine crawlers.</p>
        </div>
        <div class="flex items-center gap-2.5">
            <a href="{{ route('sitemap.xml') }}" target="_blank" rel="noopener" class="admin-btn-secondary">
                <svg class="w-4 h-4 text-stone-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                <span>View Raw XML</span>
            </a>
        </div>
    </div>

    <!-- Sitemap Table Card -->
    <div class="admin-card overflow-hidden">
        <div class="p-4 sm:p-5 border-b border-[#E5E0D5] flex items-center justify-between bg-[#FAF9F5]/50">
            <div class="flex items-center gap-3">
                <span class="text-xs font-bold uppercase tracking-wider text-stone-600">Indexed URLs</span>
                <span class="px-2 py-0.5 rounded-full text-xs font-mono font-bold bg-[#B85D19]/10 text-[#B85D19] border border-[#B85D19]/20">
                    {{ count($urls) }} Entries
                </span>
            </div>
            <span class="text-xs text-stone-400">Dynamically compiled on request</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-stone-700">
                <thead class="border-b border-[#E5E0D5] bg-[#FAF9F5] text-xs font-semibold uppercase tracking-wider text-stone-500">
                    <tr>
                        <th class="px-5 py-3.5">Canonical URL</th>
                        <th class="px-5 py-3.5">Change Frequency</th>
                        <th class="px-5 py-3.5">Priority</th>
                        <th class="px-5 py-3.5">Last Modified</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E5E0D5]">
                    @foreach($urls as $url)
                        <tr class="hover:bg-[#FAF9F5] transition-colors">
                            <td class="px-5 py-3.5 font-mono text-xs text-stone-800 truncate max-w-lg">
                                <a href="{{ $url['loc'] }}" target="_blank" class="hover:text-[#B85D19] hover:underline flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-stone-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                                    {{ $url['loc'] }}
                                </a>
                            </td>
                            <td class="px-5 py-3.5 text-xs text-stone-600 font-mono">
                                <span class="px-2 py-0.5 rounded bg-stone-100 text-stone-700 border border-stone-200">
                                    {{ $url['changefreq'] }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 text-xs font-mono font-semibold text-stone-800">
                                {{ $url['priority'] }}
                            </td>
                            <td class="px-5 py-3.5 text-xs font-mono text-stone-500">
                                {{ \Carbon\Carbon::parse($url['lastmod'])->format('M d, Y') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
