@extends('admin.layouts.master')

@section('title', 'Navigation')
@section('header', 'Header Navigation')

@section('admin-content')
<div class="space-y-6">

    <!-- Top Banner -->
    <div class="flex flex-col gap-4 rounded-2xl border border-[#E5E0D5] bg-gradient-to-br from-white to-[#FAF9F5] p-5 shadow-xs sm:flex-row sm:items-center sm:justify-between sm:p-6">
        <div>
            <div class="flex items-center gap-2">
                <span class="inline-flex h-2 w-2 rounded-full bg-[#B85D19]"></span>
                <p class="text-xs font-mono font-bold uppercase tracking-wider text-[#B85D19]">Site Structure</p>
            </div>
            <h2 class="mt-1 text-xl font-bold tracking-tight text-stone-900 sm:text-2xl">Header Navigation Menu</h2>
            <p class="mt-1 text-xs text-stone-500 sm:text-sm">Manage, reorder, and toggle visibility for menu links shown in the website header.</p>
        </div>
        <div class="flex items-center gap-2.5">
            <button type="button" onclick="openAddModal()" class="admin-btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>Add Menu Item</span>
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
            <svg class="h-5 w-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <div class="admin-card p-5 sm:p-6">
        <div class="flex items-center justify-between pb-4 border-b border-[#E5E0D5]">
            <h3 class="text-sm font-bold text-stone-900 uppercase tracking-wide">Menu Structure &amp; Sort Order</h3>
            <span class="text-xs text-stone-400">Drag handles to change display order</span>
        </div>

        <div id="sortable-list" class="space-y-2.5 mt-4">
            @forelse($items as $item)
                <div class="border border-[#E5E0D5] bg-white rounded-xl p-3.5 flex items-center justify-between hover:border-[#B85D19]/40 hover:bg-[#FAF9F5] transition-all shadow-xs"
                     data-id="{{ $item->id }}"
                     data-label="{{ $item->label }}"
                     data-url="{{ $item->url }}"
                     data-target="{{ $item->target ?? '_self' }}"
                     data-visible="{{ $item->is_visible ? '1' : '0' }}">
                    <div class="flex items-center gap-3.5">
                        <span class="cursor-move text-stone-400 hover:text-stone-700 select-none text-xl leading-none px-1" title="Drag to reorder">⋮⋮</span>
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="text-sm font-bold text-stone-900">{{ $item->label }}</span>
                                <span class="text-xs font-mono text-stone-500 bg-stone-100 px-2 py-0.5 rounded border border-stone-200">{{ $item->url }}</span>
                                @if(($item->target ?? '_self') === '_blank')
                                    <span class="text-[10px] text-stone-400 font-mono" title="Opens in new tab">&#8599; new tab</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2.5">
                        @if($item->is_visible)
                            <span class="admin-badge-success">Visible</span>
                        @else
                            <span class="admin-badge-neutral">Hidden</span>
                        @endif

                        <button type="button" onclick="editItem({{ $item->id }})"
                            class="rounded-lg p-1.5 text-[#B85D19] hover:bg-[#B85D19]/10 transition" title="Edit">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </button>
                        <form method="POST" action="{{ route('admin.navigation.destroy', $item->id) }}" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Delete this navigation item?')"
                                class="rounded-lg p-1.5 text-stone-400 hover:bg-rose-50 hover:text-rose-600 transition" title="Delete">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.133A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.86L5 7m5 5v6m4-6v6m1-10V4a1 1 0 00-1-1h-2a1 1 0 00-1 1v3m-4 0h6"></path>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="py-12 text-center text-xs text-stone-400">
                    <p class="text-sm font-bold text-stone-700">No navigation links added.</p>
                    <p class="mt-1">Click "+ Add Menu Item" to configure header links.</p>
                </div>
            @endforelse
        </div>

        @if($items->count() > 1)
            <div class="mt-6 pt-4 border-t border-[#E5E0D5] flex items-center justify-between">
                <span class="text-xs text-stone-500">Arrange items above and click to save sequence</span>
                <button type="button" onclick="saveOrder()" id="saveOrderBtn" class="admin-btn-secondary text-xs">
                    Save Menu Order
                </button>
            </div>
        @endif
    </div>
</div>

<!-- Modal Dialog -->
<div id="addItemModal" class="fixed inset-0 bg-[#18191B]/60 backdrop-blur-xs hidden items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl p-6 w-full max-w-md shadow-xl border border-[#E5E0D5]">
        <div class="flex items-center justify-between pb-3 border-b border-[#E5E0D5] mb-4">
            <h3 class="text-base font-bold text-[#18191B]" id="modalTitle">Add Navigation Item</h3>
            <button type="button" onclick="closeModal()" class="text-stone-400 hover:text-stone-700 text-lg leading-none">&times;</button>
        </div>

        <form id="itemForm" method="POST" action="{{ route('admin.navigation.store') }}">
            @csrf
            <input type="hidden" name="id" id="itemId">
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-stone-600 mb-1">Menu Label <span class="text-rose-500">*</span></label>
                    <input type="text" name="label" id="itemLabel" required class="admin-input" placeholder="e.g. Projects, Services, Contact">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-stone-600 mb-1">Target URL <span class="text-rose-500">*</span></label>
                    <input type="text" name="url" id="itemUrl" required class="admin-input" placeholder="/#projects, /services or https://...">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-stone-600 mb-1">Window Target</label>
                    <select name="target" id="itemTarget" class="admin-select">
                        <option value="_self">Same Tab (_self)</option>
                        <option value="_blank">New Tab (_blank)</option>
                    </select>
                </div>
                <div class="flex items-center gap-2 pt-2">
                    <input type="checkbox" name="is_visible" value="1" id="itemVisible" checked class="w-4 h-4 rounded text-[#B85D19] focus:ring-[#B85D19] border-[#E5E0D5]">
                    <label for="itemVisible" class="text-xs font-semibold text-stone-800 select-none">Visible in header</label>
                </div>
            </div>
            <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-[#E5E0D5]">
                <button type="button" onclick="closeModal()" class="admin-btn-secondary text-xs">Cancel</button>
                <button type="submit" class="admin-btn-primary text-xs" id="submitBtn">Save Item</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
    const sortableEl = document.getElementById('sortable-list');
    let sortableInstance = null;
    if (sortableEl) {
        sortableInstance = new Sortable(sortableEl, {
            animation: 150,
            handle: '.cursor-move',
            ghostClass: 'bg-stone-100',
        });
    }

    function openAddModal() {
        document.getElementById('modalTitle').textContent = 'Add Navigation Item';
        document.getElementById('itemId').value = '';
        document.getElementById('itemLabel').value = '';
        document.getElementById('itemUrl').value = '';
        document.getElementById('itemTarget').value = '_self';
        document.getElementById('itemVisible').checked = true;
        document.getElementById('itemForm').action = "{{ route('admin.navigation.store') }}";
        const methodInput = document.getElementById('itemForm').querySelector('input[name="_method"]');
        if (methodInput) methodInput.remove();
        const modal = document.getElementById('addItemModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function editItem(id) {
        const itemEl = document.querySelector(`[data-id="${id}"]`);
        if (!itemEl) return;
        document.getElementById('modalTitle').textContent = 'Edit Navigation Item';
        document.getElementById('itemId').value = id;
        document.getElementById('itemLabel').value = itemEl.dataset.label;
        document.getElementById('itemUrl').value = itemEl.dataset.url;
        document.getElementById('itemTarget').value = itemEl.dataset.target || '_self';
        document.getElementById('itemVisible').checked = itemEl.dataset.visible === '1';

        const form = document.getElementById('itemForm');
        form.action = `/admin/navigation/${id}`;
        let methodInput = form.querySelector('input[name="_method"]');
        if (!methodInput) {
            methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'PUT';
            form.appendChild(methodInput);
        } else {
            methodInput.value = 'PUT';
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

    function saveOrder() {
        const items = Array.from(document.querySelectorAll('#sortable-list > div')).map(el => el.dataset.id);
        const btn = document.getElementById('saveOrderBtn');
        if (btn) btn.textContent = 'Saving...';

        fetch("{{ route('admin.navigation.reorder') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ items })
        })
        .then(res => res.json())
        .then(data => {
            if (btn) btn.textContent = 'Saved!';
            setTimeout(() => { if (btn) btn.textContent = 'Save Menu Order'; }, 1800);
        })
        .catch(err => {
            alert('Failed to save order. Please check network connection.');
            if (btn) btn.textContent = 'Save Menu Order';
        });
    }

    document.getElementById('addItemModal').addEventListener('click', function(e) {
        if (e.target === this) closeModal();
    });
</script>
@endsection
