@extends('admin.layouts.master')

@section('title', 'Add Testimonial')
@section('header', 'Add Client Testimonial')

@section('admin-content')
<div class="max-w-4xl space-y-6">

    <!-- Top Banner -->
    <div class="flex flex-col gap-4 rounded-2xl border border-[#E5E0D5] bg-gradient-to-br from-white to-[#FAF9F5] p-5 shadow-xs sm:flex-row sm:items-center sm:justify-between sm:p-6">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <a href="{{ route('admin.testimonials.index') }}" class="text-xs font-semibold text-[#B85D19] hover:underline flex items-center gap-1">
                    &larr; Back to Testimonials
                </a>
            </div>
            <h2 class="text-xl font-bold tracking-tight text-stone-900 sm:text-2xl">New Testimonial</h2>
            <p class="mt-1 text-xs text-stone-500 sm:text-sm">Add praise or feedback to showcase client trust.</p>
        </div>
    </div>

    @if($errors->any())
        <div class="rounded-xl border border-rose-200 bg-rose-50 p-4 text-xs text-rose-800">
            <p class="font-bold mb-1">Please fix the following validation errors:</p>
            <ul class="list-disc list-inside space-y-0.5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.testimonials.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="admin-form-card space-y-5">
            <div class="admin-form-header">
                <h3 class="text-sm font-bold text-stone-900 uppercase tracking-wide">Author Information &amp; Quote</h3>
                <p class="text-xs text-stone-500">Provide details of the person or business providing the recommendation.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-2">
                <div class="md:col-span-1 space-y-3">
                    <label class="block text-xs font-bold uppercase tracking-wider text-stone-600">Author Photo</label>
                    <div class="w-24 h-24 rounded-2xl border-2 border-dashed border-[#E5E0D5] bg-stone-50 flex items-center justify-center overflow-hidden">
                        <span class="text-stone-400 text-xs text-center font-medium">100 &times; 100</span>
                    </div>
                    <input type="file" name="image" accept="image/*" class="admin-input text-xs">
                    <p class="text-[11px] text-stone-400">Square avatar recommended (JPG, PNG, WebP up to 2MB).</p>
                </div>

                <div class="md:col-span-2 space-y-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-stone-600 mb-1">Author Name <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" required class="admin-input" placeholder="e.g., Sarah Jenkins">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-stone-600 mb-1">Role / Company</label>
                        <input type="text" name="role_company" value="{{ old('role_company') }}" class="admin-input" placeholder="e.g., Founder &amp; CTO, Acme Systems">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-stone-600 mb-1">Testimonial Quote <span class="text-rose-500">*</span></label>
                        <textarea name="feedback" rows="4" required class="admin-textarea" placeholder="What did they say about your work, technical expertise, or delivery?">{{ old('feedback') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-stone-600 mb-1">Display Order</label>
                        <input type="number" name="display_order" value="{{ old('display_order', 0) }}" class="admin-input w-32" min="0">
                        <p class="text-[11px] text-stone-400 mt-1">Lower numbers appear first on the homepage.</p>
                    </div>

                    <div class="pt-2">
                        <label class="inline-flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_published" value="1" checked class="w-4 h-4 rounded text-[#B85D19] focus:ring-[#B85D19] border-[#E5E0D5]">
                            <span class="text-sm font-semibold text-stone-800">Publish immediately on homepage</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3 pt-2">
            <a href="{{ route('admin.testimonials.index') }}" class="admin-btn-secondary">Cancel</a>
            <button type="submit" class="admin-btn-primary">
                Create Testimonial
            </button>
        </div>
    </form>
</div>
@endsection
