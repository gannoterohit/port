@extends('admin.layouts.master')

@section('title', 'Settings')
@section('header', 'Website Settings')

@section('admin-content')
<form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" class="space-y-6">
    @csrf
    @method('PUT')

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif

    @php
        $groupedSettings = $settings->groupBy('group');
        $groupLabels = [
            'general' => 'General Settings',
            'theme' => 'Theme Settings',
            'social' => 'Social Media',
            'seo' => 'SEO Settings',
            'email' => 'Email Configuration',
        ];
    @endphp

    @foreach($groupedSettings as $group => $groupSettings)
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ $groupLabels[$group] ?? ucfirst($group) }}</h3>
            <div class="space-y-4">
                @foreach($groupSettings as $setting)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ $setting->label }}</label>
                        @if($setting->description)
                            <p class="text-xs text-gray-500 mb-1">{{ $setting->description }}</p>
                        @endif

                        @if($setting->type === 'image')
                            <div class="flex items-center gap-4">
                                @if($setting->value)
                                    <img src="{{ asset('storage/' . $setting->value) }}" alt="{{ $setting->label }}" class="w-16 h-16 object-cover rounded-lg">
                                @endif
                                <input type="file" name="{{ $setting->key }}" accept="image/*" class="admin-input">
                            </div>
                        @elseif($setting->type === 'boolean')
                            <label class="flex items-center gap-2">
                                <input type="checkbox" name="{{ $setting->key }}" value="1" {{ $setting->value == '1' ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700">Enable</span>
                            </label>
                        @elseif($setting->type === 'password')
                            <input type="password" name="{{ $setting->key }}" value="" class="admin-input"
                                placeholder="{{ $setting->value ? '••••••' : 'Enter new password' }}">
                        @elseif($setting->type === 'textarea')
                            <textarea name="{{ $setting->key }}" rows="3" class="admin-textarea"
                                placeholder="Enter value...">{{ old($setting->key, $setting->value) }}</textarea>
                        @elseif($setting->type === 'number')
                            <input type="number" name="{{ $setting->key }}" value="{{ old($setting->key, $setting->value) }}"
                                class="admin-input">
                        @elseif($setting->type === 'color')
                            <div class="flex items-center gap-3">
                                <input type="color" id="picker_{{ $setting->key }}" value="{{ old($setting->key, $setting->value ?? '#2563eb') }}"
                                    class="h-10 w-16 p-1 rounded-lg border border-gray-300 cursor-pointer bg-white"
                                    oninput="document.getElementById('text_{{ $setting->key }}').value = this.value">
                                <input type="text" id="text_{{ $setting->key }}" name="{{ $setting->key }}"
                                    value="{{ old($setting->key, $setting->value ?? '#2563eb') }}"
                                    class="admin-input font-mono w-36 uppercase"
                                    placeholder="#2563EB"
                                    oninput="if(/^#[0-9A-Fa-f]{6}$/.test(this.value)) document.getElementById('picker_{{ $setting->key }}').value = this.value">
                                <span class="text-xs text-gray-500">Pick color or type HEX code</span>
                            </div>
                        @else
                            <input type="{{ $setting->type === 'url' ? 'url' : ($setting->type === 'email' ? 'email' : 'text') }}"
                                name="{{ $setting->key }}" value="{{ old($setting->key, $setting->value) }}"
                                class="admin-input"
                                placeholder="Enter value...">
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach

    <div class="flex justify-end">
        <button type="submit"
            class="bg-emerald-700 hover:bg-emerald-800 text-white px-6 py-3 rounded-lg font-medium transition-colors">
            Save All Settings
        </button>
    </div>
</form>
@endsection

