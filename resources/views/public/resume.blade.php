@extends('public.layouts.app')

@section('title', 'Resume / CV - ' . $websiteName)
@section('meta_description', $profile->biography ? strip_tags($profile->biography) : $siteDescription)
@if(!empty($profile->og_image_url))
    @section('og_image', $profile->og_image_url)
@endif

@section('content')
<section class="min-h-screen pt-28 sm:pt-36 pb-24 bg-[#080C14] text-slate-100 relative overflow-hidden">
    <!-- Ambient Lighting & Dot Grid -->
    <div class="absolute inset-0 bg-grid-dots-dark opacity-35 pointer-events-none"></div>
    <div class="absolute -top-32 -left-20 w-[500px] h-[500px] bg-emerald-500/15 rounded-full blur-3xl pointer-events-none animate-pulse-glow"></div>
    <div class="absolute top-1/3 -right-20 w-[450px] h-[450px] bg-teal-500/10 rounded-full blur-3xl pointer-events-none animate-float-delayed"></div>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="max-w-4xl mx-auto space-y-8">
            <!-- Header -->
            <div class="bg-[#0F172A]/90 rounded-2xl p-8 sm:p-10 border border-slate-800 shadow-xl flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 card-glow-hover">
                <div>
                    <span class="inline-block text-xs font-bold uppercase tracking-wider text-emerald-400 bg-emerald-500/10 border border-emerald-500/30 px-3.5 py-1 rounded-full mb-3 shadow-xs">
                        Curriculum Vitae
                    </span>
                    <h1 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">{{ $profile->name ?: 'Full Stack Developer' }}</h1>
                    <p class="text-sm sm:text-base text-slate-400 mt-1">{{ $profile->title ?: 'Laravel & MySQL Specialist' }}</p>
                </div>
                @if($profile->resume_url && $profile->resume_button_visible)
                    <a href="{{ route('resume.download') }}" target="_blank" rel="noopener noreferrer" download
                        class="btn-shimmer-effect inline-flex items-center gap-2 bg-gradient-to-r from-emerald-600 to-teal-500 hover:from-emerald-500 hover:to-teal-400 text-white px-6 py-3.5 rounded-xl text-sm font-semibold shadow-lg shadow-emerald-500/25 transition-all shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1M12 12V2m0 0l-4 4m4-4l4 4M5 14h14a2 2 0 010 4H5a2 2 0 010-4z"></path>
                        </svg>
                        Download PDF
                    </a>
                @else
                    <a href="{{ route('contact') }}"
                        class="btn-shimmer-effect inline-flex items-center gap-2 bg-gradient-to-r from-emerald-600 to-teal-500 hover:from-emerald-500 hover:to-teal-400 text-white px-6 py-3.5 rounded-xl text-sm font-semibold shadow-lg shadow-emerald-500/25 transition-all shrink-0">
                        Contact / Hire Me
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                @endif
            </div>

            <!-- Experience & Training Highlights -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="bg-[#0F172A]/90 rounded-2xl p-6 border border-slate-800 shadow-xl">
                    <div class="text-2xl font-bold text-emerald-400 mb-1">{{ \App\Models\Setting::get('years_experience') ?: '2.5+' }} Years</div>
                    <div class="font-semibold text-sm text-white">Commercial Experience</div>
                    <p class="text-xs text-slate-400 mt-2 leading-relaxed">Active commercial web development specializing in Laravel, PHP, MySQL, and full-stack software architecture.</p>
                </div>
                <div class="bg-[#0F172A]/90 rounded-2xl p-6 border border-slate-800 shadow-xl">
                    <div class="text-2xl font-bold text-teal-400 mb-1">6 Months</div>
                    <div class="font-semibold text-sm text-white">Intensive Training</div>
                    <p class="text-xs text-slate-400 mt-2 leading-relaxed">Specialized training in software engineering fundamentals, database optimization, and API engineering.</p>
                </div>
            </div>

            <!-- Biography / Executive Summary -->
            <div class="bg-[#0F172A]/90 rounded-2xl p-8 border border-slate-800 shadow-xl">
                <h2 class="text-xl font-bold text-white mb-4">Executive Summary</h2>
                <div class="prose prose-invert max-w-none text-slate-300 text-base leading-relaxed">
                    @if($profile->biography)
                        {!! $profile->biography !!}
                    @else
                        <p>{{ $profile->intro ?: 'Full Stack Web Developer crafting scalable applications and APIs.' }}</p>
                    @endif
                </div>
            </div>

            @if($profile->experience_text)
                <div class="bg-[#0F172A]/90 rounded-2xl p-8 border border-slate-800 shadow-xl">
                    <h2 class="text-xl font-bold text-white mb-4">Work Experience</h2>
                    <div class="prose prose-invert max-w-none text-slate-300 text-base leading-relaxed">
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
                <div class="bg-[#0F172A]/90 rounded-2xl p-8 border border-slate-800 shadow-xl space-y-6">
                    <h2 class="text-xl font-bold text-white">Technical Skills</h2>
                    <div class="space-y-6">
                        @foreach($categories as $category)
                            @if($category->skills->isNotEmpty())
                                <div>
                                    <h3 class="text-sm font-bold uppercase tracking-wider text-emerald-400 mb-3">
                                        {{ $category->name }}
                                    </h3>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($category->skills as $skill)
                                            <span class="px-3 py-1.5 bg-slate-800 text-slate-200 border border-slate-700/60 rounded-lg text-sm font-medium">
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
