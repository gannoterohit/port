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
        Setting::updateOrCreate(
            ['key' => 'maintenance_mode'],
            ['value' => '1', 'group' => 'general', 'type' => 'boolean', 'label' => 'Maintenance Mode']
        );

        return back()->with('success', 'Maintenance mode enabled.');
    }

    public function disable()
    {
        Setting::updateOrCreate(
            ['key' => 'maintenance_mode'],
            ['value' => '0', 'group' => 'general', 'type' => 'boolean', 'label' => 'Maintenance Mode']
        );

        return back()->with('success', 'Maintenance mode disabled.');
    }
}
