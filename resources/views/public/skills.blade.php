@extends('public.layouts.app')

@section('title', 'Skills & Technical Expertise - ' . $websiteName)
@section('meta_description', 'Explore my technical skills and competencies across Backend, Frontend, Databases, APIs, and Development Tools.')

@section('content')
<section class="min-h-screen pt-28 sm:pt-36 pb-24 bg-[#F5F7F2]">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto">
            <!-- Header Section -->
            <div class="text-center mb-16">
                <span class="inline-block text-xs font-bold uppercase tracking-wider text-[#1B560B] bg-[#DCE8D6] px-3.5 py-1 rounded-full mb-3.5">
                    Technical Stack
                </span>
                <h1 class="text-4xl sm:text-5xl font-extrabold text-[#1F2937] tracking-tight mb-4">
                    Skills &amp; Technologies
                </h1>
                <p class="text-base sm:text-lg text-[#667085] max-w-2xl mx-auto leading-relaxed">
                    Organized by domain expertise. Clean, modern tools and frameworks applied across real-world commercial projects.
                </p>
            </div>

            <!-- Categorized Skills Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @forelse($categories as $category)
                    @if($category->skills->isNotEmpty())
                        <div class="bg-white rounded-2xl border border-[#E5E7EB] p-7 sm:p-8 shadow-xs flex flex-col justify-between">
                            <div>
                                <div class="flex items-center justify-between pb-4 border-b border-[#E5E7EB] mb-6">
                                    <div class="flex items-center gap-3">
                                        <span class="w-3 h-3 rounded-full bg-[#1B560B]"></span>
                                        <h2 class="text-xl font-bold text-[#1F2937]">
                                            {{ $category->name }}
                                        </h2>
                                    </div>
                                    <span class="text-xs font-medium px-2.5 py-1 rounded-full bg-[#F5F7F2] text-[#667085] border border-[#E5E7EB]">
                                        {{ $category->skills->count() }} {{ Str::plural('Skill', $category->skills->count()) }}
                                    </span>
                                </div>

                                <div class="space-y-4">
                                    @foreach($category->skills as $skill)
                                        <div>
                                            <div class="flex items-center justify-between gap-3 mb-1.5">
                                                <div class="flex items-center gap-2 min-w-0">
                                                    @if($skill->is_featured)
                                                        <span class="w-1.5 h-1.5 rounded-full bg-[#1B560B] shrink-0"></span>
                                                    @endif
                                                    <span class="text-sm font-semibold text-[#1F2937] truncate">{{ $skill->name }}</span>
                                                </div>
                                                @if($skill->proficiency)
                                                    <span class="text-[11px] font-medium text-[#667085] shrink-0">{{ $skill->proficiency_label }}</span>
                                                @endif
                                            </div>
                                            @if($skill->proficiency)
                                                <div class="h-1.5 rounded-full bg-[#F5F7F2] border border-[#E5E7EB] overflow-hidden">
                                                    <div class="h-full rounded-full bg-[#1B560B] transition-all duration-500"
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
                    <div class="col-span-full text-center py-12 bg-white rounded-2xl border border-[#E5E7EB]">
                        <p class="text-[#667085]">No skills published yet.</p>
                    </div>
                @endforelse
            </div>

            <!-- Inquire CTA Strip -->
            <div class="mt-14 bg-white rounded-2xl p-8 border border-[#E5E7EB] shadow-xs flex flex-col sm:flex-row items-center justify-between gap-6">
                <div>
                    <h3 class="text-xl font-bold text-[#1F2937]">Need a developer with these specific capabilities?</h3>
                    <p class="text-sm text-[#667085] mt-1">Available to discuss custom full-stack solutions for your business.</p>
                </div>
                <a href="{{ route('contact') }}"
                    class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-lg bg-[#1B560B] hover:bg-[#144208] text-white font-medium text-sm transition-all shadow-xs shrink-0">
                    Hire Me Now
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
