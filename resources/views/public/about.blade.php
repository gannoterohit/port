@extends('public.layouts.app')

@section('title', 'About & Professional Experience - ' . $websiteName)
@section('meta_description', Str::limit(strip_tags($profile->intro ?? $profile->bio ?? ''), 160) ?: 'Laravel backend developer Rohit Gannote — admin panels, REST APIs, MySQL, and business web applications. Based in Indore, India.')
@if(!empty($profile->og_image_url))
    @section('og_image', $profile->og_image_url)
@endif

@section('content')
<section class="min-h-0 sm:min-h-screen pt-24 sm:pt-36 pb-28 sm:pb-24 bg-[var(--theme-bg-canvas)] text-[var(--theme-text-heading)] relative overflow-hidden transition-colors duration-200">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10 max-w-7xl 2xl:max-w-[1400px]">
        <div class="max-w-6xl 2xl:max-w-7xl mx-auto space-y-10">
            
            <!-- Header Card -->
            <div class="bg-[var(--theme-bg-card)] rounded-2xl sm:rounded-3xl p-6 sm:p-12 border border-[var(--theme-border)] shadow-xs">
                <div class="flex flex-col md:flex-row gap-8 items-start md:items-center">
                    @if($profile->profile_photo_url)
                        <img src="{{ $profile->profile_photo_url }}" alt="{{ $profile->full_name }}"
                            class="w-32 h-32 sm:w-36 sm:h-36 rounded-2xl object-cover border-2 border-brand/40 shadow-sm shrink-0">
                    @else
                        <div class="w-32 h-32 sm:w-36 sm:h-36 rounded-2xl bg-brand/10 text-brand flex items-center justify-center font-bold text-4xl shrink-0 border border-brand/20">
                            {{ substr($profile->name ?: $websiteName, 0, 1) }}
                        </div>
                    @endif
                    <div class="flex-1 space-y-3">
                        <span class="inline-block text-xs font-bold uppercase tracking-wider text-brand badge-brand px-3.5 py-1 rounded-full shadow-2xs">
                            {{ $profile->title ?: 'Full Stack Web Developer' }}
                        </span>
                        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-[var(--theme-text-heading)] tracking-tight">
                            {{ $profile->name ?: 'Full Stack Developer' }}
                        </h1>
                        <p class="text-base sm:text-lg text-[var(--theme-text-body)] leading-relaxed max-w-2xl">
                            {{ $profile->subtitle ?: 'Specializing in Laravel, PHP, MySQL, and REST API development for scalable web applications.' }}
                        </p>
                        @if($profile->resume_url && $profile->resume_button_visible)
                            <div class="pt-2 flex flex-wrap gap-3">
                                <a href="{{ route('resume.download') }}" target="_blank" rel="noopener noreferrer" download
                                    class="theme-btn-primary inline-flex items-center gap-2 px-6 py-3 rounded-full font-medium text-xs sm:text-sm transition-all shadow-sm hover:scale-[1.02]">
                                    <svg class="w-4 h-4 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1M12 12V2m0 0l-4 4m4-4l4 4M5 14h14a2 2 0 010 4H5a2 2 0 010-4z"></path>
                                    </svg>
                                    <span>Download Resume (PDF)</span>
                                </a>
                                <a href="{{ route('resume') }}"
                                    class="theme-btn-secondary inline-flex items-center gap-2 px-5 py-3 rounded-full border text-xs sm:text-sm font-medium transition-all">
                                    <span>View Online CV</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Professional Summary & Background -->
            <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-start">
                <div class="md:col-span-8 bg-[var(--theme-bg-card)] rounded-3xl p-8 sm:p-10 border border-[var(--theme-border)] shadow-xs space-y-6">
                    <h2 class="text-2xl font-bold text-[var(--theme-text-heading)]">Professional Background</h2>
                    <div class="text-[var(--theme-text-body)] text-base leading-relaxed space-y-4">
                        {!! $profile->biography ? $profile->biography : nl2br(e($profile->intro ?? 'I am a Full Stack Web Developer with 2.5 years of hands-on professional commercial experience and 6 months of intensive training. I engineer scalable web applications, robust REST APIs, custom administrative dashboards, and database-driven business solutions.')) !!}
                    </div>

                    <div class="pt-6 border-t border-[var(--theme-border)]">
                        <h3 class="text-lg font-bold text-[var(--theme-text-heading)] mb-4">Development Approach &amp; Working Style</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs sm:text-sm text-[var(--theme-text-body)]">
                            <div class="flex items-start gap-2.5 p-3.5 rounded-2xl bg-[var(--theme-bg-alt)] border border-[var(--theme-border)]">
                                <svg class="w-4 h-4 text-brand shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                <span><strong class="text-[var(--theme-text-heading)]">Clean, Maintainable Code:</strong> Following Laravel conventions, PSR standards, and DRY principles.</span>
                            </div>
                            <div class="flex items-start gap-2.5 p-3.5 rounded-2xl bg-[var(--theme-bg-alt)] border border-[var(--theme-border)]">
                                <svg class="w-4 h-4 text-brand shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                <span><strong class="text-[var(--theme-text-heading)]">Database Reliability:</strong> Normalized MySQL schemas, indexed queries, and data integrity.</span>
                            </div>
                            <div class="flex items-start gap-2.5 p-3.5 rounded-2xl bg-[var(--theme-bg-alt)] border border-[var(--theme-border)]">
                                <svg class="w-4 h-4 text-brand shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                <span><strong class="text-[var(--theme-text-heading)]">Clear Communication:</strong> Direct sprint updates, proactive feedback, and milestone delivery.</span>
                            </div>
                            <div class="flex items-start gap-2.5 p-3.5 rounded-2xl bg-[var(--theme-bg-alt)] border border-[var(--theme-border)]">
                                <svg class="w-4 h-4 text-brand shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                <span><strong class="text-[var(--theme-text-heading)]">Security First:</strong> Role-based access control, CSRF &amp; XSS defenses, safe API token handling.</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Structured Highlights Timeline Cards -->
                <div class="md:col-span-4 space-y-5">
                    <div class="bg-[var(--theme-bg-card)] rounded-3xl p-6 sm:p-7 border border-[var(--theme-border)] shadow-xs space-y-3">
                        <div class="text-3xl font-extrabold text-brand">
                            {{ \App\Models\Setting::get('years_experience') ?: '2.5+' }} Years
                        </div>
                        <div class="text-base font-bold text-[var(--theme-text-heading)]">Professional Experience</div>
                        <p class="text-xs text-[var(--theme-text-body)] leading-relaxed">
                            Building Laravel backends, admin panels, REST APIs, and database-driven business tools in professional and freelance projects.
                        </p>
                    </div>

                    <div class="bg-[var(--theme-bg-card)] rounded-3xl p-6 sm:p-7 border border-[var(--theme-border)] shadow-xs space-y-3">
                        <div class="text-xl font-extrabold text-brand">
                            {{ ltrim(\App\Models\Setting::get('training_text') ?: '6 Months Intensive Training', '+ ') }}
                        </div>
                        <div class="text-base font-bold text-[var(--theme-text-heading)]">Training &amp; Growth</div>
                        <p class="text-xs text-[var(--theme-text-body)] leading-relaxed">
                            Hands-on training covering modern PHP architecture, Laravel, database design, and API integrations.
                        </p>
                    </div>

                    <div class="bg-[var(--theme-bg-card)] rounded-3xl p-6 sm:p-7 border border-[var(--theme-border)] shadow-xs space-y-3">
                        <div class="text-base font-bold text-[var(--theme-text-heading)]">Primary Stack</div>
                        <div class="flex flex-wrap gap-1.5">
                            @forelse(($featuredSkills ?? collect()) as $skill)
                                <span class="text-xs font-mono px-2.5 py-1 rounded-md bg-[var(--theme-bg-alt)] border border-[var(--theme-border)] text-[var(--theme-text-heading)] font-medium">
                                    {{ $skill->name }}
                                </span>
                            @empty
                                <span class="text-xs font-mono px-2.5 py-1 rounded-md bg-[var(--theme-bg-alt)] border border-[var(--theme-border)] text-[var(--theme-text-heading)] font-medium">Laravel</span>
                                <span class="text-xs font-mono px-2.5 py-1 rounded-md bg-[var(--theme-bg-alt)] border border-[var(--theme-border)] text-[var(--theme-text-heading)] font-medium">PHP</span>
                                <span class="text-xs font-mono px-2.5 py-1 rounded-md bg-[var(--theme-bg-alt)] border border-[var(--theme-border)] text-[var(--theme-text-heading)] font-medium">MySQL</span>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact & Inquiries CTA Card -->
            <div class="bg-[var(--theme-bg-card)] rounded-3xl p-8 sm:p-10 border border-[var(--theme-border)] shadow-xs flex flex-col sm:flex-row items-center justify-between gap-6">
                <div>
                    <h3 class="text-xl font-bold text-[var(--theme-text-heading)]">Ready to discuss a project?</h3>
                    <p class="text-sm text-[var(--theme-text-body)] mt-1">I am available for contract, freelance, and custom application development.</p>
                </div>
                <a href="{{ route('contact') }}"
                    class="theme-btn-primary inline-flex items-center justify-center gap-2 px-7 py-3.5 rounded-full font-semibold text-xs sm:text-sm transition-all shadow-sm shrink-0 hover:scale-[1.02]">
                    <span>Contact &amp; Hire Me</span>
                    <svg class="w-4 h-4 ml-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
