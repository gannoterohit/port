<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomepageSetting;
use App\Traits\HandlesFileUploads;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomepageController extends Controller
{
    use HandlesFileUploads;

    public function edit()
    {
        $settings = HomepageSetting::firstOrCreate([]);

        return view('admin.homepage.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $settings = HomepageSetting::firstOrCreate([]);

        $data = $request->validate([
            'hero_heading' => ['nullable', 'string', 'max:255'],
            'hero_title' => ['nullable', 'string', 'max:255'],
            'hero_description' => ['nullable', 'string'],
            'primary_cta_text' => ['nullable', 'string', 'max:100'],
            'primary_cta_url' => ['nullable', 'string', 'max:255'],
            'secondary_cta_text' => ['nullable', 'string', 'max:100'],
            'secondary_cta_url' => ['nullable', 'string', 'max:255'],
            'contact_cta_heading' => ['nullable', 'string', 'max:255'],
            'contact_cta_description' => ['nullable', 'string'],
            'section_order' => ['nullable', 'array'],
        ]);

        $data['hero_section_enabled'] = $request->boolean('hero_section_enabled');
        $data['about_section_enabled'] = $request->boolean('about_section_enabled');
        $data['skills_section_enabled'] = $request->boolean('skills_section_enabled');
        $data['projects_section_enabled'] = $request->boolean('projects_section_enabled');
        $data['services_section_enabled'] = $request->boolean('services_section_enabled');
        $data['work_process_section_enabled'] = $request->boolean('work_process_section_enabled');
        $data['testimonials_section_enabled'] = $request->boolean('testimonials_section_enabled');
        $data['contact_cta_section_enabled'] = $request->boolean('contact_cta_section_enabled');

        if ($request->hasFile('hero_image')) {
            $data['hero_image'] = $this->uploadFile($request->file('hero_image'), 'homepage', $settings->hero_image);
        }

        if ($request->filled('section_order_text')) {
            $lines = preg_split("/\r\n|\n|\r/", (string) $request->input('section_order_text'));
            $data['section_order'] = array_values(array_filter(array_map('trim', $lines ?: [])));
        }

        $settings->update($data);

        Cache::forget('homepage_settings');

        return back()->with('success', 'Homepage settings updated successfully.');
    }
}
