<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TestimonialController extends Controller
{
    public function index(Request $request)
    {
        $query = Testimonial::query();

        if ($request->filled('status')) {
            $query->where('is_published', $request->status === 'published');
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('feedback', 'like', '%' . $request->search . '%')
                    ->orWhere('role_company', 'like', '%' . $request->search . '%');
            });
        }

        $testimonials = $query->orderBy('display_order')->paginate(15)->withQueryString();

        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function create()
    {
        return view('admin.testimonials.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'role_company' => ['nullable', 'string', 'max:255'],
            'feedback' => ['required', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            'is_published' => ['boolean'],
            'display_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $data['display_order'] = $data['display_order'] ?? Testimonial::max('display_order') + 1;
        $data['is_published'] = $request->boolean('is_published', true);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('testimonials', 'public');
        }

        Testimonial::create($data);
        \Illuminate\Support\Facades\Cache::forget('homepage_testimonials');

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial created successfully.');
    }

    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'role_company' => ['nullable', 'string', 'max:255'],
            'feedback' => ['required', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            'is_published' => ['boolean'],
            'display_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $data['is_published'] = $request->boolean('is_published');

        if ($request->hasFile('image')) {
            if ($testimonial->image) {
                Storage::disk('public')->delete($testimonial->image);
            }
            $data['image'] = $request->file('image')->store('testimonials', 'public');
        }

        $testimonial->update($data);
        \Illuminate\Support\Facades\Cache::forget('homepage_testimonials');

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial updated successfully.');
    }

    public function destroy(Testimonial $testimonial)
    {
        if ($testimonial->image) {
            Storage::disk('public')->delete($testimonial->image);
        }
        $testimonial->delete();
        \Illuminate\Support\Facades\Cache::forget('homepage_testimonials');

        return back()->with('success', 'Testimonial deleted successfully.');
    }
}
