@extends('admin.layouts.master')

@section('title', 'Homepage Management')
@section('header', 'Homepage Management')

@section('admin-content')
<form method="POST" action="{{ route('admin.homepage.update') }}" enctype="multipart/form-data" class="space-y-6">
    @csrf
    @method('PUT')

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Hero Section</h3>
        <div class="space-y-4">
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                <span class="text-sm font-medium text-gray-700">Enable Hero Section</span>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="hero_section_enabled" value="1" {{ $settings->hero_section_enabled ? 'checked' : '' }} class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-700"></div>
                </label>
            </div>

            <div class="flex flex-col sm:flex-row items-start sm:items-end gap-6">
                <div class="flex-1 w-full">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Hero Heading</label>
                    <input type="text" name="hero_heading" value="{{ old('hero_heading', $settings->hero_heading) }}"
                        class="admin-input" placeholder="e.g., Full Stack Web Developer">
                </div>

                <div class="flex items-center justify-center w-24 h-24 bg-gray-100 rounded-lg border-2 border-dashed border-gray-300 overflow-hidden flex-shrink-0">
                    @if($settings->hero_image)
                        <img src="{{ $settings->hero_image_url }}" alt="Hero Image" class="w-24 h-24 object-cover">
                    @else
                        <span class="text-gray-400 text-xs text-center px-2">No Image</span>
                    @endif
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Hero Title</label>
                <input type="text" name="hero_title" value="{{ old('hero_title', $settings->hero_title) }}"
                    class="admin-input" placeholder="e.g., Building Scalable Web Applications">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Hero Description</label>
                <textarea name="hero_description" rows="3"
                    class="admin-textarea" placeholder="Brief description...">{{ old('hero_description', $settings->hero_description) }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Hero Image Upload</label>
                <input type="file" name="hero_image" accept="image/*" class="admin-input">
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Call-to-Action Buttons</h3>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Primary CTA Text</label>
                <input type="text" name="primary_cta_text" value="{{ old('primary_cta_text', $settings->primary_cta_text) }}"
                    class="admin-input" placeholder="e.g., View My Work">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Primary CTA URL</label>
                <input type="text" name="primary_cta_url" value="{{ old('primary_cta_url', $settings->primary_cta_url) }}"
                    class="admin-input" placeholder="/projects">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Secondary CTA Text</label>
                <input type="text" name="secondary_cta_text" value="{{ old('secondary_cta_text', $settings->secondary_cta_text) }}"
                    class="admin-input" placeholder="e.g., Contact Me">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Secondary CTA URL</label>
                <input type="text" name="secondary_cta_url" value="{{ old('secondary_cta_url', $settings->secondary_cta_url) }}"
                    class="admin-input" placeholder="/contact">
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Section Visibility</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                <span class="text-sm font-medium text-gray-700">About Section</span>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="about_section_enabled" value="1" {{ $settings->about_section_enabled ? 'checked' : '' }} class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-700"></div>
                </label>
            </div>

            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                <span class="text-sm font-medium text-gray-700">Skills Section</span>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="skills_section_enabled" value="1" {{ $settings->skills_section_enabled ? 'checked' : '' }} class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-700"></div>
                </label>
            </div>

            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                <span class="text-sm font-medium text-gray-700">Projects Section</span>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="projects_section_enabled" value="1" {{ $settings->projects_section_enabled ? 'checked' : '' }} class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-700"></div>
                </label>
            </div>

            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                <span class="text-sm font-medium text-gray-700">Services Section</span>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="services_section_enabled" value="1" {{ $settings->services_section_enabled ? 'checked' : '' }} class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-700"></div>
                </label>
            </div>

            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                <span class="text-sm font-medium text-gray-700">Work Process Section</span>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="work_process_section_enabled" value="1" {{ $settings->work_process_section_enabled ? 'checked' : '' }} class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-700"></div>
                </label>
            </div>

            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                <span class="text-sm font-medium text-gray-700">Testimonials Section</span>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="testimonials_section_enabled" value="1" {{ $settings->testimonials_section_enabled ? 'checked' : '' }} class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-700"></div>
                </label>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Contact CTA Section</h3>
        <div class="space-y-4">
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                <span class="text-sm font-medium text-gray-700">Enable Contact CTA Section</span>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="contact_cta_section_enabled" value="1" {{ $settings->contact_cta_section_enabled ? 'checked' : '' }} class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-700"></div>
                </label>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Heading</label>
                <input type="text" name="contact_cta_heading" value="{{ old('contact_cta_heading', $settings->contact_cta_heading) }}"
                    class="admin-input" placeholder="e.g., Ready to work together?">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea name="contact_cta_description" rows="3"
                    class="admin-textarea" placeholder="Brief description...">{{ old('contact_cta_description', $settings->contact_cta_description) }}</textarea>
            </div>
        </div>
    </div>

    <div class="flex justify-end pt-4">
        <button type="submit"
            class="bg-emerald-700 hover:bg-emerald-800 text-white px-6 py-3 rounded-lg font-medium transition-colors">
            Save Homepage Settings
        </button>
    </div>
</form>
@endsection

