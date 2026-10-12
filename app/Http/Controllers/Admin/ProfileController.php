<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Traits\HandlesFileUploads;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    use HandlesFileUploads;

    public function edit()
    {
        $profile = Profile::getInstance();
        return view('admin.profile.edit', compact('profile'));
    }

    public function update(Request $request)
    {
        $profile = Profile::getInstance();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'intro' => ['nullable', 'string'],
            'biography' => ['nullable', 'string'],
            'experience_text' => ['required', 'string'],
            'location' => ['nullable', 'string', 'max:255'],
            'location_visible' => ['boolean'],
            'contact_email' => ['nullable', 'email', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:50'],
            'contact_whatsapp' => ['nullable', 'string', 'max:50'],
            'social_links' => ['nullable', 'array'],
        ]);

        $data['location_visible'] = $request->boolean('location_visible');
        $data['resume_button_visible'] = $request->boolean('resume_button_visible');

        $profile->update($data);

        $this->clearCache();

        return redirect()->route('admin.profile.edit')->with('success', 'Profile updated successfully.');
    }

    public function updatePhoto(Request $request)
    {
        $request->validate([
            'profile_photo' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
        ]);

        $profile = Profile::getInstance();

        if ($request->hasFile('profile_photo')) {
            $path = $this->uploadFile($request->file('profile_photo'), 'profile', $profile->profile_photo);
            $profile->update(['profile_photo' => $path]);
        }

        $this->clearCache();

        return back()->with('success', 'Profile photo updated successfully.');
    }

    public function updateResume(Request $request)
    {
        $request->validate([
            'resume_pdf' => ['required', 'file', 'mimes:pdf', 'max:5120'],
        ]);

        $profile = Profile::getInstance();

        if ($request->hasFile('resume_pdf')) {
            $path = $this->uploadFile($request->file('resume_pdf'), 'profile/resume', $profile->resume_pdf);
            $profile->update(['resume_pdf' => $path]);
        }

        $this->clearCache();

        return back()->with('success', 'Resume updated successfully.');
    }

    protected function clearCache(): void
    {
        \Illuminate\Support\Facades\Cache::forget('profile');
        \Illuminate\Support\Facades\Cache::forget('homepage_settings');
    }
}
