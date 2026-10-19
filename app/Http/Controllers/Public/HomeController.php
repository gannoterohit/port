<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\HomepageSetting;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Service;
use App\Models\Skill;
use App\Models\WorkProcess;
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
            $items = Skill::where('is_featured', true)
                ->where('is_enabled', true)
                ->with('category')
                ->orderBy('display_order')
                ->limit(12)
                ->get();

            if ($items->isEmpty()) {
                $items = Skill::where('is_enabled', true)
                    ->with('category')
                    ->orderBy('display_order')
                    ->limit(12)
                    ->get();
            }

            return $items;
        });

        $featuredProjects = Cache::remember('homepage_featured_projects', 60, function () {
            $projects = Project::where('is_featured', true)
                ->where('status', 'published')
                ->where('published_at', '<=', now())
                ->orderBy('display_order')
                ->limit(6)
                ->get();

            if ($projects->isEmpty()) {
                $projects = Project::where('status', 'published')
                    ->where('published_at', '<=', now())
                    ->orderBy('display_order')
                    ->limit(6)
                    ->get();
            }

            return $projects;
        });

        $featuredServices = Cache::remember('homepage_featured_services', 60, function () {
            $services = Service::where('is_featured', true)
                ->where('is_enabled', true)
                ->orderBy('display_order')
                ->limit(6)
                ->get();

            if ($services->isEmpty()) {
                $services = Service::where('is_enabled', true)
                    ->orderBy('display_order')
                    ->limit(6)
                    ->get();
            }

            return $services;
        });

        $workProcesses = Cache::remember('homepage_work_processes', 3600, function () {
            return WorkProcess::where('is_enabled', true)
                ->orderBy('display_order')
                ->limit(6)
                ->get();
        });

        $skillCategories = Cache::remember('homepage_skill_categories', 3600, function () {
            return \App\Models\SkillCategory::where('is_enabled', true)
                ->with(['skills' => fn ($query) => $query->where('is_enabled', true)->orderBy('display_order')])
                ->orderBy('display_order')
                ->get();
        });

        $testimonials = Cache::remember('homepage_testimonials', 3600, function () {
            return \App\Models\Testimonial::where('is_published', true)
                ->orderBy('display_order')
                ->limit(6)
                ->get();
        });

        return view('public.home', compact(
            'homepageSettings',
            'profile',
            'skills',
            'skillCategories',
            'featuredProjects',
            'featuredServices',
            'workProcesses',
            'testimonials'
        ));
    }
}
