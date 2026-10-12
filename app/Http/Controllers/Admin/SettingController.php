<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
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

            if (!$request->has($key)) {
                continue;
            }

            $value = $request->input($key);

            if ($setting->type === 'image') {
                if ($request->hasFile($key)) {
                    $oldFile = $setting->value;
                    if ($oldFile) {
                        Storage::disk('public')->delete($oldFile);
                    }
                    $value = $request->file($key)->store('settings', 'public');
                } else {
                    $value = $setting->value;
                }
            } elseif ($setting->type === 'boolean') {
                $value = $request->boolean($key) ? '1' : '0';
            } elseif ($setting->type === 'password') {
                if (empty($value)) {
                    $value = $setting->value;
                }
            }

            $setting->update(['value' => $value]);
        }

        return back()->with('success', 'Settings updated successfully.');
    }
}
