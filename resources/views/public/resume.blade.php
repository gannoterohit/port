@extends('public.layouts.app')

@section('title', 'Resume / CV - ' . $websiteName)
@section('meta_description', $profile->biography ? strip_tags($profile->biography) : $siteDescription)
@if(!empty($profile->og_image_url))
    @section('og_image', $profile->og_image_url)
@endif

@section('content')
<section class="min-h-screen pt-28 sm:pt-36 pb-24 bg-[var(--theme-bg-canvas)] text-[var(--theme-text-heading)] relative overflow-hidden transition-colors duration-200">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10 max-w-7xl 2xl:max-w-[1400px]">
        <div class="max-w-4xl mx-auto space-y-8">
            <!-- Header -->
            <div class="bg-[var(--theme-bg-card)] rounded-3xl p-8 sm:p-10 border border-[var(--theme-border)] shadow-xs flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">
                <div>
                    <span class="inline-block text-xs font-bold uppercase tracking-wider text-brand badge-brand px-3.5 py-1 rounded-full mb-3 shadow-2xs">
                        Curriculum Vitae
                    </span>
                    <h1 class="text-3xl sm:text-4xl font-extrabold text-[var(--theme-text-heading)] tracking-tight">{{ $profile->name ?: 'Full Stack Developer' }}</h1>
                    <p class="text-sm sm:text-base text-[var(--theme-text-body)] mt-1">{{ $profile->title ?: 'Laravel & MySQL Specialist' }}</p>
                </div>
                @if($profile->resume_url && $profile->resume_button_visible)
                    <a href="{{ route('resume.download') }}" target="_blank" rel="noopener noreferrer" download
                        class="theme-btn-primary inline-flex items-center gap-2 px-6 py-3.5 rounded-full text-xs sm:text-sm font-semibold shadow-sm transition-all hover:scale-[1.02] shrink-0">
                        <svg class="w-4 h-4 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1M12 12V2m0 0l-4 4m4-4l4 4M5 14h14a2 2 0 010 4H5a2 2 0 010-4z"></path>
                        </svg>
                        <span>Download PDF Resume</span>
                    </a>
                @else
                    <a href="{{ route('contact') }}"
                        class="theme-btn-primary inline-flex items-center gap-2 px-6 py-3.5 rounded-full text-xs sm:text-sm font-semibold shadow-sm transition-all hover:scale-[1.02] shrink-0">
                        <span>Contact / Hire Me</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                @endif
            </div>

            <!-- Experience & Training Highlights -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="bg-[var(--theme-bg-card)] rounded-3xl p-6 sm:p-7 border border-[var(--theme-border)] shadow-xs">
                    <div class="text-2xl sm:text-3xl font-extrabold text-brand mb-1">{{ \App\Models\Setting::get('years_experience') ?: '2.5+' }} Years</div>
                    <div class="font-bold text-sm text-[var(--theme-text-heading)]">Commercial Experience</div>
                    <p class="text-xs text-[var(--theme-text-body)] mt-2 leading-relaxed">Active commercial web development specializing in Laravel, PHP, MySQL, and full-stack software architecture.</p>
                </div>
                <div class="bg-[var(--theme-bg-card)] rounded-3xl p-6 sm:p-7 border border-[var(--theme-border)] shadow-xs">
                    <div class="text-2xl sm:text-3xl font-extrabold text-brand mb-1">6 Months</div>
                    <div class="font-bold text-sm text-[var(--theme-text-heading)]">Intensive Training</div>
                    <p class="text-xs text-[var(--theme-text-body)] mt-2 leading-relaxed">Specialized training in software engineering fundamentals, database optimization, and API engineering.</p>
                </div>
            </div>

            <!-- Biography / Executive Summary -->
            <div class="bg-[var(--theme-bg-card)] rounded-3xl p-8 border border-[var(--theme-border)] shadow-xs space-y-4">
                <h2 class="text-xl font-bold text-[var(--theme-text-heading)]">Executive Summary</h2>
                <div class="text-[var(--theme-text-body)] text-sm sm:text-base leading-relaxed space-y-3">
                    @if($profile->biography)
                        {!! $profile->biography !!}
                    @else
                        <p>{{ $profile->intro ?: 'Full Stack Web Developer crafting scalable applications and APIs.' }}</p>
                    @endif
                </div>
            </div>

            @if($profile->experience_text)
                <div class="bg-[var(--theme-bg-card)] rounded-3xl p-8 border border-[var(--theme-border)] shadow-xs space-y-4">
                    <h2 class="text-xl font-bold text-[var(--theme-text-heading)]">Work Experience</h2>
                    <div class="text-[var(--theme-text-body)] text-sm sm:text-base leading-relaxed space-y-2">
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
                <div class="bg-[var(--theme-bg-card)] rounded-3xl p-8 border border-[var(--theme-border)] shadow-xs space-y-6">
                    <h2 class="text-xl font-bold text-[var(--theme-text-heading)]">Technical Skills</h2>
                    <div class="space-y-6">
                        @foreach($categories as $category)
                            @if($category->skills->isNotEmpty())
                                <div>
                                    <h3 class="text-xs font-mono font-bold uppercase tracking-wider text-brand mb-3">
                                        {{ $category->name }}
                                    </h3>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($category->skills as $skill)
                                            <span class="px-3 py-1.5 bg-[var(--theme-bg-alt)] text-[var(--theme-text-heading)] border border-[var(--theme-border)] rounded-lg text-xs font-mono font-medium">
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
