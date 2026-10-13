<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Traits\HandlesFileUploads;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    use HandlesFileUploads;

    public function index(Request $request)
    {
        $query = Service::query();

        if ($request->filled('status')) {
            $query->where('is_enabled', $request->status === 'enabled');
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%'.$request->search.'%')
                    ->orWhere('description', 'like', '%'.$request->search.'%');
            });
        }

        $services = $query->orderBy('display_order')->paginate(15)->withQueryString();

        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:services,slug'],
            'description' => ['nullable', 'string'],
            'icon' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'],
            'features' => ['nullable', 'array'],
            'features.*' => ['string', 'max:255'],
            'cta_text' => ['nullable', 'string', 'max:100'],
            'cta_url' => ['nullable', 'string', 'max:255'],
            'is_enabled' => ['boolean'],
            'is_featured' => ['boolean'],
            'display_order' => ['nullable', 'integer', 'min:0'],
            'seo_title' => ['nullable', 'string', 'max:255'],
            'seo_description' => ['nullable', 'string', 'max:500'],
            'og_title' => ['nullable', 'string', 'max:255'],
            'og_description' => ['nullable', 'string', 'max:500'],
            'og_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'],
            'canonical_url' => ['nullable', 'url', 'max:255'],
            'no_index' => ['boolean'],
        ]);

        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);
        $data['display_order'] = $data['display_order'] ?? Service::max('display_order') + 1;
        $data['is_enabled'] = $request->boolean('is_enabled', true);
        $data['is_featured'] = $request->boolean('is_featured', false);
        $data['no_index'] = $request->boolean('no_index');

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadFile($request->file('image'), 'services');
        }

        if ($request->hasFile('og_image')) {
            $data['og_image'] = $this->uploadFile($request->file('og_image'), 'services/seo');
        }

        Service::create($data);

        Cache::forget('homepage_featured_services');

        return redirect()->route('admin.services.index')->with('success', 'Service created successfully.');
    }

    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:services,slug,'.$service->id],
            'description' => ['nullable', 'string'],
            'icon' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'],
            'features' => ['nullable', 'array'],
            'features.*' => ['string', 'max:255'],
            'cta_text' => ['nullable', 'string', 'max:100'],
            'cta_url' => ['nullable', 'string', 'max:255'],
            'is_enabled' => ['boolean'],
            'is_featured' => ['boolean'],
            'display_order' => ['nullable', 'integer', 'min:0'],
            'seo_title' => ['nullable', 'string', 'max:255'],
            'seo_description' => ['nullable', 'string', 'max:500'],
            'og_title' => ['nullable', 'string', 'max:255'],
            'og_description' => ['nullable', 'string', 'max:500'],
            'og_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'],
            'canonical_url' => ['nullable', 'url', 'max:255'],
            'no_index' => ['boolean'],
        ]);

        $data['is_enabled'] = $request->boolean('is_enabled');
        $data['is_featured'] = $request->boolean('is_featured');
        $data['no_index'] = $request->boolean('no_index');

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadFile($request->file('image'), 'services', $service->image);
        }

        if ($request->hasFile('og_image')) {
            $data['og_image'] = $this->uploadFile($request->file('og_image'), 'services/seo', $service->og_image);
        }

        $service->update($data);

        Cache::forget('homepage_featured_services');
        Cache::forget('service_'.$service->slug);

        return redirect()->route('admin.services.index')->with('success', 'Service updated successfully.');
    }

    public function destroy(Service $service)
    {
        $this->deleteFile($service->image);
        $this->deleteFile($service->og_image);

        $slug = $service->slug;
        $service->delete();

        Cache::forget('homepage_featured_services');
        Cache::forget('service_'.$slug);

        return redirect()->route('admin.services.index')->with('success', 'Service deleted successfully.');
    }
}
