<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class MaintenanceModeMiddleware
{
    protected $excludedPaths = [
        'admin/login',
        'admin/logout',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        try {
            $maintenanceMode = Setting::where('key', 'maintenance_mode')->value('value');
        } catch (\Throwable $e) {
            $maintenanceMode = null;
        }

        if ($maintenanceMode === '1' || $maintenanceMode === true || $maintenanceMode === 1) {
            if (Auth::check() && Auth::user()->is_admin) {
                return $next($request);
            }

            foreach ($this->excludedPaths as $path) {
                if ($request->is($path)) {
                    return $next($request);
                }
            }

            if ($request->expectsJson()) {
                return response()->json(['message' => 'Site is under maintenance.'], 503);
            }

            return response()->view('errors.maintenance', [], 503);
        }

        return $next($request);
    }
}
