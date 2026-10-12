@extends('admin.layouts.master')

@section('title', 'Profile & About')
@section('header', 'Profile & About')

@section('admin-content')
<form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data" class="space-y-6">
    @csrf
    @method('PUT')

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Basic Information</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Name *</label>
                <input type="text" name="name" value="{{ old('name', $profile->name) }}" required
                    class="admin-input">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Professional Title *</label>
                <input type="text" name="title" value="{{ old('title', $profile->title) }}" required
                    class="admin-input">
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Subtitle</label>
                <input type="text" name="subtitle" value="{{ old('subtitle', $profile->subtitle) }}"
                    class="admin-input" placeholder="e.g., Full Stack Developer | 2.5+ Years Experience">
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Introduction</label>
                <textarea name="intro" rows="3"
                    class="admin-textarea" placeholder="Short introduction for homepage">{{ old('intro', $profile->intro) }}</textarea>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Profile Photo</h3>
        <div class="flex items-center gap-6">
            @if($profile->profile_photo)
                <img src="{{ $profile->profile_photo_url }}" alt="Profile Photo" class="w-20 h-20 rounded-lg object-cover border border-gray-200">
            @else
                <div class="w-20 h-20 bg-gray-100 rounded-lg flex items-center justify-center text-gray-400 text-xs">No Photo</div>
            @endif
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-1">Upload New Photo</label>
                <input type="file" name="profile_photo" accept="image/*" class="admin-input">
                @error('profile_photo')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Biography & Experience</h3>
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Biography</label>
                <textarea name="biography" id="biography" rows="6"
                    class="admin-textarea" placeholder="Full biography text...">{{ old('biography', $profile->biography) }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Experience Text *</label>
                <input type="text" name="experience_text" value="{{ old('experience_text', $profile->experience_text) }}" required
                    class="admin-input" placeholder="e.g., 2.5 years professional experience + 6 months training">
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Resume / CV</h3>
        <div class="space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center gap-6">
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Upload Resume PDF</label>
                    <input type="file" name="resume_pdf" accept="application/pdf" class="admin-input">
                    @error('resume_pdf')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    @if($profile->resume_pdf)
                        <div class="mt-2">
                            <a href="{{ $profile->resume_url }}" target="_blank"
                                class="inline-flex items-center gap-1.5 text-blue-600 hover:text-blue-700 text-sm font-medium">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                View Current Resume PDF
                            </a>
                        </div>
                    @endif
                </div>

                <div class="pt-2">
                    <label class="flex items-center gap-2 text-sm text-gray-700 font-medium">
                        <input type="checkbox" name="resume_button_visible" value="1" {{ $profile->resume_button_visible ? 'checked' : '' }} class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                        Show Download Resume button publicly
                    </label>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Contact Details</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="contact_email" value="{{ old('contact_email', $profile->contact_email) }}"
                    class="admin-input">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                <input type="text" name="contact_phone" value="{{ old('contact_phone', $profile->contact_phone) }}"
                    class="admin-input">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">WhatsApp</label>
                <input type="text" name="contact_whatsapp" value="{{ old('contact_whatsapp', $profile->contact_whatsapp) }}"
                    class="admin-input">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                <input type="text" name="location" value="{{ old('location', $profile->location) }}"
                    class="admin-input" placeholder="e.g., Mumbai, India">
            </div>
            <div class="md:col-span-2 flex items-center gap-4">
                <label class="flex items-center gap-2 text-sm text-gray-700">
                    <input type="checkbox" name="location_visible" value="1" {{ $profile->location_visible ? 'checked' : '' }}>
                    Show location on public website
                </label>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Social Media Profiles</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @php
                $socialLinks = $profile->social_links ?? [];
                $socialPlatforms = [
                    ['key' => 'facebook', 'label' => 'Facebook', 'placeholder' => 'https://facebook.com/'],
                    ['key' => 'twitter', 'label' => 'Twitter/X', 'placeholder' => 'https://twitter.com/'],
                    ['key' => 'linkedin', 'label' => 'LinkedIn', 'placeholder' => 'https://linkedin.com/in/'],
                    ['key' => 'github', 'label' => 'GitHub', 'placeholder' => 'https://github.com/'],
                    ['key' => 'youtube', 'label' => 'YouTube', 'placeholder' => 'https://youtube.com/@'],
                    ['key' => 'instagram', 'label' => 'Instagram', 'placeholder' => 'https://instagram.com/'],
                ];
            @endphp

            @foreach($socialPlatforms as $platform)
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ $platform['label'] }}</label>
                    <input type="url" name="social_links[{{ $platform['key'] }}]"
                        value="{{ old('social_links.' . $platform['key'], $socialLinks[$platform['key']] ?? '') }}"
                        class="admin-input" placeholder="{{ $platform['placeholder'] }}">
                </div>
            @endforeach
        </div>
    </div>

    <div class="flex justify-end pt-4">
        <button type="submit"
            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors">
            Save Changes
        </button>
    </div>
</form>

<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/7/tinymce.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof tinymce !== 'undefined') {
            tinymce.init({
                selector: '#biography',
                height: 300,
                menubar: false,
                plugins: 'lists link',
                toolbar: 'undo redo | bold italic underline | bullist numlist | link',
                branding: false,
            });
        }
    });
</script>
@endsection
