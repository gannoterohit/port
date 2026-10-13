<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WorkProcess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class WorkProcessController extends Controller
{
    public function index()
    {
        $processes = WorkProcess::orderBy('display_order')->get();

        return view('admin.work-processes.index', compact('processes'));
    }

    public function create()
    {
        return view('admin.work-processes.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'icon' => ['nullable', 'string', 'max:255'],
            'is_enabled' => ['boolean'],
        ]);

        $data['display_order'] = WorkProcess::max('display_order') + 1;
        $data['is_enabled'] = $request->boolean('is_enabled', true);

        if ($request->hasFile('icon')) {
            $data['icon'] = $request->file('icon')->store('work-processes', 'public');
        }

        WorkProcess::create($data);

        Cache::forget('homepage_work_processes');

        return redirect()->route('admin.work-processes.index')->with('success', 'Work process step created successfully.');
    }

    public function edit($id)
    {
        $process = WorkProcess::findOrFail($id);

        return view('admin.work-processes.edit', compact('process'));
    }

    public function update(Request $request, $id)
    {
        $process = WorkProcess::findOrFail($id);

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'icon' => ['nullable', 'string', 'max:255'],
            'is_enabled' => ['boolean'],
        ]);

        $data['is_enabled'] = $request->boolean('is_enabled');

        if ($request->hasFile('icon')) {
            Storage::disk('public')->delete($process->icon);
            $data['icon'] = $request->file('icon')->store('work-processes', 'public');
        }

        $process->update($data);

        Cache::forget('homepage_work_processes');

        return redirect()->route('admin.work-processes.index')->with('success', 'Work process step updated successfully.');
    }

    public function destroy($id)
    {
        $process = WorkProcess::findOrFail($id);
        Storage::disk('public')->delete($process->icon);
        $process->delete();

        Cache::forget('homepage_work_processes');

        return back()->with('success', 'Work process step deleted successfully.');
    }

    public function reorder(Request $request)
    {
        $order = $request->input('order', []);

        foreach ($order as $id => $displayOrder) {
            WorkProcess::where('id', $id)->update(['display_order' => $displayOrder]);
        }

        Cache::forget('homepage_work_processes');

        return response()->json(['success' => true]);
    }
}
