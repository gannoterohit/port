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

        foreach ($settings as $setting) {
            $key = $setting->key;

            if ($setting->type === 'boolean') {
                $setting->update(['value' => $request->has($key) ? '1' : '0']);

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

                $setting->update(['value' => $value]);
            }
        }

        Cache::forget('profile');
        Cache::forget('homepage_settings');

        return back()->with('success', 'Settings updated successfully.');
    }
}
