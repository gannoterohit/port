<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SeoController extends Controller
{
    public function edit()
    {
        $seoSettings = Setting::where('group', 'seo')->get()->keyBy('key');
        $generalSettings = Setting::where('group', 'general')->get()->keyBy('key');

        return view('admin.seo.edit', compact('seoSettings', 'generalSettings'));
    }

    public function update(Request $request)
    {
        $seoKeys = ['default_seo_title', 'default_seo_description', 'default_og_image', 'sitemap_enabled'];

        foreach ($seoKeys as $key) {
            $setting = Setting::where('key', $key)->first();
            if (! $setting) {
                continue;
            }

            if ($setting->type === 'boolean') {
                $setting->update(['value' => $request->has($key) ? '1' : '0']);
            } elseif ($setting->type === 'image') {
                if ($request->hasFile($key)) {
                    if ($setting->value) {
                        Storage::disk('public')->delete($setting->value);
                    }
                    $setting->update(['value' => $request->file($key)->store('settings/seo', 'public')]);
                }
            } elseif ($request->has($key)) {
                $setting->update(['value' => $request->input($key)]);
            }
        }

        return back()->with('success', 'SEO settings updated successfully.');
    }
}
