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
