@extends('admin.layouts.master')

@section('title', 'Work Experience & Timeline')
@section('header', 'Work Experience')

@section('admin-content')
<div class="space-y-6">

    <!-- Top Banner -->
    <div class="flex flex-col gap-4 rounded-2xl border border-[#E5E1D5] bg-gradient-to-br from-white to-[#FAF9F5] p-5 shadow-xs sm:flex-row sm:items-center sm:justify-between sm:p-6">
        <div>
            <div class="flex items-center gap-2">
                <span class="inline-flex h-2 w-2 rounded-full bg-[#B85D19]"></span>
                <p class="text-xs font-mono font-bold uppercase tracking-wider text-[#B85D19]">Career Milestones</p>
            </div>
            <h2 class="mt-1 text-xl font-bold tracking-tight text-stone-900 sm:text-2xl">Work Experience &amp; Engineering Timeline</h2>
            <p class="mt-1 text-xs text-stone-500 sm:text-sm">Manage career roles, milestones, training, and commercial delivery records displayed on your Homepage and Resume.</p>
        </div>
        <div class="flex items-center gap-2.5">
            <a href="{{ route('admin.experiences.create') }}" class="admin-btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>Add Experience</span>
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm font-medium text-emerald-800">
            ✓ {{ session('success') }}
        </div>
    @endif

    <!-- Experiences List -->
    <div id="sortable-list" class="space-y-3">
        @forelse($experiences as $exp)
            <div class="rounded-2xl border border-[#E5E1D5] bg-white p-5 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4 transition hover:border-[#B85D19]/40" data-id="{{ $exp->id }}">
                <div class="flex items-start gap-4 min-w-0">
                    <span class="cursor-move text-stone-300 hover:text-stone-600 text-lg select-none px-1 pt-1">⋮⋮</span>
                    <div class="h-10 w-10 rounded-xl bg-[#FAF9F5] border border-[#E5E1D5] flex items-center justify-center text-xs font-bold font-mono text-[#B85D19] shrink-0">
                        0{{ $exp->display_order }}
                    </div>
                    <div class="min-w-0">
                        <div class="flex items-center gap-2 flex-wrap mb-1">
                            <span class="text-xs font-mono font-bold text-[#B85D19] uppercase">{{ $exp->period }}</span>
                            @if($exp->badge_text)
                                <span class="px-2 py-0.5 rounded-full text-[11px] font-semibold bg-stone-100 text-stone-600 border border-stone-200">
                                    {{ $exp->badge_text }}
                                </span>
                            @endif
                            @if($exp->company)
                                <span class="text-xs text-stone-400">•</span>
                                <span class="text-xs font-medium text-stone-600">{{ $exp->company }}</span>
                            @endif
                        </div>
                        <h3 class="font-bold text-stone-900 text-base leading-snug">{{ $exp->role }}</h3>
                        <p class="text-xs text-stone-500 mt-1 line-clamp-2">{{ $exp->description }}</p>
                        @if(!empty($exp->technologies) && is_array($exp->technologies))
                            <div class="flex flex-wrap gap-1 mt-2">
                                @foreach($exp->technologies as $tech)
                                    <span class="text-[10px] font-mono px-2 py-0.5 rounded bg-stone-100 text-stone-600 border border-stone-200">{{ $tech }}</span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <div class="flex items-center gap-2 shrink-0 self-end sm:self-center">
                    @if($exp->is_enabled)
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-bold text-emerald-700 border border-emerald-200">
                            Active
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-stone-100 px-2.5 py-0.5 text-xs font-bold text-stone-600 border border-stone-200">
                            Disabled
                        </span>
                    @endif
                    <a href="{{ route('admin.experiences.edit', $exp->id) }}" class="rounded-lg p-2 text-[#B85D19] hover:bg-[#B85D19]/10 transition" title="Edit experience">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </a>
                    <form action="{{ route('admin.experiences.destroy', $exp->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this experience record?');" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="rounded-lg p-2 text-rose-600 hover:bg-rose-50 transition" title="Delete">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="rounded-2xl border border-dashed border-[#E5E1D5] bg-white p-12 text-center">
                <p class="text-sm text-stone-500">No experiences created yet.</p>
                <a href="{{ route('admin.experiences.create') }}" class="admin-btn-primary mt-4 inline-flex">Add Your First Experience</a>
            </div>
        @endforelse
    </div>

</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const list = document.getElementById('sortable-list');
        if (list) {
            new Sortable(list, {
                handle: '.cursor-move',
                animation: 150,
                onEnd: function () {
                    const order = Array.from(list.children).map(item => item.dataset.id);
                    fetch('{{ route("admin.experiences.reorder") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ order: order })
                    });
                }
            });
        }
    });
</script>
@endpush
@endsection
