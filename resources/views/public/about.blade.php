@extends('public.layouts.app')

@section('title', 'About & Professional Experience - ' . $websiteName)
@section('meta_description', strip_tags($profile->bio ?? '') ?: 'Full Stack Web Developer with 2.5 years of professional experience and 6 months intensive training specializing in Laravel, PHP, and MySQL.')
@if(!empty($profile->og_image_url))
    @section('og_image', $profile->og_image_url)
@endif

@section('content')
<section class="min-h-screen pt-28 sm:pt-36 pb-24 bg-[#F5F7F2]">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-5xl mx-auto space-y-12">
            <!-- Header Card -->
            <div class="bg-white rounded-2xl p-8 sm:p-12 border border-[#E5E7EB] shadow-xs">
                <div class="flex flex-col md:flex-row gap-8 items-start md:items-center">
                    @if($profile->profile_photo_url)
                        <img src="{{ $profile->profile_photo_url }}" alt="{{ $profile->full_name }}"
                            class="w-36 h-36 rounded-2xl object-cover border border-[#E5E7EB] shadow-sm shrink-0">
                    @else
                        <div class="w-36 h-36 rounded-2xl bg-[#DCE8D6] text-[#1B560B] flex items-center justify-center font-bold text-4xl shrink-0">
                            {{ substr($profile->name ?: $websiteName, 0, 1) }}
                        </div>
                    @endif
                    <div class="flex-1 space-y-3">
                        <span class="inline-block text-xs font-bold uppercase tracking-wider text-[#1B560B] bg-[#DCE8D6] px-3 py-1 rounded-full">
                            Full Stack Web Developer
                        </span>
                        <h1 class="text-3xl sm:text-4xl font-extrabold text-[#1F2937] tracking-tight">
                            {{ $profile->name ?: 'Full Stack Developer' }}
                        </h1>
                        <p class="text-base sm:text-lg text-[#667085] leading-relaxed">
                            {{ $profile->subtitle ?: 'Specializing in Laravel, PHP, MySQL, and REST API development for scalable web applications.' }}
                        </p>
                        @if($profile->resume_url && $profile->resume_button_visible)
                            <div class="pt-2">
                                <a href="{{ $profile->resume_url }}" target="_blank" download
                                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg bg-[#1B560B] hover:bg-[#144208] text-white font-medium text-sm transition-all shadow-xs">
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
                <div class="md:col-span-8 bg-white rounded-2xl p-8 border border-[#E5E7EB] shadow-xs space-y-5">
                    <h2 class="text-2xl font-bold text-[#1F2937]">Professional Background</h2>
                    <div class="prose max-w-none text-[#667085] text-base leading-relaxed">
                        {!! $profile->biography ? $profile->biography : nl2br(e($profile->intro ?? 'I am a Full Stack Web Developer with 2.5 years of hands-on professional commercial experience and 6 months of intensive training. I engineer scalable web applications, robust REST APIs, custom administrative dashboards, and database-driven business solutions.')) !!}
                    </div>

                    <div class="pt-6 border-t border-[#E5E7EB]">
                        <h3 class="text-lg font-bold text-[#1F2937] mb-3">Development Approach &amp; Working Style</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm text-[#667085]">
                            <div class="flex items-start gap-2.5">
                                <svg class="w-5 h-5 text-[#1B560B] shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <span><strong>Clean, Maintainable Code:</strong> Following Laravel conventions, PSR standards, and DRY principles.</span>
                            </div>
                            <div class="flex items-start gap-2.5">
                                <svg class="w-5 h-5 text-[#1B560B] shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <span><strong>Database Reliability:</strong> Normalized MySQL schemas, indexed queries, and data integrity.</span>
                            </div>
                            <div class="flex items-start gap-2.5">
                                <svg class="w-5 h-5 text-[#1B560B] shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <span><strong>Clear Communication:</strong> Direct sprint updates, proactive feedback, and milestone delivery.</span>
                            </div>
                            <div class="flex items-start gap-2.5">
                                <svg class="w-5 h-5 text-[#1B560B] shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <span><strong>Security First:</strong> Role-based access control, CSRF &amp; XSS defenses, safe API token handling.</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Structured Highlights Timeline Cards -->
                <div class="md:col-span-4 space-y-6">
                    <div class="bg-white rounded-2xl p-6 border border-[#E5E7EB] shadow-xs space-y-4">
                        <div class="text-3xl font-extrabold text-[#1B560B]">
                            {{ \App\Models\Setting::get('years_experience') ?: '2.5+' }} Years
                        </div>
                        <div class="text-base font-bold text-[#1F2937]">Professional Experience</div>
                        <p class="text-xs text-[#667085] leading-relaxed">
                            Developing full-stack web applications, business management tools, and APIs in active team and freelance environments.
                        </p>
                    </div>

                    <div class="bg-white rounded-2xl p-6 border border-[#E5E7EB] shadow-xs space-y-4">
                        <div class="text-3xl font-extrabold text-[#1B560B]">
                            6 Months
                        </div>
                        <div class="text-base font-bold text-[#1F2937]">Intensive Training</div>
                        <p class="text-xs text-[#667085] leading-relaxed">
                            Dedicated training covering advanced PHP architecture, Laravel framework internals, database schema design, and API integrations.
                        </p>
                    </div>

                    <div class="bg-white rounded-2xl p-6 border border-[#E5E7EB] shadow-xs space-y-4">
                        <div class="text-base font-bold text-[#1F2937]">Primary Stack</div>
                        <div class="flex flex-wrap gap-1.5">
                            <span class="text-xs px-2.5 py-1 rounded bg-[#DCE8D6] text-[#1B560B] font-semibold">Laravel</span>
                            <span class="text-xs px-2.5 py-1 rounded bg-[#DCE8D6] text-[#1B560B] font-semibold">PHP</span>
                            <span class="text-xs px-2.5 py-1 rounded bg-[#DCE8D6] text-[#1B560B] font-semibold">MySQL</span>
                            <span class="text-xs px-2.5 py-1 rounded bg-[#DCE8D6] text-[#1B560B] font-semibold">REST APIs</span>
                            <span class="text-xs px-2.5 py-1 rounded bg-[#F5F7F2] text-[#1F2937] border border-[#E5E7EB]">JavaScript</span>
                            <span class="text-xs px-2.5 py-1 rounded bg-[#F5F7F2] text-[#1F2937] border border-[#E5E7EB]">Bootstrap</span>
                            <span class="text-xs px-2.5 py-1 rounded bg-[#F5F7F2] text-[#1F2937] border border-[#E5E7EB]">Git / GitHub</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact & Inquiries CTA Card -->
            <div class="bg-white rounded-2xl p-8 sm:p-10 border border-[#E5E7EB] shadow-xs flex flex-col sm:flex-row items-center justify-between gap-6">
                <div>
                    <h3 class="text-xl font-bold text-[#1F2937]">Ready to discuss a project?</h3>
                    <p class="text-sm text-[#667085] mt-1">I am available for contract, freelance, and custom application development.</p>
                </div>
                <a href="{{ route('contact') }}"
                    class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-lg bg-[#1B560B] hover:bg-[#144208] text-white font-medium text-sm transition-all shadow-xs shrink-0">
                    Contact &amp; Hire Me
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
