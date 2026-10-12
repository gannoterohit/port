<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use App\Models\Page;
use App\Models\Project;
use App\Models\Service;
use App\Models\Testimonial;

class SitemapController extends Controller
{
    public function __invoke()
    {
        $projects = Project::published()->where('no_index', false)->get();
        $services = Service::where('is_enabled', true)->where('no_index', false)->get();
        $pages = Page::published()->where('no_index', false)->get();

        $urls = [];

        $urls[] = [
            'loc' => route('home'),
            'lastmod' => now()->toAtomString(),
            'changefreq' => 'daily',
            'priority' => 1.0,
        ];

        foreach ($pages as $page) {
            $urls[] = [
                'loc' => route('page', $page->slug),
                'lastmod' => $page->updated_at->toAtomString(),
                'changefreq' => 'monthly',
                'priority' => 0.8,
            ];
        }

        foreach ($projects as $project) {
            $urls[] = [
                'loc' => route('projects.show', $project->slug),
                'lastmod' => $project->updated_at->toAtomString(),
                'changefreq' => 'monthly',
                'priority' => 0.8,
            ];
        }

        foreach ($services as $service) {
            $urls[] = [
                'loc' => route('services.show', $service->slug),
                'lastmod' => $service->updated_at->toAtomString(),
                'changefreq' => 'monthly',
                'priority' => 0.7,
            ];
        }

        return view('admin.sitemap.index', compact('urls', 'projects', 'services', 'pages'));
    }
}
