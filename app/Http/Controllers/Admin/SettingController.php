<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $groups = Setting::select('group')->distinct()->get();
        $settings = Setting::orderBy('sort_order')->get();

        return view('admin.settings.index', compact('settings', 'groups'));
    }

    public function update(Request $request)
    {
        $settings = Setting::all();

        // Dynamically build validation rules for any uploaded image files
        $imageValidationRules = [];
        foreach ($settings as $setting) {
            if ($setting->type === 'image' && $request->hasFile($setting->key)) {
                $imageValidationRules[$setting->key] = ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp,svg,ico', 'max:3072'];
            }
        }

        if (! empty($imageValidationRules)) {
            $request->validate($imageValidationRules);
        }

        $presetColors = [
            'indigo_dark' => ['#6366F1', '#38BDF8'],
            'apple_light' => ['#2563EB', '#0D9488'],
            'navy_cyan' => ['#06B6D4', '#8B5CF6'],
            'titanium_amber' => ['#F59E0B', '#FB923C'],
            'emerald_dark' => ['#10B981', '#14B8A6'],
        ];

        $submittedPreset = $request->input('theme_preset');

        foreach ($settings as $setting) {
            $key = $setting->key;

            if ($setting->type === 'boolean') {
                $newVal = $request->has($key) ? '1' : '0';
                if ($setting->value !== $newVal) {
                    $setting->update(['value' => $newVal]);
                }
                continue;
            }

            if ($setting->type === 'image') {
                if ($request->hasFile($key)) {
                    if ($setting->value) {
                        Storage::disk('public')->delete($setting->value);
                    }
                    $setting->update(['value' => $request->file($key)->store('settings', 'public')]);
                }
                continue;
            }

            // Keep primary & secondary in sync with chosen theme preset
            if ($submittedPreset && isset($presetColors[$submittedPreset])) {
                if ($key === 'primary_color') {
                    $target = $presetColors[$submittedPreset][0];
                    if ($setting->value !== $target) {
                        $setting->update(['value' => $target]);
                    }
                    continue;
                }
                if ($key === 'secondary_color') {
                    $target = $presetColors[$submittedPreset][1];
                    if ($setting->value !== $target) {
                        $setting->update(['value' => $target]);
                    }
                    continue;
                }
            }

            if ($request->has($key)) {
                $value = $request->input($key);

                if ($setting->type === 'password' && empty($value)) {
                    continue;
                }

                if ($setting->value !== $value) {
                    $setting->update(['value' => $value]);
                }
            }
        }

        Cache::forget('profile');
        Cache::forget('homepage_settings');
        Cache::forget('public_settings_cache');

        return back()->with('success', 'Settings updated successfully.');
    }
}
