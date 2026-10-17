@extends('public.layouts.app')

@section('title', 'About & Professional Experience - ' . $websiteName)
@section('meta_description', strip_tags($profile->bio ?? '') ?: 'Full Stack Web Developer with 2.5 years of professional experience and 6 months intensive training specializing in Laravel, PHP, and MySQL.')
@if(!empty($profile->og_image_url))
    @section('og_image', $profile->og_image_url)
@endif

@section('content')
<section class="min-h-screen pt-28 sm:pt-36 pb-24 bg-[#080C14] text-slate-100 relative overflow-hidden">
    <!-- Ambient Lighting & Dot Grid -->
    <div class="absolute inset-0 bg-grid-dots-dark opacity-35 pointer-events-none"></div>
    <div class="absolute -top-32 -left-20 w-[500px] h-[500px] bg-[#B85D19]/[0.05] dark:bg-[#E07A5F]/[0.05] rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute top-1/3 -right-20 w-[450px] h-[450px] bg-[#B85D19]/[0.03] dark:bg-[#E07A5F]/[0.04] rounded-full blur-3xl pointer-events-none"></div>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="max-w-5xl mx-auto space-y-12">
            <!-- Header Card -->
            <div class="bg-[#0F172A]/90 backdrop-blur-md rounded-2xl p-8 sm:p-12 border border-black/10 dark:border-white/10 shadow-2xl card-glow-hover">
                <div class="flex flex-col md:flex-row gap-8 items-start md:items-center">
                    @if($profile->profile_photo_url)
                        <img src="{{ $profile->profile_photo_url }}" alt="{{ $profile->full_name }}"
                            class="w-36 h-36 rounded-2xl object-cover border-2 border-brand/40 shadow-xl shrink-0">
                    @else
                        <div class="w-36 h-36 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 text-white flex items-center justify-center font-bold text-4xl shrink-0 shadow-lg">
                            {{ substr($profile->name ?: $websiteName, 0, 1) }}
                        </div>
                    @endif
                    <div class="flex-1 space-y-3">
                        <span class="inline-block text-xs font-bold uppercase tracking-wider text-brand badge-brand px-3.5 py-1 rounded-full shadow-xs">
                            {{ $profile->title ?: 'Full Stack Web Developer' }}
                        </span>
                        <h1 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">
                            {{ $profile->name ?: 'Full Stack Developer' }}
                        </h1>
                        <p class="text-base sm:text-lg text-slate-300 leading-relaxed">
                            {{ $profile->subtitle ?: 'Specializing in Laravel, PHP, MySQL, and REST API development for scalable web applications.' }}
                        </p>
                        @if($profile->resume_url && $profile->resume_button_visible)
                            <div class="pt-2">
                                <a href="{{ $profile->resume_url }}" target="_blank" rel="noopener noreferrer" download
                                    class="theme-btn-primary inline-flex items-center gap-2 px-6 py-3 rounded-xl font-medium text-sm transition-all shadow-sm hover:scale-[1.02]">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1M12 12V2m0 0l-4 4m4-4l4 4M5 14h14a2 2 0 010 4H5a2 2 0 010-4z"></path>
                                    </svg>
                                    Download Resume (PDF)
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Professional Summary & Background -->
            <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-start">
                <div class="md:col-span-8 bg-[#0F172A]/90 rounded-2xl p-8 border border-black/10 dark:border-white/10 shadow-xl space-y-5">
                    <h2 class="text-2xl font-bold text-white">Professional Background</h2>
                    <div class="prose prose-invert max-w-none text-slate-300 text-base leading-relaxed">
                        {!! $profile->biography ? $profile->biography : nl2br(e($profile->intro ?? 'I am a Full Stack Web Developer with 2.5 years of hands-on professional commercial experience and 6 months of intensive training. I engineer scalable web applications, robust REST APIs, custom administrative dashboards, and database-driven business solutions.')) !!}
                    </div>

                    <div class="pt-6 border-t border-black/10 dark:border-white/10">
                        <h3 class="text-lg font-bold text-white mb-3">Development Approach &amp; Working Style</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm text-slate-300">
                            <div class="flex items-start gap-2.5">
                                <svg class="w-5 h-5 text-brand shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <span><strong class="text-white">Clean, Maintainable Code:</strong> Following Laravel conventions, PSR standards, and DRY principles.</span>
                            </div>
                            <div class="flex items-start gap-2.5">
                                <svg class="w-5 h-5 text-brand shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <span><strong class="text-white">Database Reliability:</strong> Normalized MySQL schemas, indexed queries, and data integrity.</span>
                            </div>
                            <div class="flex items-start gap-2.5">
                                <svg class="w-5 h-5 text-brand shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <span><strong class="text-white">Clear Communication:</strong> Direct sprint updates, proactive feedback, and milestone delivery.</span>
                            </div>
                            <div class="flex items-start gap-2.5">
                                <svg class="w-5 h-5 text-brand shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <span><strong class="text-white">Security First:</strong> Role-based access control, CSRF &amp; XSS defenses, safe API token handling.</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Structured Highlights Timeline Cards -->
                <div class="md:col-span-4 space-y-6">
                    <div class="bg-[#0F172A]/90 rounded-2xl p-6 border border-black/10 dark:border-white/10 shadow-xl space-y-4">
                        <div class="text-3xl font-extrabold text-brand">
                            {{ \App\Models\Setting::get('years_experience') ?: '2.5+' }} Years
                        </div>
                        <div class="text-base font-bold text-white">Professional Experience</div>
                        <p class="text-xs text-slate-400 leading-relaxed">
                            Developing full-stack web applications, business management tools, and APIs in active team and freelance environments.
                        </p>
                    </div>

                    <div class="bg-[#0F172A]/90 rounded-2xl p-6 border border-black/10 dark:border-white/10 shadow-xl space-y-4">
                        <div class="text-xl font-extrabold text-brand">
                            {{ ltrim(\App\Models\Setting::get('training_text') ?: '6 Months Intensive Training', '+ ') }}
                        </div>
                        <div class="text-base font-bold text-white">Training &amp; Growth</div>
                        <p class="text-xs text-slate-400 leading-relaxed">
                            Hands-on training covering modern PHP architecture, Laravel, database design, and API integrations.
                        </p>
                    </div>

                    <div class="bg-[#0F172A]/90 rounded-2xl p-6 border border-black/10 dark:border-white/10 shadow-xl space-y-4">
                        <div class="text-base font-bold text-white">Primary Stack</div>
                        <div class="flex flex-wrap gap-1.5">
                            @forelse(($featuredSkills ?? collect()) as $skill)
                                <span class="text-xs px-2.5 py-1 rounded {{ $loop->index < 4 ? 'bg-black/[0.03] dark:bg-white/[0.04] border border-black/10 dark:border-white/[0.08] text-slate-800 dark:text-slate-200 font-medium' : 'bg-black/[0.03] dark:bg-white/[0.04] border border-black/10 dark:border-white/[0.08] text-slate-800 dark:text-slate-200 font-medium' }}">
                                    {{ $skill->name }}
                                </span>
                            @empty
                                <span class="text-xs px-2.5 py-1 rounded bg-black/[0.03] dark:bg-white/[0.04] border border-black/10 dark:border-white/[0.08] text-slate-800 dark:text-slate-200 font-medium">Laravel</span>
                                <span class="text-xs px-2.5 py-1 rounded bg-black/[0.03] dark:bg-white/[0.04] border border-black/10 dark:border-white/[0.08] text-slate-800 dark:text-slate-200 font-medium">PHP</span>
                                <span class="text-xs px-2.5 py-1 rounded bg-black/[0.03] dark:bg-white/[0.04] border border-black/10 dark:border-white/[0.08] text-slate-800 dark:text-slate-200 font-medium">MySQL</span>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact & Inquiries CTA Card -->
            <div class="bg-[#0F172A]/90 rounded-2xl p-8 sm:p-10 border border-black/10 dark:border-white/10 shadow-xl flex flex-col sm:flex-row items-center justify-between gap-6">
                <div>
                    <h3 class="text-xl font-bold text-white">Ready to discuss a project?</h3>
                    <p class="text-sm text-slate-400 mt-1">I am available for contract, freelance, and custom application development.</p>
                </div>
                <a href="{{ route('contact') }}"
                    class="theme-btn-primary inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl font-semibold text-sm transition-all shadow-sm shrink-0 hover:scale-[1.02]">
                    Contact &amp; Hire Me
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
