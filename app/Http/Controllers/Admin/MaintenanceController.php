<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;

class MaintenanceController extends Controller
{
    public function edit()
    {
        $maintenance = Setting::where('key', 'maintenance_mode')->first();

        return view('admin.maintenance.edit', compact('maintenance'));
    }

    public function update()
    {
        $setting = Setting::where('key', 'maintenance_mode')->first();
        $setting->update(['value' => '1']);

        return back()->with('success', 'Maintenance mode enabled.');
    }

    public function disable()
    {
        $setting = Setting::where('key', 'maintenance_mode')->first();
        if ($setting) {
            $setting->update(['value' => '0']);
        }

        return back()->with('success', 'Maintenance mode disabled.');
    }
}
