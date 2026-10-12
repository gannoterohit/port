<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $services = Service::where('is_enabled', true)
            ->orderBy('display_order')
            ->paginate(12);

        return view('public.services.index', compact('services'));
    }

    public function show($slug)
    {
        $service = cache()->remember('service_' . $slug, 3600, function () use ($slug) {
            return Service::where('slug', $slug)
                ->where('is_enabled', true)
                ->first();
        });

        if (!$service) {
            abort(404);
        }

        $relatedServices = Service::where('is_enabled', true)
            ->where('id', '!=', $service->id)
            ->orderBy('display_order')
            ->limit(3)
            ->get();

        return view('public.services.show', compact('service', 'relatedServices'));
    }
}
