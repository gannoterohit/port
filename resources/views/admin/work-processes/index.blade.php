@extends('admin.layouts.master')

@section('title', 'Work Process & Standards')
@section('header', 'Delivery Standards')

@section('admin-content')
<div class="space-y-6">

    <!-- Top Banner -->
    <div class="flex flex-col gap-4 rounded-2xl border border-[#E5E1D5] bg-gradient-to-br from-white to-[#FAF9F5] p-5 shadow-xs sm:flex-row sm:items-center sm:justify-between sm:p-6">
        <div>
            <div class="flex items-center gap-2">
                <span class="inline-flex h-2 w-2 rounded-full bg-[#B85D19]"></span>
                <p class="text-xs font-mono font-bold uppercase tracking-wider text-[#B85D19]">Workflow Architecture</p>
            </div>
            <h2 class="mt-1 text-xl font-bold tracking-tight text-stone-900 sm:text-2xl">Delivery Standards &amp; Process Steps</h2>
            <p class="mt-1 text-xs text-stone-500 sm:text-sm">Highlight your development lifecycle (Requirements, Architecture, Implementation, Testing, Launch).</p>
        </div>
        <div class="flex items-center gap-2.5">
            <a href="{{ route('admin.work-processes.create') }}" class="admin-btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>Add Step</span>
            </a>
        </div>
    </div>

    <!-- Steps List -->
    <div id="sortable-list" class="space-y-3">
        @forelse($processes as $process)
            <div class="rounded-2xl border border-[#E5E1D5] bg-white p-4 shadow-xs flex items-center justify-between transition hover:border-[#B85D19]/40" data-id="{{ $process->id }}">
                <div class="flex items-center gap-4 min-w-0">
                    <span class="cursor-move text-stone-300 hover:text-stone-600 text-lg select-none px-1">⋮⋮</span>
                    <div class="h-9 w-9 rounded-xl bg-[#FAF9F5] border border-[#E5E1D5] flex items-center justify-center text-xs font-bold font-mono text-[#B85D19] shrink-0">
                        0{{ $process->display_order }}
                    </div>
                    @if($process->icon)
                        <img src="{{ $process->icon_url }}" alt="Icon" class="h-9 w-9 object-contain shrink-0">
                    @endif
                    <div class="min-w-0">
                        <p class="font-bold text-stone-900 truncate">{{ $process->title }}</p>
                        <p class="text-xs text-stone-500 line-clamp-1">{{ Str::limit($process->description, 80) }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-2 shrink-0">
                    @if($process->is_enabled)
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-bold text-emerald-700 border border-emerald-200">
                            Active
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-stone-100 px-2.5 py-0.5 text-xs font-bold text-stone-600 border border-stone-200">
                            Disabled
                        </span>
                    @endif
                    <a href="{{ route('admin.work-processes.edit', $process->id) }}" class="rounded-lg p-1.5 text-[#B85D19] hover:bg-[#B85D19]/10 transition" title="Edit step">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </a>
                    <form method="POST" action="{{ route('admin.work-processes.destroy', $process->id) }}" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Delete this step?')" class="rounded-lg p-1.5 text-stone-400 hover:bg-rose-50 hover:text-rose-600 transition" title="Delete step">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.133A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.86L5 7m5 5v6m4-6v6m1-10V4a1 1 0 00-1-1h-2a1 1 0 00-1 1v3m-4 0h6"></path>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="rounded-2xl border border-[#E5E1D5] bg-white p-12 text-center">
                <p class="text-sm font-bold text-stone-900">No work process steps yet</p>
                <a href="{{ route('admin.work-processes.create') }}" class="admin-btn-primary mt-4 text-xs">
                    + Add Step
                </a>
            </div>
        @endforelse
    </div>

    @if($processes->count() > 1)
        <div>
            <button onclick="saveOrder()" class="admin-btn-secondary text-xs">
                Save Dragged Order
            </button>
        </div>
    @endif

</div>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
const sortable = new Sortable(document.getElementById('sortable-list'), {
    animation: 150,
    ghostClass: 'opacity-50'
});

function saveOrder() {
    const ids = Array.from(document.querySelectorAll('#sortable-list > div')).map(el => el.dataset.id);
    fetch('{{ route('admin.work-processes.reorder') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ order: ids })
    }).then(r => r.json()).then(data => {
        if(data.success) {
            alert('Step sequence updated successfully!');
            location.reload();
        }
    });
}
</script>
@endsection
