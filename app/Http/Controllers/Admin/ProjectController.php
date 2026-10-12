<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Traits\HandlesFileUploads;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    use HandlesFileUploads;

    public function index(Request $request)
    {
        $query = Project::query();

        if ($request->filled('status_filter')) {
            if ($request->status_filter !== 'all') {
                $query->where('status', $request->status_filter);
            }
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('category', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        $projects = $query->orderBy('display_order')->paginate(15)->withQueryString();

        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        return view('admin.projects.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:projects,slug'],
            'description' => ['nullable', 'string'],
            'category' => ['nullable', 'string', 'max:100'],
            'thumbnail' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'],
            'thumbnail_alt' => ['nullable', 'string', 'max:255'],
            'tech_stack' => ['nullable', 'array'],
            'purpose' => ['nullable', 'string'],
            'key_features' => ['nullable', 'string'],
            'role' => ['nullable', 'string'],
            'challenges' => ['nullable', 'string'],
            'solutions' => ['nullable', 'string'],
            'demo_url' => ['nullable', 'url', 'max:255'],
            'github_url' => ['nullable', 'url', 'max:255'],
            'is_featured' => ['boolean'],
            'status' => ['required', 'in:draft,published'],
            'display_order' => ['nullable', 'integer', 'min:0'],
            'seo_title' => ['nullable', 'string', 'max:255'],
            'seo_description' => ['nullable', 'string', 'max:500'],
            'og_title' => ['nullable', 'string', 'max:255'],
            'og_description' => ['nullable', 'string', 'max:500'],
            'og_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'],
            'canonical_url' => ['nullable', 'url', 'max:255'],
            'no_index' => ['boolean'],
        ]);

        DB::beginTransaction();

        try {
            $data['slug'] = $data['slug'] ?? Str::slug($data['title']);
            $data['display_order'] = $data['display_order'] ?? Project::max('display_order') + 1;
            $data['is_featured'] = $request->boolean('is_featured');
            $data['no_index'] = $request->boolean('no_index');
            $data['published_at'] = $data['status'] === 'published' ? now() : null;

            if ($request->hasFile('thumbnail')) {
                $data['thumbnail'] = $this->uploadFile($request->file('thumbnail'), 'projects/thumbnails');
            }

            if ($request->hasFile('og_image')) {
                $data['og_image'] = $this->uploadFile($request->file('og_image'), 'projects/seo');
            }

            $project = Project::create($data);

            if ($request->hasFile('screenshots')) {
                $order = 1;
                foreach ($request->file('screenshots') as $screenshot) {
                    if ($screenshot) {
                        $path = $screenshot->store('projects/screenshots', 'public');
                        $project->screenshots()->create([
                            'image' => $path,
                            'display_order' => $order++,
                        ]);
                    }
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        Cache::forget('homepage_featured_projects');

        return redirect()->route('admin.projects.index')->with('success', 'Project created successfully.');
    }

    public function edit(Project $project)
    {
        return view('admin.projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:projects,slug,' . $project->id],
            'description' => ['nullable', 'string'],
            'category' => ['nullable', 'string', 'max:100'],
            'thumbnail' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'],
            'thumbnail_alt' => ['nullable', 'string', 'max:255'],
            'tech_stack' => ['nullable', 'array'],
            'purpose' => ['nullable', 'string'],
            'key_features' => ['nullable', 'string'],
            'role' => ['nullable', 'string'],
            'challenges' => ['nullable', 'string'],
            'solutions' => ['nullable', 'string'],
            'demo_url' => ['nullable', 'url', 'max:255'],
            'github_url' => ['nullable', 'url', 'max:255'],
            'is_featured' => ['boolean'],
            'status' => ['required', 'in:draft,published'],
            'display_order' => ['nullable', 'integer', 'min:0'],
            'seo_title' => ['nullable', 'string', 'max:255'],
            'seo_description' => ['nullable', 'string', 'max:500'],
            'og_title' => ['nullable', 'string', 'max:255'],
            'og_description' => ['nullable', 'string', 'max:500'],
            'og_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'],
            'canonical_url' => ['nullable', 'url', 'max:255'],
            'no_index' => ['boolean'],
        ]);

        $data['is_featured'] = $request->boolean('is_featured');
        $data['no_index'] = $request->boolean('no_index');
        $data['published_at'] = $data['status'] === 'published' && !$project->published_at ? now() : $project->published_at;

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $this->uploadFile($request->file('thumbnail'), 'projects/thumbnails', $project->thumbnail);
        }

        if ($request->hasFile('og_image')) {
            $data['og_image'] = $this->uploadFile($request->file('og_image'), 'projects/seo', $project->og_image);
        }

        $project->update($data);

        if ($request->hasFile('screenshots')) {
            $order = 1;
            foreach ($request->file('screenshots') as $screenshot) {
                if ($screenshot) {
                    $path = $screenshot->store('projects/screenshots', 'public');
                    $project->screenshots()->create([
                        'image' => $path,
                        'display_order' => $order++,
                    ]);
                }
            }
        }

        Cache::forget('homepage_featured_projects');
        Cache::forget('project_' . $project->slug);

        return redirect()->route('admin.projects.index')->with('success', 'Project updated successfully.');
    }

    public function destroy(Request $request, Project $project)
    {
        $project->load('screenshots');

        foreach ($project->screenshots as $screenshot) {
            $this->deleteFile($screenshot->image);
        }

        $this->deleteFile($project->thumbnail);
        $this->deleteFile($project->og_image);

        $slug = $project->slug;
        $project->delete();

        Cache::forget('homepage_featured_projects');
        Cache::forget('project_' . $slug);

        return redirect()->route('admin.projects.index')->with('success', 'Project deleted successfully.');
    }
}
