<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use App\Models\Page;
use App\Models\Project;
use App\Models\Service;
use App\Models\Skill;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $stats = [
            'total_projects' => Project::count(),
            'published_projects' => Project::where('status', 'published')->count(),
            'draft_projects' => Project::where('status', 'draft')->count(),
            'total_services' => Service::count(),
            'enabled_services' => Service::where('is_enabled', true)->count(),
            'total_enquiries' => Enquiry::count(),
            'new_enquiries' => Enquiry::where('status', 'new')->count(),
            'unread_enquiries' => Enquiry::whereNull('read_at')->count(),
            'total_skills' => Skill::count(),
            'total_pages' => Page::count(),
            'published_pages' => Page::where('status', 'published')->count(),
        ];

        $recentEnquiries = Enquiry::orderBy('created_at', 'desc')->limit(5)->get();
        $recentProjects = Project::orderBy('created_at', 'desc')->limit(5)->get();

        return view('admin.dashboard.index', compact('stats', 'recentEnquiries', 'recentProjects'));
    }
}
