<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SkillCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class SkillCategoryController extends Controller
{
    public function index()
    {
        $categories = SkillCategory::orderBy('display_order')->get();

        return view('admin.skill-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.skill-categories.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'color' => ['nullable', 'string', 'max:50'],
            'description' => ['nullable', 'string', 'max:2000'],
            'display_order' => ['nullable', 'integer', 'min:0'],
            'is_enabled' => ['boolean'],
        ]);

        $data['slug'] = Str::slug($data['name']);
        $data['display_order'] = $data['display_order'] ?? SkillCategory::max('display_order') + 1;
        $data['is_enabled'] = $request->boolean('is_enabled', true);

        SkillCategory::create($data);
        Cache::forget('homepage_skill_categories');

        return redirect()->route('admin.skill-categories.index')->with('success', 'Category created successfully.');
    }

    public function edit(SkillCategory $skillCategory)
    {
        return view('admin.skill-categories.edit', compact('skillCategory'));
    }

    public function update(Request $request, SkillCategory $skillCategory)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'color' => ['nullable', 'string', 'max:50'],
            'description' => ['nullable', 'string', 'max:2000'],
            'display_order' => ['nullable', 'integer', 'min:0'],
            'is_enabled' => ['boolean'],
        ]);

        $data['is_enabled'] = $request->boolean('is_enabled');

        $skillCategory->update($data);
        Cache::forget('homepage_skills');
        Cache::forget('homepage_skill_categories');
        Cache::forget('about_featured_skills');

        return redirect()->route('admin.skill-categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(SkillCategory $skillCategory)
    {
        $skillCategory->delete();
        Cache::forget('homepage_skills');
        Cache::forget('about_featured_skills');

        return back()->with('success', 'Category deleted successfully.');
    }
}
