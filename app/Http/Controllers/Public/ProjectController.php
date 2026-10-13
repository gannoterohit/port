<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Project::where('status', 'published')
            ->where('published_at', '<=', now());

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%'.$search.'%')
                    ->orWhere('description', 'like', '%'.$search.'%')
                    ->orWhere('category', 'like', '%'.$search.'%');
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $projects = $query->orderBy('display_order')->paginate(9)->withQueryString();

        $categories = Project::where('status', 'published')
            ->where('published_at', '<=', now())
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        return view('public.projects.index', compact('projects', 'categories'));
    }

    public function show($slug)
    {
        $project = cache()->remember('project_'.$slug, 3600, function () use ($slug) {
            return Project::where('slug', $slug)
                ->where('status', 'published')
                ->where('published_at', '<=', now())
                ->with('screenshots')
                ->first();
        });

        if (! $project) {
            abort(404);
        }

        return view('public.projects.show', compact('project'));
    }
}
