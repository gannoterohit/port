@extends('admin.layouts.master')

@section('title', 'Work Processes')
@section('header', 'Work Process Steps')

@section('admin-content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-semibold text-gray-900">Manage Work Process Steps</h2>
    <a href="{{ route('admin.work-processes.create') }}"
        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
        Add Step
    </a>
</div>

<div id="sortable-list" class="space-y-3">
    @forelse($processes as $process)
        <div class="bg-white rounded-xl border border-gray-200 p-4 flex items-center justify-between" data-id="{{ $process->id }}">
            <div class="flex items-center gap-4">
                <span class="cursor-move text-gray-400">≡</span>
                <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center text-sm font-bold text-gray-600">
                    {{ $process->display_order }}
                </div>
                @if($process->icon)
                    <img src="{{ $process->icon_url }}" alt="Icon" class="w-10 h-10 object-contain">
                @else
                    <div class="w-10 h-10 bg-gray-200 rounded-lg flex items-center justify-center text-gray-500">—</div>
                @endif
                <div>
                    <p class="font-medium text-gray-900">{{ $process->title }}</p>
                    <p class="text-sm text-gray-500">{{ Str::limit($process->description, 60) }}</p>
                </div>
            </div>
            <div class="flex gap-2">
                <span class="text-xs px-2 py-1 rounded-full {{ $process->is_enabled ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">
                    {{ $process->is_enabled ? 'Enabled' : 'Disabled' }}
                </span>
                <a href="{{ route('admin.work-processes.edit', $process->id) }}" class="text-blue-600 hover:text-blue-700" title="Edit step">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                </a>
                <form method="POST" action="{{ route('admin.work-processes.destroy', $process->id) }}" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Delete this step?')"
                        class="text-red-600 hover:text-red-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.133A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.86L5 7m5 5v6m4-6v6m1-10V4a1 1 0 00-1-1h-2a1 1 0 00-1 1v3m-4 0h6"></path>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    @empty
        <p class="text-center py-8 text-gray-500">No work process steps found.</p>
    @endforelse
</div>

<div class="mt-4">
    <button onclick="saveOrder()" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium">
        Save Order
    </button>
</div>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
const sortable = new Sortable(document.getElementById('sortable-list'), {
    animation: 150,
    ghostClass: 'opacity-50'
});

function saveOrder() {
    const order = {};
    document.querySelectorAll('#sortable-list [data-id]').forEach((el, index) => {
        order[el.dataset.id] = index + 1;
    });

    fetch('{{ route('admin.work-processes.reorder') }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ order: order })
    }).then(() => location.reload());
}
</script>
@endsection
