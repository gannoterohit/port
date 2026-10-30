<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VisitorLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index(Request $request)
    {
        // 1. Metric Cards
        $totalVisits = VisitorLog::count();
        $uniqueVisitors = VisitorLog::distinct('ip_address')->count('ip_address');
        $todayVisits = VisitorLog::today()->count();
        $todayUnique = VisitorLog::today()->distinct('ip_address')->count('ip_address');
        $humanVisits = VisitorLog::realVisitors()->count();

        // 2. Top Visited Pages
        $topPages = VisitorLog::realVisitors()
            ->select('page_url', 'page_title', DB::raw('count(*) as total'))
            ->groupBy('page_url', 'page_title')
            ->orderByDesc('total')
            ->limit(6)
            ->get();

        // 3. Traffic Sources (Referrers)
        $topReferrers = VisitorLog::realVisitors()
            ->select('referer_host', DB::raw('count(*) as total'))
            ->groupBy('referer_host')
            ->orderByDesc('total')
            ->limit(6)
            ->get();

        // 4. Device Distribution
        $deviceStats = VisitorLog::realVisitors()
            ->select('device_type', DB::raw('count(*) as total'))
            ->groupBy('device_type')
            ->orderByDesc('total')
            ->get();

        // 5. Browser Distribution
        $browserStats = VisitorLog::realVisitors()
            ->select('browser', DB::raw('count(*) as total'))
            ->whereNotNull('browser')
            ->groupBy('browser')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        // 6. Recent Logs with Filters
        $query = VisitorLog::query();

        if ($request->filled('search')) {
            $search = trim($request->input('search'));
            $query->where(function ($q) use ($search) {
                $q->where('ip_address', 'like', "%{$search}%")
                  ->orWhere('page_url', 'like', "%{$search}%")
                  ->orWhere('page_title', 'like', "%{$search}%")
                  ->orWhere('referer_host', 'like', "%{$search}%")
                  ->orWhere('country', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%")
                  ->orWhere('browser', 'like', "%{$search}%")
                  ->orWhere('os', 'like', "%{$search}%");
            });
        }

        if ($request->filled('device') && $request->device !== 'all') {
            $query->where('device_type', $request->device);
        }

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $logs = $query->orderBy('created_at', 'desc')->paginate(25)->withQueryString();

        return view('admin.analytics.index', compact(
            'totalVisits',
            'uniqueVisitors',
            'todayVisits',
            'todayUnique',
            'humanVisits',
            'topPages',
            'topReferrers',
            'deviceStats',
            'browserStats',
            'logs'
        ));
    }

    public function clearOld(Request $request)
    {
        $days = (int) $request->input('days', 30);
        $deleted = VisitorLog::where('created_at', '<', now()->subDays($days))->delete();

        return back()->with('success', "Cleared {$deleted} visitor log records older than {$days} days.");
    }
}

