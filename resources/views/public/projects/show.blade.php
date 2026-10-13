@extends('public.layouts.app')

@section('title', ($project->seo_title ?: $project->title) . ' - ' . $websiteName)
@section('meta_description', $project->seo_description ?: ($project->short_description ?? Str::limit(strip_tags($project->description), 160)))
@section('og_title', $project->og_title ?: $project->title)
@section('og_description', $project->og_description ?: ($project->short_description ?? Str::limit(strip_tags($project->description), 160)))
@section('og_image', $project->og_image_url ?: $project->thumbnail_url)
@if($project->canonical_url)
    @section('canonical', $project->canonical_url)
@endif
@if($project->no_index)
    @section('meta_robots', 'noindex, nofollow')
@endif

@section('content')
<section class="min-h-screen pt-28 sm:pt-36 pb-24 bg-[#F5F7F2]">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <!-- Navigation Back -->
            <a href="{{ route('projects') }}" class="text-[#1B560B] hover:text-[#144208] font-medium text-sm inline-flex items-center gap-2 mb-6">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back to Projects
            </a>

            <!-- Header Information -->
            <div class="mb-4">
                <span class="text-xs px-3 py-1 bg-[#DCE8D6] text-[#1B560B] font-semibold rounded-full">
                    {{ $project->category ?? 'Case Study' }}
                </span>
            </div>

            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-[#1F2937] tracking-tight mb-4">
                {{ $project->title }}
            </h1>

            @if($project->short_description)
                <p class="text-lg sm:text-xl text-[#667085] leading-relaxed mb-8">{{ $project->short_description }}</p>
            @endif

            <!-- Main Thumbnail -->
            @if($project->thumbnail_url)
                <div class="rounded-2xl overflow-hidden border border-[#E5E7EB] shadow-sm mb-10 bg-white">
                    <img src="{{ $project->thumbnail_url }}" alt="{{ $project->title }}"
                        class="w-full h-auto aspect-video object-cover">
                </div>
            @endif

            <!-- Technologies -->
            @if($project->tech_stack && is_array($project->tech_stack))
                <div class="mb-10 bg-white rounded-2xl border border-[#E5E7EB] p-6 shadow-xs">
                    <h3 class="text-xs font-bold text-[#667085] mb-3 uppercase tracking-wider">Technologies &amp; Architecture</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($project->tech_stack as $tech)
                            <span class="px-3 py-1 bg-[#F5F7F2] text-[#1F2937] border border-[#E5E7EB] rounded-lg text-sm font-medium">
                                {{ $tech }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Problem & Purpose -->
            @if($project->purpose)
                <div class="mb-10 bg-white rounded-2xl border border-[#E5E7EB] p-6 sm:p-8 shadow-xs">
                    <h3 class="text-xl font-bold text-[#1F2937] mb-3 flex items-center gap-2">
                        <svg class="w-5 h-5 text-[#1B560B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Problem Solved &amp; Overview
                    </h3>
                    <div class="prose max-w-none text-[#667085] text-base leading-relaxed">
                        {!! nl2br(e($project->purpose)) !!}
                    </div>
                </div>
            @endif

            <!-- Role & Contribution -->
            @if($project->role)
                <div class="mb-10 bg-white rounded-2xl border border-[#E5E7EB] p-6 sm:p-8 shadow-xs">
                    <h3 class="text-xl font-bold text-[#1F2937] mb-3 flex items-center gap-2">
                        <svg class="w-5 h-5 text-[#1B560B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        My Role &amp; Contribution
                    </h3>
                    <div class="prose max-w-none text-[#667085] text-base leading-relaxed">
                        {!! nl2br(e($project->role)) !!}
                    </div>
                </div>
            @endif

            <!-- Key Features -->
            @if($project->key_features)
                <div class="mb-10 bg-white rounded-2xl border border-[#E5E7EB] p-6 sm:p-8 shadow-xs">
                    <h3 class="text-xl font-bold text-[#1F2937] mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-[#1B560B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Key Features
                    </h3>
                    @php
                        $features = is_string($project->key_features) ? (str_contains($project->key_features, "\n") ? explode("\n", $project->key_features) : explode('|', $project->key_features)) : (is_array($project->key_features) ? $project->key_features : []);
                    @endphp
                    <ul class="grid grid-cols-1 md:grid-cols-2 gap-3.5">
                        @foreach($features as $feature)
                            @if(trim($feature))
                                <li class="flex items-start gap-2.5 p-3 rounded-xl bg-[#F5F7F2] border border-[#E5E7EB]">
                                    <svg class="w-5 h-5 text-[#1B560B] mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="text-[#1F2937] text-sm font-medium leading-snug">{{ trim($feature) }}</span>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Challenges & Solutions -->
            @if($project->challenges || $project->solutions)
                <div class="mb-10 grid grid-cols-1 md:grid-cols-2 gap-6">
                    @if($project->challenges)
                        <div class="bg-white border border-[#E5E7EB] rounded-2xl p-6 shadow-xs">
                            <h3 class="text-lg font-bold text-[#1F2937] mb-3 flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>
                                Technical Challenges
                            </h3>
                            <div class="prose max-w-none text-[#667085] text-sm leading-relaxed">
                                {!! nl2br(e($project->challenges)) !!}
                            </div>
                        </div>
                    @endif
                    @if($project->solutions)
                        <div class="bg-white border border-[#E5E7EB] rounded-2xl p-6 shadow-xs">
                            <h3 class="text-lg font-bold text-[#1F2937] mb-3 flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-[#1B560B]"></span>
                                Architectural Solutions
                            </h3>
                            <div class="prose max-w-none text-[#667085] text-sm leading-relaxed">
                                {!! nl2br(e($project->solutions)) !!}
                            </div>
                        </div>
                    @endif
                </div>
            @endif

            <!-- Detailed Description -->
            @if($project->description)
                <div class="mb-10 bg-white rounded-2xl border border-[#E5E7EB] p-6 sm:p-8 shadow-xs">
                    <h3 class="text-xl font-bold text-[#1F2937] mb-4">Implementation Details</h3>
                    <div class="prose max-w-none text-[#667085] text-base leading-relaxed">
                        {!! nl2br(e($project->description)) !!}
                    </div>
                </div>
            @endif

            <!-- Screenshots Gallery -->
            @if($project->screenshots->isNotEmpty())
                <div class="mb-12">
                    <h3 class="text-xl font-bold text-[#1F2937] mb-6">Screenshots &amp; User Flow</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($project->screenshots as $screenshot)
                            <div class="rounded-2xl overflow-hidden border border-[#E5E7EB] shadow-xs bg-white">
                                <img src="{{ $screenshot->image_url }}" alt="{{ $screenshot->caption ?? $project->title }}"
                                    class="w-full h-56 object-cover object-top hover:scale-105 transition-transform duration-300">
                                @if($screenshot->caption)
                                    <p class="p-3 text-xs text-[#667085] text-center border-t border-[#E5E7EB] bg-[#F5F7F2]">{{ $screenshot->caption }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Live Actions & Client Info -->
            @if($project->client_name || $project->demo_url || $project->github_url)
                <div class="p-6 rounded-2xl bg-white border border-[#E5E7EB] shadow-xs flex flex-wrap gap-4 items-center justify-between mb-12">
                    <div class="flex flex-wrap gap-3 items-center">
                        @if($project->demo_url)
                            <a href="{{ $project->demo_url }}" target="_blank" rel="noopener noreferrer"
                                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg bg-[#1B560B] hover:bg-[#144208] text-white font-medium text-sm transition-all shadow-xs">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                </svg>
                                Live Demo
                            </a>
                        @endif
                        @if($project->github_url)
                            <a href="{{ $project->github_url }}" target="_blank" rel="noopener noreferrer"
                                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg bg-[#F5F7F2] hover:bg-[#E5E7EB] text-[#1F2937] font-medium text-sm border border-[#E5E7EB] transition-colors">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 0C5.371 0 0 5.371 0 12.004c0 5.302 3.544 9.8 8.434 11.386.6.112.82-.262.82-.58 0-.286-.01-1.186-.015-2.148-3.429.756-4.141-1.647-4.141-1.647-.555-1.401-1.342-1.77-1.342-1.77-1.09-.75.084-.735.084-.735 1.203.084 1.836 1.24 1.836 1.24 1.067 1.83 2.805 1.305 3.49.996.108-.782.418-1.305.762-1.605-2.665-.305-5.467-1.335-5.467-5.935 0-1.311.47-2.381 1.236-3.221-.124-.303-.053-.823.027-1.646 0 0 .027-.086.997 1.203 3.186-.998 4.263-.274 4.263-.274.34.861.995 1.685 1.715 1.998.82-.122 1.64-.247 2.456-.449 0 0 1.09-.19 2.24 1.226 0 0 1.105-1.156 1.568-2.779 0 0 .42-1.325.027-2.779 0 0 1.59-.041 2.997 1.229.96-.273 1.99-.822 3.01-1.599.762 1.155 1.142 2.497 1.142 3.91 0 1.566.015 3.132.015 3.589 0 0 .084.49.82 1.295.932 1.2 1.42 1.964 1.42 1.964.534.889 1.158 1.341 1.81.995 1.27-.338 1.72-.881 2.03.336.265.999.82 1.787 1.427 2.423.81-.161 1.6-.48 2.27-.93.074-.554.136-1.435.136-1.97 0-4.608-3.135-8.342-7.41-9.466 1.32-.975 2.295-2.975 2.295-6.215 0-4.816-3.135-8.746-7.412-8.746-2.322 0-4.522.85-6.29 2.282-.643-.12-1.28.2-1.92.49-.995 22.07-7.7 15.62-12.06 15.66-1.35-.27-2.74-.42-4.15-.42z"></path>
                                </svg>
                                GitHub Repo
                            </a>
                        @endif
                    </div>
                    @if($project->client_name)
                        <div class="text-xs sm:text-sm text-[#667085]">
                            Client: <span class="font-semibold text-[#1F2937]">{{ $project->client_name }}</span>
                        </div>
                    @endif
                </div>
            @endif

            <!-- Inquire CTA Box -->
            <div class="p-8 sm:p-12 rounded-2xl bg-white border border-[#E5E7EB] shadow-sm text-center">
                <span class="inline-block text-xs font-bold uppercase tracking-wider text-[#1B560B] bg-[#DCE8D6] px-3.5 py-1 rounded-full mb-3">Interested in Similar Work?</span>
                <h3 class="text-2xl sm:text-3xl font-bold text-[#1F2937] mb-3">Have a project with similar requirements?</h3>
                <p class="text-[#667085] max-w-xl mx-auto mb-6 leading-relaxed">Let's discuss how we can build a scalable, reliable web application tailored to your business needs.</p>
                <a href="{{ route('contact') }}"
                    class="inline-flex items-center gap-2 bg-[#1B560B] text-white hover:bg-[#144208] px-7 py-3.5 rounded-lg font-semibold transition-all shadow-sm">
                    Hire Me For Your Project
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
