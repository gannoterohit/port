<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\HomepageSetting;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Service;
use App\Models\Skill;
use App\Models\SkillCategory;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function __invoke(Request $request)
    {
        $homepageSettings = Cache::remember('homepage_settings', 3600, function () {
            return HomepageSetting::getInstance();
        });

        $profile = Cache::remember('profile', 3600, function () {
            return Profile::getInstance();
        });

        $skills = Cache::remember('homepage_skills', 3600, function () {
            return Skill::where('is_featured', true)
                ->where('is_enabled', true)
                ->with('category')
                ->orderBy('display_order')
                ->limit(12)
                ->get();
        });

        $featuredProjects = Cache::remember('homepage_featured_projects', 60, function () {
            return Project::where('is_featured', true)
                ->where('status', 'published')
                ->where('published_at', '<=', now())
                ->orderBy('display_order')
                ->limit(6)
                ->get();
        });

        $featuredServices = Cache::remember('homepage_featured_services', 60, function () {
            return Service::where('is_featured', true)
                ->where('is_enabled', true)
                ->orderBy('display_order')
                ->limit(6)
                ->get();
        });

        $testimonials = Cache::remember('homepage_testimonials', 3600, function () {
            return Testimonial::where('is_published', true)
                ->orderBy('display_order')
                ->limit(6)
                ->get();
        });

        $workProcesses = Cache::remember('homepage_work_processes', 3600, function () {
            return \App\Models\WorkProcess::where('is_enabled', true)
                ->orderBy('display_order')
                ->limit(6)
                ->get();
        });

        return view('public.home', compact(
            'homepageSettings',
            'profile',
            'skills',
            'featuredProjects',
            'featuredServices',
            'testimonials',
            'workProcesses'
        ));
    }
}
