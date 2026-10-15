<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Profile;
use App\Models\Skill;
use App\Models\SkillCategory;
use Illuminate\Support\Facades\Cache;

class PageController extends Controller
{
    public function about()
    {
        $profile = Cache::remember('profile', 3600, fn () => Profile::getInstance());
        $featuredSkills = Cache::remember('about_featured_skills', 3600, function () {
            $skills = Skill::where('is_enabled', true)
                ->where('is_featured', true)
                ->orderBy('display_order')
                ->limit(8)
                ->get();

            if ($skills->isEmpty()) {
                $skills = Skill::where('is_enabled', true)
                    ->orderBy('display_order')
                    ->limit(8)
                    ->get();
            }

            return $skills;
        });

        return view('public.about', compact('profile', 'featuredSkills'));
    }

    public function skills()
    {
        $categories = SkillCategory::where('is_enabled', true)
            ->with(['skills' => function ($q) {
                $q->where('is_enabled', true)->orderBy('display_order');
            }])
            ->orderBy('display_order')
            ->get();

        $query = Skill::where('is_enabled', true)->with('category');
        $catIds = $categories->pluck('id')->filter()->toArray();
        $dbDriver = config('database.connections.'.config('database.default').'.driver', config('database.default'));
        if (! empty($catIds) && in_array($dbDriver, ['mysql', 'mariadb'])) {
            $query->orderByRaw('FIELD(category_id, '.implode(',', array_map('intval', $catIds)).')');
        }
        $skills = $query->orderBy('display_order')->get();

        return view('public.skills', compact('categories', 'skills'));
    }

    public function resume()
    {
        $profile = Cache::remember('profile', 3600, fn () => Profile::getInstance());

        return view('public.resume', compact('profile'));
    }

    public function privacy()
    {
        $page = Page::where('slug', 'privacy-policy')->first();

        if (! $page) {
            $page = Page::firstOrCreate(
                ['slug' => 'privacy-policy'],
                [
                    'title' => 'Privacy Policy',
                    'content' => '<h2>Privacy Policy</h2><p>Your privacy policy content goes here. You can edit this page from the Admin Panel under Pages Management.</p>',
                    'status' => 'published',
                    'show_in_nav' => false,
                    'display_order' => 999,
                ]
            );
        }

        return view('public.privacy', compact('page'));
    }

    public function terms()
    {
        $page = Page::where('slug', 'terms')->first();

        if (! $page) {
            $page = Page::firstOrCreate(
                ['slug' => 'terms'],
                [
                    'title' => 'Terms of Service',
                    'content' => '<h2>Terms of Service</h2><p>These terms govern your use of this website. By accessing or using this site, you agree to these terms.</p>',
                    'status' => 'published',
                    'show_in_nav' => false,
                    'display_order' => 998,
                ]
            );
        }

        return view('public.page', compact('page'));
    }

    public function show($slug)
    {
        $page = cache()->remember('page_'.$slug, 3600, function () use ($slug) {
            return Page::where('slug', $slug)->where('status', 'published')->first();
        });

        if (! $page) {
            abort(404);
        }

        return view('public.page', compact('page'));
    }

}
