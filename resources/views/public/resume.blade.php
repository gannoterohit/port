@extends('public.layouts.app')

@section('title', 'Resume / CV - ' . $websiteName)
@section('meta_description', $profile->biography ? strip_tags($profile->biography) : $siteDescription)
@if(!empty($profile->og_image_url))
    @section('og_image', $profile->og_image_url)
@endif

@section('content')
<section class="min-h-screen pt-28 sm:pt-36 pb-24 bg-[#F5F7F2]">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto space-y-8">
            <!-- Header -->
            <div class="bg-white rounded-2xl p-8 sm:p-10 border border-[#E5E7EB] shadow-xs flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">
                <div>
                    <span class="inline-block text-xs font-bold uppercase tracking-wider text-[#1B560B] bg-[#DCE8D6] px-3.5 py-1 rounded-full mb-3">
                        Curriculum Vitae
                    </span>
                    <h1 class="text-3xl sm:text-4xl font-extrabold text-[#1F2937] tracking-tight">{{ $profile->name ?: 'Full Stack Developer' }}</h1>
                    <p class="text-sm sm:text-base text-[#667085] mt-1">{{ $profile->title ?: 'Laravel & MySQL Specialist' }}</p>
                </div>
                @if($profile->resume_url && $profile->resume_button_visible)
                    <a href="{{ $profile->resume_url }}" target="_blank" download
                        class="inline-flex items-center gap-2 bg-[#1B560B] hover:bg-[#144208] text-white px-6 py-3 rounded-lg text-sm font-semibold shadow-xs transition-colors shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1M12 12V2m0 0l-4 4m4-4l4 4M5 14h14a2 2 0 010 4H5a2 2 0 010-4z"></path>
                        </svg>
                        Download PDF
                    </a>
                @endif
            </div>

            <!-- Experience & Training Highlights -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="bg-white rounded-2xl p-6 border border-[#E5E7EB] shadow-xs">
                    <div class="text-2xl font-bold text-[#1B560B] mb-1">{{ \App\Models\Setting::get('years_experience') ?: '2.5+' }} Years</div>
                    <div class="font-semibold text-sm text-[#1F2937]">Professional Experience</div>
                    <p class="text-xs text-[#667085] mt-2 leading-relaxed">Active commercial web development specializing in Laravel, PHP, MySQL, and full-stack software architecture.</p>
                </div>
                <div class="bg-white rounded-2xl p-6 border border-[#E5E7EB] shadow-xs">
                    <div class="text-2xl font-bold text-[#1B560B] mb-1">6 Months</div>
                    <div class="font-semibold text-sm text-[#1F2937]">Intensive Training</div>
                    <p class="text-xs text-[#667085] mt-2 leading-relaxed">Specialized training in software engineering fundamentals, database optimization, and API engineering.</p>
                </div>
            </div>

            <!-- Biography / Executive Summary -->
            <div class="bg-white rounded-2xl p-8 border border-[#E5E7EB] shadow-xs">
                <h2 class="text-xl font-bold text-[#1F2937] mb-4">Executive Summary</h2>
                <div class="prose max-w-none text-[#667085] text-base leading-relaxed">
                    @if($profile->biography)
                        {!! $profile->biography !!}
                    @else
                        <p>{{ $profile->intro ?: 'Full Stack Web Developer crafting scalable applications and APIs.' }}</p>
                    @endif
                </div>
            </div>

            @if($profile->experience_text)
                <div class="bg-white rounded-2xl p-8 border border-[#E5E7EB] shadow-xs">
                    <h2 class="text-xl font-bold text-[#1F2937] mb-4">Work Experience</h2>
                    <div class="prose max-w-none text-[#667085] text-base leading-relaxed">
                        {!! nl2br(e($profile->experience_text)) !!}
                    </div>
                </div>
            @endif

            <!-- Skills Matrix -->
            @php
                $categories = \App\Models\SkillCategory::where('is_enabled', true)
                    ->with(['skills' => function ($q) {
                        $q->where('is_enabled', true)->orderBy('display_order');
                    }])
                    ->orderBy('display_order')
                    ->get();
            @endphp

            @if($categories->isNotEmpty())
                <div class="bg-white rounded-2xl p-8 border border-[#E5E7EB] shadow-xs space-y-6">
                    <h2 class="text-xl font-bold text-[#1F2937]">Technical Skills</h2>
                    <div class="space-y-6">
                        @foreach($categories as $category)
                            @if($category->skills->isNotEmpty())
                                <div>
                                    <h3 class="text-sm font-bold uppercase tracking-wider text-[#1B560B] mb-3">
                                        {{ $category->name }}
                                    </h3>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($category->skills as $skill)
                                            <span class="px-3 py-1.5 bg-[#F5F7F2] text-[#1F2937] border border-[#E5E7EB] rounded-lg text-sm font-medium">
                                                {{ $skill->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>
@endsection
