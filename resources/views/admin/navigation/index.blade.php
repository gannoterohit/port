@extends('admin.layouts.master')

@section('title', 'Navigation')
@section('header', 'Navigation Management')

@section('admin-content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="text-xl font-semibold text-gray-900">Header Navigation</h2>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Menu Items</h3>
            <button type="button" onclick="document.getElementById('addItemModal').classList.remove('hidden')"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                Add Item
            </button>
        </div>

        <div id="sortable-list" class="space-y-2">
            @forelse($items as $item)
                <div class="border border-gray-200 rounded-lg p-3 flex items-center justify-between" data-id="{{ $item->id }}">
                    <div class="flex items-center gap-3">
                        <span class="cursor-move text-gray-400">≡</span>
                        <input type="text" value="{{ $item->label }}" readonly class="bg-transparent border-0 text-sm font-medium text-gray-900 min-w-[150px]">
                        <input type="text" value="{{ $item->url }}" readonly class="bg-transparent border-0 text-xs text-gray-500">
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-xs px-2 py-1 rounded-full {{ $item->is_visible ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">
                            {{ $item->is_visible ? 'Visible' : 'Hidden' }}
                        </span>
                        <button type="button" onclick="editItem({{ $item->id }})"
                            class="text-blue-600 hover:text-blue-700">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.441-9.5L11 13.55L6.44 19H5.44L0.88 13.44L5.44 8.88L10.56 13.44L15.12 7.44L19.5 11.82V8L21.44 6.44L18 3L15.12 7.44Z"></path>
                            </svg>
                        </button>
                        <form method="POST" action="{{ route('admin.navigation.destroy', $item->id) }}" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Delete this item?')"
                                class="text-red-600 hover:text-red-700">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.133A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.86L5 7m5 5v6m4-6v6m1-10V4a1 1 0 00-1-1h-2a1 1 0 00-1 1v3m-4 0h6"></path>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 text-center py-4">No navigation items found.</p>
            @endforelse
        </div>

        <div class="mt-4">
            <button onclick="saveOrder()" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium">
                Save Order
            </button>
        </div>
    </div>
</div>

<div id="addItemModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl p-6 w-full max-w-md">
        <h3 class="text-lg font-semibold mb-4" id="modalTitle">Add Navigation Item</h3>
        <form id="itemForm" method="POST">
            @csrf
            <input type="hidden" name="id" id="itemId">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Label</label>
                    <input type="text" name="label" id="itemLabel" class="admin-input">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">URL</label>
                    <input type="text" name="url" id="itemUrl" class="admin-input" placeholder="/projects">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Target</label>
                    <select name="target" id="itemTarget" class="admin-input">
                        <option value="_self">Same Window</option>
                        <option value="_blank">New Window</option>
                    </select>
                </div>
                <div class="flex items-center gap-2">
                    <input type="checkbox" name="is_visible" value="1" id="itemVisible" checked>
                    <label class="text-sm text-gray-700">Visible</label>
                </div>
            </div>
            <div class="flex justify-end gap-3 mt-6">
                <button type="button" onclick="document.getElementById('addItemModal').classList.add('hidden')"
                    class="text-gray-600 hover:text-gray-900 px-4 py-2">Cancel</button>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">Save</button>
            </div>
        </form>
    </div>
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

    fetch('{{ route('admin.navigation.reorder') }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ order: order })
    }).then(() => location.reload());
}

function editItem(id) {
    fetch('/admin/navigation/' + id)
        .then(r => r.text())
        .then(() => {
            // Would need API endpoint - for now, show inline form
            const el = document.querySelector(`[data-id="${id}"]`);
            const label = el.querySelector('input').value;
            const url = el.querySelectorAll('input')[1].value;
            
            document.getElementById('modalTitle').textContent = 'Edit Navigation Item';
            document.getElementById('itemId').value = id;
            document.getElementById('itemLabel').value = label;
            document.getElementById('itemUrl').value = url;
            document.getElementById('addItemModal').classList.remove('hidden');
            
            const form = document.getElementById('itemForm');
            form.action = '/admin/navigation/' + id;
            form.querySelector('input[name="_method"]').remove();
            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'PUT';
            form.appendChild(methodInput);
        });
}
</script>
@endsection
