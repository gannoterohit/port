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
                    @if(!$setting->is_active)
                        @continue
                    @endif
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ $setting->label }}</label>
                        @if($setting->description)
                            <p class="text-xs text-gray-500 mb-1">{{ $setting->description }}</p>
                        @endif

                        @if($setting->type === 'theme_preset')
                            @php
                                $selectedTheme = old($setting->key, $setting->value ?? 'indigo_dark');
                                $presets = [
                                    [
                                        'id' => 'indigo_dark',
                                        'name' => 'Royal Indigo & Slate',
                                        'tag' => 'Silicon Valley SaaS',
                                        'recommended' => true,
                                        'bg' => '#0B0F19',
                                        'card' => '#1E293B',
                                        'primary' => '#6366F1',
                                        'accent' => '#38BDF8',
                                        'text' => '#F8FAFC',
                                        'desc' => 'High-end Linear & modern tech aesthetic. Slate charcoal backdrop with vivid Indigo brand and Sky accents.'
                                    ],
                                    [
                                        'id' => 'apple_light',
                                        'name' => 'Apple Clean Light',
                                        'tag' => 'Corporate Light Mode',
                                        'recommended' => false,
                                        'bg' => '#F8FAFC',
                                        'card' => '#FFFFFF',
                                        'primary' => '#2563EB',
                                        'accent' => '#0D9488',
                                        'text' => '#0F172A',
                                        'desc' => 'Clean, professional light mode. Pure bright canvas with deep Royal Blue accents and high-contrast typography.'
                                    ],
                                    [
                                        'id' => 'navy_cyan',
                                        'name' => 'Deep Navy & Electric Cyan',
                                        'tag' => 'Cloud & Cyber Architecture',
                                        'recommended' => false,
                                        'bg' => '#0A1128',
                                        'card' => '#111E38',
                                        'primary' => '#06B6D4',
                                        'accent' => '#8B5CF6',
                                        'text' => '#F1F5F9',
                                        'desc' => 'Midnight navy blue with electric cyber cyan and violet glow. Cloud engineering & AI look.'
                                    ],
                                    [
                                        'id' => 'titanium_amber',
                                        'name' => 'Titanium & Warm Amber',
                                        'tag' => 'Executive Design Agency',
                                        'recommended' => false,
                                        'bg' => '#12141A',
                                        'card' => '#1E222B',
                                        'primary' => '#F59E0B',
                                        'accent' => '#FB923C',
                                        'text' => '#F3F4F6',
                                        'desc' => 'Ultra-sleek titanium dark mode with warm amber & gold highlights. Premium creative studio feel.'
                                    ],
                                    [
                                        'id' => 'emerald_dark',
                                        'name' => 'Obsidian Emerald',
                                        'tag' => 'Developer Terminal / Code',
                                        'recommended' => false,
                                        'bg' => '#080C14',
                                        'card' => '#0F172A',
                                        'primary' => '#10B981',
                                        'accent' => '#14B8A6',
                                        'text' => '#F8FAFC',
                                        'desc' => 'Obsidian dark backdrop with vivid emerald highlights and terminal tech aesthetic.'
                                    ],
                                ];
                            @endphp

                            <div class="mt-2" x-data="{ currentTheme: '{{ $selectedTheme }}' }">
                                <div class="flex flex-wrap items-center justify-between gap-2 mb-3">
                                    <span class="text-xs font-semibold uppercase tracking-wider text-gray-500">Click a theme card to select</span>
                                    <a href="{{ asset('palette-preview.html') }}" target="_blank" class="inline-flex items-center gap-1.5 text-xs font-semibold text-emerald-700 hover:text-emerald-800 bg-emerald-50 px-2.5 py-1 rounded-md border border-emerald-200 transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        Compare All 5 Live Swatches &rarr;
                                    </a>
                                </div>

                                <style>
                                    .theme-preset-card:has(input[type="radio"]:checked) {
                                        border-color: #059669 !important;
                                        background-color: #ECFDF5 !important;
                                        box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.3) !important;
                                    }
                                    .theme-preset-card:has(input[type="radio"]:checked) .theme-radio-dot {
                                        border-color: #059669 !important;
                                        background-color: #059669 !important;
                                    }
                                    .theme-preset-card:has(input[type="radio"]:checked) .theme-radio-dot svg {
                                        display: block !important;
                                    }
                                </style>

                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3.5">
                                    @foreach($presets as $preset)
                                        <label class="theme-preset-card relative rounded-xl border-2 p-4 cursor-pointer transition-all duration-200 block text-left"
                                            :class="currentTheme === '{{ $preset['id'] }}'
                                                ? 'border-emerald-600 ring-2 ring-emerald-500/25 bg-emerald-50/40 shadow-sm'
                                                : 'border-gray-200 hover:border-gray-300 hover:bg-gray-50/80 bg-white'">
                                            
                                            <input type="radio" name="{{ $setting->key }}" value="{{ $preset['id'] }}"
                                                class="sr-only"
                                                x-model="currentTheme"
                                                {{ $selectedTheme === $preset['id'] ? 'checked' : '' }}>

                                            <div class="flex items-start justify-between gap-2 mb-2.5">
                                                <div>
                                                    <div class="flex items-center gap-1.5 flex-wrap">
                                                        <span class="font-bold text-gray-900 text-sm leading-tight">{{ $preset['name'] }}</span>
                                                        @if(!empty($preset['recommended']))
                                                            <span class="px-2 py-0.5 text-[9px] font-extrabold rounded bg-indigo-100 text-indigo-700 uppercase tracking-wider">Top Pick</span>
                                                        @endif
                                                    </div>
                                                    <span class="text-xs text-gray-500 font-medium block mt-0.5">{{ $preset['tag'] }}</span>
                                                </div>

                                                <div class="theme-radio-dot w-5 h-5 rounded-full border-2 flex items-center justify-center transition-colors flex-shrink-0"
                                                    :class="currentTheme === '{{ $preset['id'] }}' ? 'border-emerald-600 bg-emerald-600' : 'border-gray-300 bg-white'">
                                                    <svg x-show="currentTheme === '{{ $preset['id'] }}'" class="w-3 h-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                </div>
                                            </div>

                                            <!-- Visual Swatch Bar -->
                                            <div class="rounded-lg p-2.5 mb-2.5 border border-gray-200/80 flex items-center gap-2" style="background: {{ $preset['bg'] }};">
                                                <div class="w-6 h-6 rounded-md shadow-xs border border-white/20 flex-shrink-0" style="background: {{ $preset['card'] }};" title="Card BG"></div>
                                                <div class="w-6 h-6 rounded-md shadow-xs border border-white/20 flex-shrink-0" style="background: {{ $preset['primary'] }};" title="Brand Accent"></div>
                                                <div class="w-6 h-6 rounded-md shadow-xs border border-white/20 flex-shrink-0" style="background: {{ $preset['accent'] }};" title="Highlight Accent"></div>
                                                <div class="ml-auto text-[11px] font-mono px-2 py-0.5 rounded font-bold" style="color: {{ $preset['text'] }}; background: rgba(255,255,255,0.12);">
                                                    Aa Text
                                                </div>
                                            </div>

                                            <p class="text-xs text-gray-600 leading-relaxed">{{ $preset['desc'] }}</p>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @elseif($setting->type === 'image')
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
