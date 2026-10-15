<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Project;
use App\Models\Service;
use App\Models\Setting;

class SitemapController extends Controller
{
    public function __invoke()
    {
        if (Setting::get('sitemap_enabled', '1') !== '1') {
            abort(404);
        }

        $xml = cache()->remember('sitemap_xml_content', 86400, function () {
            $latestContentDate = \App\Models\Project::max('updated_at')
                ?: (\App\Models\Profile::value('updated_at') ?: now());
            $latestIso = \Carbon\Carbon::parse($latestContentDate)->toAtomString();

            $urls = [];

            $urls[] = [
                'loc' => route('home'),
                'lastmod' => $latestIso,
                'changefreq' => 'weekly',
                'priority' => 1.0,
            ];

            if (Page::where('slug', 'about')->where('status', 'published')->exists()) {
                $urls[] = [
                    'loc' => route('about'),
                    'lastmod' => $latestIso,
                    'changefreq' => 'monthly',
                    'priority' => 0.8,
                ];
            }

            $urls[] = [
                'loc' => route('skills'),
                'lastmod' => $latestIso,
                'changefreq' => 'monthly',
                'priority' => 0.8,
            ];

            $urls[] = [
                'loc' => route('projects'),
                'lastmod' => $latestIso,
                'changefreq' => 'weekly',
                'priority' => 0.9,
            ];

            $urls[] = [
                'loc' => route('services'),
                'lastmod' => $latestIso,
                'changefreq' => 'monthly',
                'priority' => 0.8,
            ];

            $urls[] = [
                'loc' => route('resume'),
                'lastmod' => $latestIso,
                'changefreq' => 'monthly',
                'priority' => 0.7,
            ];

            $urls[] = [
                'loc' => route('contact'),
                'lastmod' => $latestIso,
                'changefreq' => 'monthly',
                'priority' => 0.8,
            ];

            $urls[] = [
                'loc' => route('privacy'),
                'lastmod' => $latestIso,
                'changefreq' => 'yearly',
                'priority' => 0.3,
            ];

            $urls[] = [
                'loc' => route('terms'),
                'lastmod' => $latestIso,
                'changefreq' => 'yearly',
                'priority' => 0.3,
            ];

            $pages = Page::published()
                ->where('no_index', false)
                ->whereNotIn('slug', ['about', 'privacy-policy', 'terms'])
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
                    'priority' => 0.7,
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
                    'priority' => 0.7,
                ];
            });

            $content = '<?xml version="1.0" encoding="UTF-8"?>';
            $content .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

            foreach ($urls as $url) {
                $content .= '<url>';
                $content .= '<loc>'.htmlspecialchars($url['loc'], ENT_XML1).'</loc>';
                $content .= '<lastmod>'.htmlspecialchars($url['lastmod'], ENT_XML1).'</lastmod>';
                $content .= '<changefreq>'.$url['changefreq'].'</changefreq>';
                $content .= '<priority>'.$url['priority'].'</priority>';
                $content .= '</url>';
            }

            $content .= '</urlset>';

            return $content;
        });

        return response($xml, 200, ['Content-Type' => 'application/xml']);
    }
}
