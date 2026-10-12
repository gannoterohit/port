<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use App\Models\SkillCategory;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    public function index(Request $request)
    {
        $query = Skill::with('category');

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('status')) {
            $query->where('is_enabled', $request->status === 'enabled');
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhereHas('category', function ($q) use ($request) {
                        $q->where('name', 'like', '%' . $request->search . '%');
                    });
            });
        }

        $skills = $query->orderBy('display_order')->paginate(15)->withQueryString();

        return view('admin.skills.index', compact('skills'));
    }

    public function create()
    {
        $categories = SkillCategory::where('is_enabled', true)->get();
        return view('admin.skills.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category_id' => ['nullable', 'exists:skill_categories,id'],
            'description' => ['nullable', 'string'],
            'proficiency' => ['nullable', 'integer', 'min:1', 'max:5'],
            'is_enabled' => ['boolean'],
            'is_featured' => ['boolean'],
        ]);

        $data['slug'] = \Illuminate\Support\Str::slug($data['name']);
        $data['display_order'] = Skill::max('display_order') + 1;
        $data['is_enabled'] = $request->boolean('is_enabled', true);
        $data['is_featured'] = $request->boolean('is_featured', false);

        Skill::create($data);
        \Illuminate\Support\Facades\Cache::forget('homepage_skills');

        return redirect()->route('admin.skills.index')->with('success', 'Skill created successfully.');
    }

    public function edit(Skill $skill)
    {
        $categories = SkillCategory::where('is_enabled', true)->get();
        return view('admin.skills.edit', compact('skill', 'categories'));
    }

    public function update(Request $request, Skill $skill)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category_id' => ['nullable', 'exists:skill_categories,id'],
            'description' => ['nullable', 'string'],
            'proficiency' => ['nullable', 'integer', 'min:1', 'max:100'],
            'is_enabled' => ['boolean'],
            'is_featured' => ['boolean'],
        ]);

        $data['is_enabled'] = $request->boolean('is_enabled');
        $data['is_featured'] = $request->boolean('is_featured');

        $skill->update($data);
        \Illuminate\Support\Facades\Cache::forget('homepage_skills');

        return redirect()->route('admin.skills.index')->with('success', 'Skill updated successfully.');
    }

    public function destroy(Skill $skill)
    {
        $skill->delete();
        \Illuminate\Support\Facades\Cache::forget('homepage_skills');
        return back()->with('success', 'Skill deleted successfully.');
    }
}
