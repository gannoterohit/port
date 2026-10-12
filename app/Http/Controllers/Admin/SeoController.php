<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

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
            if ($request->has($key)) {
                $setting = Setting::where('key', $key)->first();

                if ($setting) {
                    $value = $request->input($key);

                    if ($setting->type === 'image' && $request->hasFile($key)) {
                        $oldFile = $setting->value;
                        if ($oldFile) {
                            \Illuminate\Support\Facades\Storage::disk('public')->delete($oldFile);
                        }
                        $value = $request->file($key)->store('settings/seo', 'public');
                    } elseif ($setting->type === 'boolean') {
                        $value = $request->boolean($key) ? '1' : '0';
                    }

                    $setting->update(['value' => $value]);
                }
            }
        }

        return back()->with('success', 'SEO settings updated successfully.');
    }
}
