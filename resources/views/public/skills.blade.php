@extends('public.layouts.app')

@section('title', 'Skills & Technical Expertise - ' . $websiteName)
@section('meta_description', 'Explore my technical skills, proficiencies, tools, and developer stack across Backend, Frontend, Databases, and APIs.')

@section('content')
<section class="min-h-screen pt-28 sm:pt-36 pb-20 bg-slate-50 dark:bg-slate-950">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-5xl mx-auto">
            <!-- Header Section -->
            <div class="text-center mb-16">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold uppercase tracking-wider bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300 mb-4">
                    Expertise & Toolkit
                </div>
                <h1 class="text-4xl sm:text-5xl font-extrabold text-slate-900 dark:text-white tracking-tight mb-4">
                    Skills & Tech Stack
                </h1>
                <p class="text-lg text-slate-600 dark:text-slate-400 max-w-2xl mx-auto">
                    A comprehensive overview of the programming languages, frameworks, databases, and development tools I work with daily.
                </p>
            </div>

            <!-- Categories & Skills Grid -->
            <div class="space-y-10">
                @forelse($categories as $category)
                    @if($category->skills->isNotEmpty())
                        <div class="bg-white dark:bg-slate-900/70 rounded-2xl shadow-sm border border-slate-200/80 dark:border-slate-800 p-6 sm:p-8 backdrop-blur-sm transition-all hover:shadow-md">
                            <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-100 dark:border-slate-800">
                                <div class="flex items-center gap-3">
                                    <span class="w-3.5 h-3.5 rounded-full inline-block" style="background-color: {{ $category->color ?? '#3b82f6' }}"></span>
                                    <h2 class="text-2xl font-bold text-slate-900 dark:text-white">
                                        {{ $category->name }}
                                    </h2>
                                </div>
                                <span class="text-xs font-medium px-2.5 py-1 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400">
                                    {{ $category->skills->count() }} {{ Str::plural('Skill', $category->skills->count()) }}
                                </span>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($category->skills as $skill)
                                    <div class="p-4 bg-slate-50 dark:bg-slate-800/60 rounded-xl border border-slate-100 dark:border-slate-700/50 hover:border-blue-400 dark:hover:border-blue-500 transition-all group">
                                        <div class="flex items-center justify-between mb-2">
                                            <div class="flex items-center gap-2">
                                                @if($skill->is_featured)
                                                    <svg class="w-4 h-4 text-amber-500" fill="currentColor" viewBox="0 0 20 20" title="Featured Skill">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                    </svg>
                                                @endif
                                                <span class="text-slate-900 dark:text-slate-100 font-semibold group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                                    {{ $skill->name }}
                                                </span>
                                            </div>
                                            <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">
                                                {{ $skill->proficiency }}%
                                            </span>
                                        </div>

                                        @if($skill->description)
                                            <p class="text-xs text-slate-500 dark:text-slate-400 mb-3 line-clamp-1">
                                                {{ $skill->description }}
                                            </p>
                                        @endif

                                        <div class="w-full h-2 bg-slate-200 dark:bg-slate-700 rounded-full overflow-hidden">
                                            <div class="h-full rounded-full transition-all duration-500"
                                                 style="width: {{ $skill->proficiency }}%; background-color: {{ $category->color ?? 'var(--primary-color, #2563eb)' }}">
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @empty
                    <div class="text-center py-12 bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800">
                        <p class="text-slate-500 dark:text-slate-400">No skills published yet.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</section>
@endsection
