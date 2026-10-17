@extends('admin.layouts.master')

@section('title', 'Add Project')
@section('header', 'New Showcase Project')

@section('admin-content')
<div x-data="{
    activeTab: window.location.hash ? window.location.hash.replace('#', '') : 'overview',
    setActive(tab) {
        this.activeTab = tab;
        window.location.hash = tab;
    }
}" @keydown.window.ctrl.s.prevent="$refs.projectForm.submit()" @keydown.window.meta.s.prevent="$refs.projectForm.submit()" class="space-y-6">

    <!-- Top Header -->
    <div class="flex flex-col gap-4 rounded-2xl border border-[#E5E1D5] bg-gradient-to-br from-white to-[#FAF9F5] p-5 shadow-xs sm:flex-row sm:items-center sm:justify-between sm:p-6">
        <div>
            <div class="flex items-center gap-2">
                <span class="inline-flex h-2 w-2 rounded-full bg-[#B85D19]"></span>
                <p class="text-xs font-mono font-bold uppercase tracking-wider text-[#B85D19]">Portfolio Studio</p>
            </div>
            <h2 class="mt-1 text-xl font-bold tracking-tight text-stone-900 sm:text-2xl">Create New Project</h2>
            <p class="mt-1 text-xs text-stone-500 sm:text-sm">Document case study details, upload screenshots, and highlight your architecture.</p>
        </div>
        <div class="flex items-center gap-2.5">
            <a href="{{ route('admin.projects.index') }}" class="admin-btn-secondary">Back to List</a>
            <button type="button" @click="$refs.projectForm.submit()" class="admin-btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>Publish Project</span>
            </button>
        </div>
    </div>

    @if($errors->any())
        <div class="rounded-xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-800">
            <p class="font-bold">Please correct the errors below:</p>
            <ul class="mt-1 list-disc list-inside space-y-0.5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form x-ref="projectForm" method="POST" action="{{ route('admin.projects.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-12">
            <!-- Left Tabs -->
            <div class="lg:col-span-4 xl:col-span-3">
                <div class="sticky top-24 space-y-1.5 rounded-2xl border border-[#E5E1D5] bg-white p-3 shadow-xs">
                    <p class="px-3 pb-2 pt-1 text-[11px] font-bold uppercase tracking-wider text-stone-400">Project Builder</p>

                    <button type="button" @click="setActive('overview')" :class="activeTab === 'overview' ? 'admin-tab-btn-active' : 'admin-tab-btn-inactive'" class="admin-tab-btn">
                        <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        <div class="min-w-0 flex-1 text-left">
                            <div class="text-sm font-semibold">Overview &amp; Basics</div>
                            <div class="truncate text-[11px] text-stone-400">Title, slug, category, status</div>
                        </div>
                    </button>

                    <button type="button" @click="setActive('media')" :class="activeTab === 'media' ? 'admin-tab-btn-active' : 'admin-tab-btn-inactive'" class="admin-tab-btn">
                        <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <div class="min-w-0 flex-1 text-left">
                            <div class="text-sm font-semibold">Visuals &amp; Gallery</div>
                            <div class="truncate text-[11px] text-stone-400">Thumbnail &amp; screenshots</div>
                        </div>
                    </button>

                    <button type="button" @click="setActive('tech')" :class="activeTab === 'tech' ? 'admin-tab-btn-active' : 'admin-tab-btn-inactive'" class="admin-tab-btn">
                        <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                        </svg>
                        <div class="min-w-0 flex-1 text-left">
                            <div class="text-sm font-semibold">Tech Stack &amp; Specs</div>
                            <div class="truncate text-[11px] text-stone-400">Languages, frameworks, tools</div>
                        </div>
                    </button>

                    <button type="button" @click="setActive('case_study')" :class="activeTab === 'case_study' ? 'admin-tab-btn-active' : 'admin-tab-btn-inactive'" class="admin-tab-btn">
                        <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <div class="min-w-0 flex-1 text-left">
                            <div class="text-sm font-semibold">Case Study Details</div>
                            <div class="truncate text-[11px] text-stone-400">Purpose, features, challenges</div>
                        </div>
                    </button>

                    <button type="button" @click="setActive('links_seo')" :class="activeTab === 'links_seo' ? 'admin-tab-btn-active' : 'admin-tab-btn-inactive'" class="admin-tab-btn">
                        <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                        </svg>
                        <div class="min-w-0 flex-1 text-left">
                            <div class="text-sm font-semibold">Links &amp; SEO</div>
                            <div class="truncate text-[11px] text-stone-400">Live URLs, GitHub, meta tags</div>
                        </div>
                    </button>
                </div>
            </div>

            <!-- Right Content Panels -->
            <div class="lg:col-span-8 xl:col-span-9 space-y-6">

                <!-- TAB: Overview -->
                <div x-show="activeTab === 'overview'" x-cloak class="admin-form-card space-y-5">
                    <div class="admin-form-header">
                        <h3 class="text-base font-bold text-stone-900">Project Overview</h3>
                        <p class="text-xs text-stone-500">Essential identifiers, category classification, and publishing state.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="md:col-span-2">
                            <label class="block text-xs font-semibold uppercase tracking-wider text-stone-600 mb-1.5">Project Title *</label>
                            <input type="text" name="title" value="{{ old('title') }}" required class="admin-input text-base font-bold" placeholder="e.g. Enterprise Logistics & Fleet SaaS">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-stone-600 mb-1.5">Slug (URL Path)</label>
                            <input type="text" name="slug" value="{{ old('slug') }}" class="admin-input font-mono text-xs" placeholder="Auto-generated if left empty">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-stone-600 mb-1.5">Category *</label>
                            <input type="text" name="category" value="{{ old('category') }}" class="admin-input" placeholder="e.g. SaaS / Web Application, E-commerce">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-stone-600 mb-1.5">Client / Organization Name</label>
                            <input type="text" name="client_name" value="{{ old('client_name') }}" class="admin-input" placeholder="e.g. Acme Corp (optional)">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-stone-600 mb-1.5">Display Order</label>
                            <input type="number" name="display_order" value="{{ old('display_order', \App\Models\Project::max('display_order') + 1) }}" class="admin-input font-mono">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-stone-600 mb-1.5">Publishing Status *</label>
                            <select name="status" class="admin-input font-medium">
                                <option value="published" {{ old('status', 'published') === 'published' ? 'selected' : '' }}>Published (Live on site)</option>
                                <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Draft (Hidden)</option>
                            </select>
                        </div>

                        <!-- Featured Toggle -->
                        <div class="rounded-xl border border-[#E5E1D5] bg-[#FAF9F5] p-4 flex items-center justify-between">
                            <div>
                                <span class="text-sm font-bold text-stone-900">Featured Showcase</span>
                                <p class="text-xs text-stone-500 mt-0.5">Show this project in the top featured grid on homepage.</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer shrink-0">
                                <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} class="sr-only peer">
                                <div class="w-11 h-6 bg-stone-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-stone-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#B85D19]"></div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- TAB: Visuals & Media -->
                <div x-show="activeTab === 'media'" x-cloak class="space-y-6">
                    <div class="admin-form-card space-y-5">
                        <div class="admin-form-header">
                            <h3 class="text-base font-bold text-stone-900">Main Thumbnail Card</h3>
                            <p class="text-xs text-stone-500">The primary cover graphic shown on the project card and header.</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wider text-stone-600 mb-1.5">Upload Thumbnail Image</label>
                                <input type="file" name="thumbnail" accept="image/*" class="admin-input text-xs">
                                <p class="text-[11px] text-stone-400 mt-1">Recommended: 1200 &times; 800px (JPG, PNG or WEBP, max 5MB).</p>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wider text-stone-600 mb-1.5">Thumbnail Alt Text</label>
                                <input type="text" name="thumbnail_alt" value="{{ old('thumbnail_alt') }}" class="admin-input" placeholder="e.g. Dashboard interface preview">
                            </div>
                        </div>
                    </div>

                    <div class="admin-form-card space-y-5">
                        <div class="admin-form-header">
                            <h3 class="text-base font-bold text-stone-900">Project Screenshots &amp; Gallery</h3>
                            <p class="text-xs text-stone-500">Upload multiple high-resolution screenshots for the project modal/detail gallery.</p>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-stone-600 mb-1.5">Add Screenshots (Multi-select)</label>
                            <input type="file" name="screenshots[]" accept="image/*" multiple class="admin-input text-xs">
                            <p class="text-[11px] text-stone-400 mt-1">Hold Ctrl/Cmd to select multiple image files at once.</p>
                        </div>
                    </div>
                </div>

                <!-- TAB: Tech Stack -->
                <div x-show="activeTab === 'tech'" x-cloak class="admin-form-card space-y-5">
                    <div class="admin-form-header">
                        <h3 class="text-base font-bold text-stone-900">Technology Stack &amp; Tools</h3>
                        <p class="text-xs text-stone-500">List the primary technologies, frameworks, and architecture tools utilized.</p>
                    </div>

                    <div id="tech-stack-container" class="space-y-2.5">
                        <div class="flex items-center gap-2">
                            <input type="text" name="tech_stack[]" value="Laravel" class="admin-input flex-1" placeholder="e.g. Laravel 11">
                            <button type="button" onclick="this.parentElement.remove()" class="rounded-xl border border-stone-200 p-2.5 text-stone-400 hover:bg-rose-50 hover:text-rose-600 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                        <div class="flex items-center gap-2">
                            <input type="text" name="tech_stack[]" value="MySQL" class="admin-input flex-1" placeholder="e.g. MySQL">
                            <button type="button" onclick="this.parentElement.remove()" class="rounded-xl border border-stone-200 p-2.5 text-stone-400 hover:bg-rose-50 hover:text-rose-600 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                        <div class="flex items-center gap-2">
                            <input type="text" name="tech_stack[]" value="Tailwind CSS" class="admin-input flex-1" placeholder="e.g. Tailwind CSS">
                            <button type="button" onclick="this.parentElement.remove()" class="rounded-xl border border-stone-200 p-2.5 text-stone-400 hover:bg-rose-50 hover:text-rose-600 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                    </div>

                    <button type="button" onclick="addTechInput()" class="inline-flex items-center gap-1.5 text-xs font-bold text-[#B85D19] hover:underline">
                        + Add Another Technology
                    </button>
                </div>

                <!-- TAB: Case Study -->
                <div x-show="activeTab === 'case_study'" x-cloak class="space-y-6">
                    <div class="admin-form-card space-y-5">
                        <div class="admin-form-header">
                            <h3 class="text-base font-bold text-stone-900">Project Description</h3>
                            <p class="text-xs text-stone-500">Provide an engaging, comprehensive summary of the project.</p>
                        </div>

                        <div>
                            <textarea name="description" id="description" rows="7" class="admin-textarea" placeholder="Full narrative describing the goals, architecture and outcome...">{{ old('description') }}</textarea>
                        </div>
                    </div>

                    <div class="admin-form-card space-y-5">
                        <div class="admin-form-header">
                            <h3 class="text-base font-bold text-stone-900">Deep-Dive Case Study Fields</h3>
                            <p class="text-xs text-stone-500">Structured sections displayed on the project detail view.</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wider text-stone-600 mb-1.5">Project Purpose &amp; Goals</label>
                                <textarea name="purpose" rows="3" class="admin-textarea" placeholder="Why was this application built?">{{ old('purpose') }}</textarea>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wider text-stone-600 mb-1.5">Your Engineering Role</label>
                                <textarea name="role" rows="3" class="admin-textarea" placeholder="Full-Stack Developer, Database Design &amp; API Integration...">{{ old('role') }}</textarea>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-xs font-semibold uppercase tracking-wider text-stone-600 mb-1.5">Key Features Implemented</label>
                                <textarea name="key_features" rows="3" class="admin-textarea" placeholder="e.g. Multi-tenant database, automated invoice queue, real-time tracking...">{{ old('key_features') }}</textarea>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wider text-stone-600 mb-1.5">Technical Challenges</label>
                                <textarea name="challenges" rows="3" class="admin-textarea" placeholder="Difficulties solved during development...">{{ old('challenges') }}</textarea>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wider text-stone-600 mb-1.5">Solutions &amp; Architecture</label>
                                <textarea name="solutions" rows="3" class="admin-textarea" placeholder="How the challenges were architected and resolved...">{{ old('solutions') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TAB: Links & SEO -->
                <div x-show="activeTab === 'links_seo'" x-cloak class="space-y-6">
                    <div class="admin-form-card space-y-5">
                        <div class="admin-form-header">
                            <h3 class="text-base font-bold text-stone-900">Live Project URLs</h3>
                            <p class="text-xs text-stone-500">Direct interactive links for visitors to test or inspect the repository.</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wider text-stone-600 mb-1.5">Live Demo URL</label>
                                <input type="url" name="demo_url" value="{{ old('demo_url') }}" class="admin-input" placeholder="https://app.clientproject.com">
                            </div>

                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wider text-stone-600 mb-1.5">GitHub Repository URL</label>
                                <input type="url" name="github_url" value="{{ old('github_url') }}" class="admin-input" placeholder="https://github.com/username/project">
                            </div>
                        </div>
                    </div>

                    <div class="admin-form-card space-y-5">
                        <div class="admin-form-header">
                            <h3 class="text-base font-bold text-stone-900">SEO &amp; Open Graph Metadata</h3>
                            <p class="text-xs text-stone-500">Fine-tune how this project ranks on search engines and shares on social.</p>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wider text-stone-600 mb-1.5">Custom SEO Title</label>
                                <input type="text" name="seo_title" value="{{ old('seo_title') }}" class="admin-input" placeholder="Defaults to project title if empty">
                            </div>

                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wider text-stone-600 mb-1.5">SEO Description</label>
                                <textarea name="seo_description" rows="2" class="admin-textarea" placeholder="Meta description for search engines...">{{ old('seo_description') }}</textarea>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-semibold uppercase tracking-wider text-stone-600 mb-1.5">Canonical URL</label>
                                    <input type="url" name="canonical_url" value="{{ old('canonical_url') }}" class="admin-input" placeholder="https://domain.com/projects/slug">
                                </div>
                                <div class="rounded-xl border border-[#E5E1D5] bg-[#FAF9F5] p-3 flex items-center justify-between">
                                    <span class="text-xs font-bold text-stone-700">No-Index (Hide from Google)</span>
                                    <input type="checkbox" name="no_index" value="1" {{ old('no_index') ? 'checked' : '' }} class="h-4 w-4">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sticky Bottom Bar -->
                <div class="sticky bottom-4 z-20 flex items-center justify-between rounded-2xl border border-[#E5E1D5] bg-white/95 px-5 py-3.5 shadow-lg backdrop-blur">
                    <div class="flex items-center gap-2 text-xs text-stone-500">
                        <span class="inline-block h-2 w-2 rounded-full bg-stone-400"></span>
                        <span>Press <kbd class="rounded bg-stone-100 px-1.5 py-0.5 font-mono text-[10px] text-stone-700 border border-stone-200">Ctrl + S</kbd> to save</span>
                    </div>

                    <div class="flex items-center gap-3">
                        <a href="{{ route('admin.projects.index') }}" class="admin-btn-secondary text-xs">
                            Cancel
                        </a>
                        <button type="submit" class="admin-btn-primary">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Publish Project</span>
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </form>
</div>

<script>
function addTechInput() {
    const container = document.getElementById('tech-stack-container');
    const div = document.createElement('div');
    div.className = 'flex items-center gap-2';
    div.innerHTML = '<input type="text" name="tech_stack[]" value="" class="admin-input flex-1" placeholder="e.g. Redis / Docker / Tailwind">' +
        '<button type="button" onclick="this.parentElement.remove()" class="rounded-xl border border-stone-200 p-2.5 text-stone-400 hover:bg-rose-50 hover:text-rose-600 transition">' +
        '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>';
    container.appendChild(div);
}
</script>
@endsection
