<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Project;
use App\Models\Service;

class SitemapController extends Controller
{
    public function __invoke()
    {
        $urls = [];

        $urls[] = [
            'loc' => route('home'),
            'lastmod' => now()->toAtomString(),
            'changefreq' => 'daily',
            'priority' => 1.0,
        ];

        if (Page::where('slug', 'about')->where('status', 'published')->exists()) {
            $urls[] = [
                'loc' => route('about'),
                'lastmod' => now()->toAtomString(),
                'changefreq' => 'monthly',
                'priority' => 0.8,
            ];
        }

        $urls[] = [
            'loc' => route('skills'),
            'lastmod' => now()->toAtomString(),
            'changefreq' => 'monthly',
            'priority' => 0.7,
        ];

        $urls[] = [
            'loc' => route('projects'),
            'lastmod' => now()->toAtomString(),
            'changefreq' => 'monthly',
            'priority' => 0.7,
        ];

        $urls[] = [
            'loc' => route('services'),
            'lastmod' => now()->toAtomString(),
            'changefreq' => 'monthly',
            'priority' => 0.7,
        ];

        $urls[] = [
            'loc' => route('contact'),
            'lastmod' => now()->toAtomString(),
            'changefreq' => 'monthly',
            'priority' => 0.7,
        ];

        $pages = Page::published()
            ->where('no_index', false)
            ->whereNotIn('slug', ['about', 'privacy-policy'])
            ->get();

        $pages->each(function ($page) use (&$urls) {
            $urls[] = [
                'loc' => route('page', $page->slug),
                'lastmod' => $page->updated_at->toAtomString(),
                'changefreq' => 'monthly',
                'priority' => 0.6,
            ];
        });

        $projects = Project::where('status', 'published')
            ->where('published_at', '<=', now())
            ->where('no_index', false)
            ->get();

        $projects->each(function ($project) use (&$urls) {
            $urls[] = [
                'loc' => route('projects.show', $project->slug),
                'lastmod' => $project->updated_at->toAtomString(),
                'changefreq' => 'monthly',
                'priority' => 0.6,
            ];
        });

        $services = Service::where('is_enabled', true)
            ->where('no_index', false)
            ->get();

        $services->each(function ($service) use (&$urls) {
            $urls[] = [
                'loc' => route('services.show', $service->slug),
                'lastmod' => $service->updated_at->toAtomString(),
                'changefreq' => 'monthly',
                'priority' => 0.6,
            ];
        });

        $content = '<?xml version="1.0" encoding="UTF-8"?>';
        $content .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        foreach ($urls as $url) {
            $content .= '<url>';
            $content .= '<loc>' . htmlspecialchars($url['loc'], ENT_XML1) . '</loc>';
            $content .= '<lastmod>' . htmlspecialchars($url['lastmod'], ENT_XML1) . '</lastmod>';
            $content .= '<changefreq>' . $url['changefreq'] . '</changefreq>';
            $content .= '<priority>' . $url['priority'] . '</priority>';
            $content .= '</url>';
        }

        $content .= '</urlset>';

        return response($content, 200, ['Content-Type' => 'application/xml']);
    }
}
