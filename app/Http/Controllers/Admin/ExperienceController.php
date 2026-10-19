<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Experience;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ExperienceController extends Controller
{
    public function index()
    {
        $experiences = Experience::orderBy('display_order')->get();

        return view('admin.experiences.index', compact('experiences'));
    }

    public function create()
    {
        return view('admin.experiences.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'role' => ['required', 'string', 'max:255'],
            'company' => ['nullable', 'string', 'max:255'],
            'period' => ['required', 'string', 'max:255'],
            'badge_text' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'technologies' => ['nullable', 'string'],
            'is_enabled' => ['boolean'],
        ]);

        $data['display_order'] = Experience::max('display_order') + 1;
        $data['is_enabled'] = $request->boolean('is_enabled', true);

        if (!empty($data['technologies'])) {
            $data['technologies'] = array_values(array_filter(array_map('trim', explode(',', $data['technologies']))));
        } else {
            $data['technologies'] = [];
        }

        Experience::create($data);

        Cache::forget('homepage_experiences');

        return redirect()->route('admin.experiences.index')->with('success', 'Experience created successfully.');
    }

    public function edit(Experience $experience)
    {
        return view('admin.experiences.edit', compact('experience'));
    }

    public function update(Request $request, Experience $experience)
    {
        $data = $request->validate([
            'role' => ['required', 'string', 'max:255'],
            'company' => ['nullable', 'string', 'max:255'],
            'period' => ['required', 'string', 'max:255'],
            'badge_text' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'technologies' => ['nullable', 'string'],
            'is_enabled' => ['boolean'],
        ]);

        $data['is_enabled'] = $request->boolean('is_enabled');

        if (isset($data['technologies'])) {
            $data['technologies'] = array_values(array_filter(array_map('trim', explode(',', $data['technologies']))));
        }

        $experience->update($data);

        Cache::forget('homepage_experiences');

        return redirect()->route('admin.experiences.index')->with('success', 'Experience updated successfully.');
    }

    public function destroy(Experience $experience)
    {
        $experience->delete();

        Cache::forget('homepage_experiences');

        return redirect()->route('admin.experiences.index')->with('success', 'Experience deleted successfully.');
    }

    public function reorder(Request $request)
    {
        $order = $request->input('order', []);

        foreach ($order as $index => $id) {
            Experience::where('id', $id)->update(['display_order' => $index + 1]);
        }

        Cache::forget('homepage_experiences');

        return response()->json(['success' => true]);
    }
}
