@extends('admin.layouts.master')

@section('title', 'Edit Work Experience')
@section('header', 'Edit Experience')

@section('admin-content')
<div class="max-w-4xl space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold tracking-tight text-stone-900 sm:text-2xl">Edit Work Experience Milestone</h2>
            <p class="mt-1 text-xs text-stone-500 sm:text-sm">Update role, period, responsibilities, and technologies.</p>
        </div>
        <a href="{{ route('admin.experiences.index') }}" class="admin-btn-secondary">
            &larr; Back to List
        </a>
    </div>

    <form action="{{ route('admin.experiences.update', $experience->id) }}" method="POST" class="rounded-2xl border border-[#E5E1D5] bg-white p-6 sm:p-8 shadow-xs space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-2">Job Title / Role *</label>
                <input type="text" name="role" required value="{{ old('role', $experience->role) }}" placeholder="e.g. Senior PHP & Laravel Backend Developer" class="w-full rounded-xl border border-[#E5E1D5] p-3 text-sm focus:border-[#B85D19] focus:outline-none">
                @error('role') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-2">Company / Organization</label>
                <input type="text" name="company" value="{{ old('company', $experience->company) }}" placeholder="e.g. Tech Innovations / Freelance" class="w-full rounded-xl border border-[#E5E1D5] p-3 text-sm focus:border-[#B85D19] focus:outline-none">
                @error('company') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-2">Period / Years *</label>
                <input type="text" name="period" required value="{{ old('period', $experience->period) }}" placeholder="e.g. 2023 — Present or 2022 — 2023" class="w-full rounded-xl border border-[#E5E1D5] p-3 text-sm focus:border-[#B85D19] focus:outline-none">
                @error('period') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-2">Badge Text (Optional)</label>
                <input type="text" name="badge_text" value="{{ old('badge_text', $experience->badge_text) }}" placeholder="e.g. Active Role, Commercial Delivery, Foundation" class="w-full rounded-xl border border-[#E5E1D5] p-3 text-sm focus:border-[#B85D19] focus:outline-none">
                @error('badge_text') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-2">Description &amp; Key Responsibilities</label>
            <textarea name="description" rows="4" placeholder="Briefly describe what you engineered, systems designed, and technical achievements..." class="w-full rounded-xl border border-[#E5E1D5] p-3 text-sm focus:border-[#B85D19] focus:outline-none">{{ old('description', $experience->description) }}</textarea>
            @error('description') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-2">Technologies / Skills (Comma-separated)</label>
            @php
                $techVal = is_array($experience->technologies) ? implode(', ', $experience->technologies) : $experience->technologies;
            @endphp
            <input type="text" name="technologies" value="{{ old('technologies', $techVal) }}" placeholder="Laravel 11, PHP 8.2+, MySQL Indexing, Redis Queues, REST APIs" class="w-full rounded-xl border border-[#E5E1D5] p-3 text-sm focus:border-[#B85D19] focus:outline-none">
            <p class="text-[11px] text-stone-500 mt-1">Separate skills with commas. These will render as clean badges on the card.</p>
        </div>

        <div class="flex items-center gap-3 pt-2">
            <input type="checkbox" name="is_enabled" id="is_enabled" value="1" {{ old('is_enabled', $experience->is_enabled) ? 'checked' : '' }} class="rounded border-stone-300 text-[#B85D19] focus:ring-[#B85D19]">
            <label for="is_enabled" class="text-sm font-medium text-stone-800">Show this milestone on public website</label>
        </div>

        <div class="flex items-center justify-end gap-3 pt-4 border-t border-[#E5E1D5]">
            <a href="{{ route('admin.experiences.index') }}" class="admin-btn-secondary">Cancel</a>
            <button type="submit" class="admin-btn-primary">Update Experience</button>
        </div>
    </form>
</div>
@endsection
