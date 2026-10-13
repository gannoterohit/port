@extends('public.layouts.app')

@section('title', 'Skills & Technical Expertise - ' . $websiteName)
@section('meta_description', 'Explore my technical skills and competencies across Backend, Frontend, Databases, APIs, and Development Tools.')

@section('content')
<section class="min-h-screen pt-28 sm:pt-36 pb-24 bg-[#080C14] text-slate-100 relative overflow-hidden">
    <!-- Ambient Lighting & Dot Grid -->
    <div class="absolute inset-0 bg-grid-dots-dark opacity-35 pointer-events-none"></div>
    <div class="absolute -top-32 -left-20 w-[500px] h-[500px] bg-emerald-500/15 rounded-full blur-3xl pointer-events-none animate-pulse-glow"></div>
    <div class="absolute top-1/3 -right-20 w-[450px] h-[450px] bg-teal-500/10 rounded-full blur-3xl pointer-events-none animate-float-delayed"></div>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="max-w-6xl mx-auto">
            <!-- Header Section -->
            <div class="text-center mb-16">
                <span class="inline-block text-xs font-bold uppercase tracking-wider text-emerald-400 bg-emerald-500/10 border border-emerald-500/30 px-3.5 py-1 rounded-full mb-3.5 shadow-xs">
                    Technical Stack
                </span>
                <h1 class="text-4xl sm:text-5xl font-extrabold text-white tracking-tight mb-4">
                    Skills &amp; Technologies
                </h1>
                <p class="text-base sm:text-lg text-slate-400 max-w-2xl mx-auto leading-relaxed">
                    Organized by domain expertise. Clean, modern tools and frameworks applied across real-world commercial projects.
                </p>
            </div>

            <!-- Categorized Skills Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @forelse($categories as $category)
                    @if($category->skills->isNotEmpty())
                        <div class="bg-[#0F172A]/90 rounded-2xl border border-slate-800 p-7 sm:p-8 shadow-xl flex flex-col justify-between card-glow-hover">
                            <div>
                                <div class="flex items-center justify-between pb-4 border-b border-slate-800 mb-6">
                                    <div class="flex items-center gap-3">
                                        <span class="w-3 h-3 rounded-full bg-emerald-400 shadow-sm shadow-emerald-400/50"></span>
                                        <h2 class="text-xl font-bold text-white">
                                            {{ $category->name }}
                                        </h2>
                                    </div>
                                    <span class="text-xs font-medium px-2.5 py-1 rounded-full bg-slate-800 text-slate-300 border border-slate-700">
                                        {{ $category->skills->count() }} {{ Str::plural('Skill', $category->skills->count()) }}
                                    </span>
                                </div>

                                <div class="space-y-4">
                                    @foreach($category->skills as $skill)
                                        <div>
                                            <div class="flex items-center justify-between gap-3 mb-1.5">
                                                <div class="flex items-center gap-2 min-w-0">
                                                    @if($skill->is_featured)
                                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 shrink-0"></span>
                                                    @endif
                                                    <span class="text-sm font-semibold text-white truncate">{{ $skill->name }}</span>
                                                </div>
                                                @if($skill->proficiency)
                                                    <span class="text-[11px] font-medium text-slate-400 shrink-0">{{ $skill->proficiency_label }}</span>
                                                @endif
                                            </div>
                                            @if($skill->proficiency)
                                                <div class="h-1.5 rounded-full bg-slate-800 border border-slate-700/60 overflow-hidden">
                                                    <div class="h-full rounded-full bg-gradient-to-r from-emerald-500 to-teal-400 transition-all duration-500"
                                                        style="width: {{ min(100, max(8, $skill->proficiency * 20)) }}%"></div>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                @empty
                    <div class="col-span-full text-center py-12 bg-[#0F172A]/90 rounded-2xl border border-slate-800">
                        <p class="text-slate-400">No skills published yet.</p>
                    </div>
                @endforelse
            </div>

            <!-- Inquire CTA Strip -->
            <div class="mt-14 bg-[#0F172A]/90 rounded-2xl p-8 border border-slate-800 shadow-xl flex flex-col sm:flex-row items-center justify-between gap-6">
                <div>
                    <h3 class="text-xl font-bold text-white">Need a developer with these specific capabilities?</h3>
                    <p class="text-sm text-slate-400 mt-1">Available to discuss custom full-stack solutions for your business.</p>
                </div>
                <a href="{{ route('contact') }}"
                    class="btn-shimmer-effect inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-500 hover:from-emerald-500 hover:to-teal-400 text-white font-semibold text-sm transition-all shadow-lg shadow-emerald-500/25 shrink-0">
                    Hire Me Now
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
