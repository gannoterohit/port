<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function index(Request $request)
    {
        $query = Page::query();

        if ($request->filled('status')) {
            if ($request->status !== 'all') {
                $query->where('status', $request->status);
            }
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('slug', 'like', '%' . $request->search . '%')
                    ->orWhere('content', 'like', '%' . $request->search . '%');
            });
        }

        $pages = $query->orderBy('display_order')->paginate(15)->withQueryString();

        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.pages.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:pages,slug'],
            'content' => ['nullable', 'string'],
            'status' => ['required', 'in:draft,published'],
            'show_in_nav' => ['boolean'],
            'display_order' => ['nullable', 'integer', 'min:0'],
            'seo_title' => ['nullable', 'string', 'max:255'],
            'seo_description' => ['nullable', 'string', 'max:500'],
            'og_title' => ['nullable', 'string', 'max:255'],
            'og_description' => ['nullable', 'string', 'max:500'],
            'og_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'],
            'canonical_url' => ['nullable', 'url', 'max:255'],
            'no_index' => ['boolean'],
        ]);

        $data['slug'] = $data['slug'] ?? Str::slug($data['title']);
        $data['display_order'] = $data['display_order'] ?? Page::max('display_order') + 1;
        $data['show_in_nav'] = $request->boolean('show_in_nav');
        $data['no_index'] = $request->boolean('no_index');

        if ($request->hasFile('og_image')) {
            $data['og_image'] = $request->file('og_image')->store('pages/seo', 'public');
        }

        Page::create($data);

        return redirect()->route('admin.pages.index')->with('success', 'Page created successfully.');
    }

    public function edit(Page $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:pages,slug,' . $page->id],
            'content' => ['nullable', 'string'],
            'status' => ['required', 'in:draft,published'],
            'show_in_nav' => ['boolean'],
            'display_order' => ['nullable', 'integer', 'min:0'],
            'seo_title' => ['nullable', 'string', 'max:255'],
            'seo_description' => ['nullable', 'string', 'max:500'],
            'og_title' => ['nullable', 'string', 'max:255'],
            'og_description' => ['nullable', 'string', 'max:500'],
            'og_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'],
            'canonical_url' => ['nullable', 'url', 'max:255'],
            'no_index' => ['boolean'],
        ]);

        $data['show_in_nav'] = $request->boolean('show_in_nav');
        $data['no_index'] = $request->boolean('no_index');

        if ($request->hasFile('og_image')) {
            $data['og_image'] = $request->file('og_image')->store('pages/seo', 'public');
        }

        $page->update($data);

        return redirect()->route('admin.pages.index')->with('success', 'Page updated successfully.');
    }

    public function destroy(Page $page)
    {
        $page->delete();
        return back()->with('success', 'Page deleted successfully.');
    }
}
