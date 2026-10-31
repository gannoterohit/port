<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use App\Models\Page;
use App\Models\Project;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Skill;
use App\Models\Testimonial;
use App\Models\VisitorLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            'in_progress_enquiries' => Enquiry::where('status', 'in_progress')->count(),
            'converted_enquiries' => Enquiry::where('status', 'converted')->count(),
            'total_skills' => Skill::count(),
            'total_pages' => Page::count(),
            'published_pages' => Page::where('status', 'published')->count(),
            'total_testimonials' => Testimonial::count(),
            'total_visits' => VisitorLog::count(),
            'today_visits' => VisitorLog::whereDate('created_at', today())->count(),
            'maintenance_mode' => Setting::get('maintenance_mode', '0') === '1',
        ];

        $recentEnquiries = Enquiry::orderBy('created_at', 'desc')->limit(6)->get();
        $recentProjects = Project::orderBy('created_at', 'desc')->limit(6)->get();

        // Enquiries status distribution for visual pipeline
        $enquiryDistribution = [
            'new' => Enquiry::where('status', 'new')->count(),
            'in_progress' => Enquiry::where('status', 'in_progress')->count(),
            'contacted' => Enquiry::where('status', 'contacted')->count(),
            'converted' => Enquiry::where('status', 'converted')->count(),
            'closed' => Enquiry::where('status', 'closed')->count(),
        ];

        // Device breakdown from real analytics logs
        $deviceBreakdown = VisitorLog::select('device_type', DB::raw('count(*) as count'))
            ->groupBy('device_type')
            ->pluck('count', 'device_type')
            ->toArray();

        return view('admin.dashboard.index', compact(
            'stats',
            'recentEnquiries',
            'recentProjects',
            'enquiryDistribution',
            'deviceBreakdown'
        ));
    }
}

