@extends('admin.layouts.master')

@section('title', 'Navigation')
@section('header', 'Navigation Management')

@section('admin-content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-xl font-semibold text-gray-900">Header Navigation</h2>
            <p class="text-xs text-gray-500 mt-0.5">Manage and reorder links that appear in the public site header.</p>
        </div>
        <button type="button" onclick="openAddModal()"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
            + Add Menu Item
        </button>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <div id="sortable-list" class="space-y-2">
            @forelse($items as $item)
                <div class="border border-gray-200 rounded-lg p-3 flex items-center justify-between hover:bg-gray-50 transition-colors"
                     data-id="{{ $item->id }}"
                     data-label="{{ $item->label }}"
                     data-url="{{ $item->url }}"
                     data-target="{{ $item->target ?? '_self' }}"
                     data-visible="{{ $item->is_visible ? '1' : '0' }}">
                    <div class="flex items-center gap-3">
                        <span class="cursor-move text-gray-400 select-none text-lg">≡</span>
                        <div class="flex flex-col sm:flex-row sm:items-center sm:gap-3">
                            <span class="text-sm font-semibold text-gray-900">{{ $item->label }}</span>
                            <span class="text-xs text-gray-500 font-mono">{{ $item->url }}</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="text-xs px-2.5 py-1 rounded-full font-medium {{ $item->is_visible ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">
                            {{ $item->is_visible ? 'Visible' : 'Hidden' }}
                        </span>
                        <button type="button" onclick="editItem({{ $item->id }})"
                            class="text-blue-600 hover:text-blue-700 p-1" title="Edit">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </button>
                        <form method="POST" action="{{ route('admin.navigation.destroy', $item->id) }}" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Delete this navigation item?')"
                                class="text-red-600 hover:text-red-700 p-1" title="Delete">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.133A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.86L5 7m5 5v6m4-6v6m1-10V4a1 1 0 00-1-1h-2a1 1 0 00-1 1v3m-4 0h6"></path>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 text-center py-8">No navigation items found. Click "+ Add Menu Item" to create one.</p>
            @endforelse
        </div>

        @if($items->count() > 1)
            <div class="mt-6 pt-4 border-t border-gray-100 flex items-center justify-between">
                <span class="text-xs text-gray-400">Drag items to change header ordering</span>
                <button onclick="saveOrder()" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                    Save Order
                </button>
            </div>
        @endif
    </div>
</div>

<!-- Modal -->
<div id="addItemModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl p-6 w-full max-w-md shadow-2xl border border-gray-100">
        <h3 class="text-lg font-bold text-gray-900 mb-4" id="modalTitle">Add Navigation Item</h3>
        <form id="itemForm" method="POST" action="{{ route('admin.navigation.store') }}">
            @csrf
            <input type="hidden" name="id" id="itemId">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Label *</label>
                    <input type="text" name="label" id="itemLabel" required class="admin-input" placeholder="e.g. Projects">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">URL *</label>
                    <input type="text" name="url" id="itemUrl" required class="admin-input" placeholder="/projects or https://...">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Target</label>
                    <select name="target" id="itemTarget" class="admin-input">
                        <option value="_self">Same Window (_self)</option>
                        <option value="_blank">New Window (_blank)</option>
                    </select>
                </div>
                <div class="flex items-center gap-2 pt-2">
                    <input type="checkbox" name="is_visible" value="1" id="itemVisible" checked class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    <label for="itemVisible" class="text-sm text-gray-700 select-none">Visible in header</label>
                </div>
            </div>
            <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-100">
                <button type="button" onclick="closeModal()"
                    class="text-gray-600 hover:text-gray-900 px-4 py-2 text-sm">Cancel</button>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg text-sm font-medium transition-colors">
                    Save Item
                </button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
const sortableEl = document.getElementById('sortable-list');
if (sortableEl) {
    new Sortable(sortableEl, {
        animation: 150,
        ghostClass: 'opacity-50'
    });
}

function openAddModal() {
    document.getElementById('modalTitle').textContent = 'Add Navigation Item';
    document.getElementById('itemId').value = '';
    document.getElementById('itemLabel').value = '';
    document.getElementById('itemUrl').value = '';
    document.getElementById('itemTarget').value = '_self';
    document.getElementById('itemVisible').checked = true;

    const form = document.getElementById('itemForm');
    form.action = '{{ route('admin.navigation.store') }}';
    const methodInput = form.querySelector('input[name="_method"]');
    if (methodInput) {
        methodInput.remove();
    }

    const modal = document.getElementById('addItemModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeModal() {
    const modal = document.getElementById('addItemModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

function editItem(id) {
    const el = document.querySelector(`[data-id="${id}"]`);
    if (!el) return;

    const label = el.dataset.label;
    const url = el.dataset.url;
    const target = el.dataset.target || '_self';
    const visible = el.dataset.visible === '1';

    document.getElementById('modalTitle').textContent = 'Edit Navigation Item';
    document.getElementById('itemId').value = id;
    document.getElementById('itemLabel').value = label;
    document.getElementById('itemUrl').value = url;
    document.getElementById('itemTarget').value = target;
    document.getElementById('itemVisible').checked = visible;

    const form = document.getElementById('itemForm');
    form.action = '{{ url('admin/navigation') }}/' + id;
    let methodInput = form.querySelector('input[name="_method"]');
    if (!methodInput) {
        methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        form.appendChild(methodInput);
    }
    methodInput.value = 'PUT';

    const modal = document.getElementById('addItemModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

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
</script>
@endsection
