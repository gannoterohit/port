@extends('public.layouts.app')

@section('title', 'Skills & Technical Expertise - ' . $websiteName)
@section('meta_description', 'Explore my technical skills and competencies across Backend, Frontend, Databases, APIs, and Development Tools.')

@section('content')
<section class="min-h-screen pt-28 sm:pt-36 pb-24 bg-[var(--theme-bg-canvas)] text-[var(--theme-text-heading)] relative overflow-hidden transition-colors duration-200">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10 max-w-7xl 2xl:max-w-[1400px]">
        <div class="max-w-7xl 2xl:max-w-[1400px] mx-auto">
            <!-- Header Section -->
            <div class="text-center mb-16">
                <span class="inline-block text-xs font-bold uppercase tracking-wider text-brand badge-brand px-3.5 py-1 rounded-full mb-3.5 shadow-2xs">
                    Technical Stack
                </span>
                <h1 class="text-4xl sm:text-5xl font-extrabold text-[var(--theme-text-heading)] tracking-tight mb-4">
                    Skills &amp; Technologies
                </h1>
                <p class="text-base sm:text-lg text-[var(--theme-text-body)] max-w-2xl mx-auto leading-relaxed">
                    Organized by domain expertise. Clean, modern tools and frameworks applied across real-world commercial projects.
                </p>
            </div>

            <!-- Categorized Skills Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @forelse($categories as $category)
                    @if($category->skills->isNotEmpty())
                        <div class="bg-[var(--theme-bg-card)] rounded-3xl border border-[var(--theme-border)] p-7 sm:p-8 shadow-xs flex flex-col justify-between">
                            <div>
                                <div class="flex items-center justify-between pb-4 border-b border-[var(--theme-border)] mb-6">
                                    <div class="flex items-center gap-3">
                                        <span class="w-3 h-3 rounded-full bg-brand"></span>
                                        <h2 class="text-xl font-bold text-[var(--theme-text-heading)]">
                                            {{ $category->name }}
                                        </h2>
                                    </div>
                                    <span class="text-xs font-medium px-2.5 py-1 rounded-full bg-[var(--theme-bg-alt)] text-[var(--theme-text-muted)] border border-[var(--theme-border)]">
                                        {{ $category->skills->count() }} {{ Str::plural('Skill', $category->skills->count()) }}
                                    </span>
                                </div>

                                <div class="space-y-4">
                                    @foreach($category->skills as $skill)
                                        <div>
                                            <div class="flex items-center justify-between gap-3 mb-1.5">
                                                <div class="flex items-center gap-2 min-w-0">
                                                    @if($skill->is_featured)
                                                        <span class="w-1.5 h-1.5 rounded-full bg-brand shrink-0"></span>
                                                    @endif
                                                    <span class="text-sm font-semibold text-[var(--theme-text-heading)] truncate">{{ $skill->name }}</span>
                                                </div>
                                                @if($skill->proficiency)
                                                    <span class="text-[11px] font-mono text-[var(--theme-text-muted)] shrink-0">{{ $skill->proficiency_label }}</span>
                                                @endif
                                            </div>
                                            @if($skill->proficiency)
                                                <div class="h-1.5 rounded-full bg-[var(--theme-bg-alt)] border border-[var(--theme-border)] overflow-hidden">
                                                    <div class="h-full rounded-full bg-brand transition-all duration-500"
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
                    <div class="col-span-full text-center py-12 bg-[var(--theme-bg-card)] rounded-3xl border border-[var(--theme-border)]">
                        <p class="text-[var(--theme-text-muted)]">No skills published yet.</p>
                    </div>
                @endforelse
            </div>

            <!-- Inquire CTA Strip -->
            <div class="mt-14 bg-[var(--theme-bg-card)] rounded-3xl p-8 border border-[var(--theme-border)] shadow-xs flex flex-col sm:flex-row items-center justify-between gap-6">
                <div>
                    <h3 class="text-xl font-bold text-[var(--theme-text-heading)]">Need a developer with these specific capabilities?</h3>
                    <p class="text-sm text-[var(--theme-text-body)] mt-1">Available to discuss custom full-stack solutions for your business.</p>
                </div>
                <a href="{{ route('contact') }}"
                    class="theme-btn-primary inline-flex items-center justify-center gap-2 px-7 py-3.5 rounded-full font-semibold text-xs sm:text-sm transition-all shadow-sm shrink-0 hover:scale-[1.02]">
                    <span>Hire Me Now</span>
                    <svg class="w-4 h-4 ml-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
