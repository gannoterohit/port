<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Service;
use App\Models\Skill;
use App\Models\SkillCategory;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function about()
    {
        $profile = \Illuminate\Support\Facades\Cache::remember('profile', 3600, fn () => Profile::getInstance());

        return view('public.about', compact('profile'));
    }

    public function skills()
    {
        $categories = SkillCategory::where('is_enabled', true)
            ->with(['skills' => function ($q) {
                $q->where('is_enabled', true)->orderBy('display_order');
            }])
            ->orderBy('display_order')
            ->get();

        $skills = Skill::where('is_enabled', true)
            ->with('category')
            ->orderByRaw("FIELD(category_id, " . implode(',', $categories->pluck('id')->toArray()) . ")")
            ->orderBy('display_order')
            ->get();

        return view('public.skills', compact('categories', 'skills'));
    }

    public function resume()
    {
        $profile = \Illuminate\Support\Facades\Cache::remember('profile', 3600, fn () => Profile::getInstance());

        return view('public.resume', compact('profile'));
    }

    public function privacy()
    {
        $page = Page::where('slug', 'privacy-policy')->first();

        if (!$page) {
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

    public function show($slug)
    {
        $page = cache()->remember('page_' . $slug, 3600, function () use ($slug) {
            return Page::where('slug', $slug)->where('status', 'published')->first();
        });

        if (!$page) {
            abort(404);
        }

        return view('public.page', compact('page'));
    }

    public function contactInfo()
    {
        $profile = \Illuminate\Support\Facades\Cache::remember('profile', 3600, fn () => Profile::getInstance());

        return view('public.contact-info', compact('profile'));
    }
}
