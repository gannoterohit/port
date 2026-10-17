@extends('admin.layouts.master')

@section('title', 'Footer Links')
@section('header', 'Footer Links')

@section('admin-content')
<div class="flex gap-4 mb-6 border-b border-[#E5E1D5]">
    <a href="{{ route('admin.footer.widgets.index') }}"
        class="text-stone-500 hover:text-stone-900 pb-3 text-sm font-medium">
        Footer Widgets
    </a>
    <a href="{{ route('admin.footer.links.index') }}"
        class="border-b-2 border-[#B85D19] text-[#B85D19] pb-3 text-sm font-bold">
        Footer Links
    </a>
</div>

<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
    <div>
        <h2 class="text-xl font-bold text-stone-900">Footer Links</h2>
        <p class="text-xs text-stone-500 mt-0.5">Manage URLs grouped under footer widgets or standalone links.</p>
    </div>
    <button type="button" onclick="openAddLinkModal()" class="admin-btn-primary">
        + Add Link
    </button>
</div>

<div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm">
    <table class="w-full">
        <thead>
            <tr class="border-b border-gray-200 bg-gray-50">
                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase">Label</th>
                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase">URL</th>
                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase">Widget</th>
                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase">Target</th>
                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase">Order</th>
                <th class="text-right py-3 px-4 text-xs font-semibold text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @php
                $allLinks = \App\Models\FooterLink::with('widget')->orderBy('display_order')->get();
            @endphp
            @forelse($allLinks as $link)
                <tr class="hover:bg-gray-50 transition-colors"
                    data-id="{{ $link->id }}"
                    data-label="{{ $link->label }}"
                    data-url="{{ $link->url }}"
                    data-widget="{{ $link->footer_widget_id }}"
                    data-target="{{ $link->target ?? '_self' }}"
                    data-order="{{ $link->display_order }}">
                    <td class="py-3 px-4 font-semibold text-gray-900">{{ $link->label }}</td>
                    <td class="py-3 px-4 text-sm text-gray-500 font-mono">{{ $link->url }}</td>
                    <td class="py-3 px-4 text-sm text-gray-600">
                        @if($link->widget)
                            <span class="inline-flex px-2 py-0.5 rounded text-xs bg-emerald-50 text-emerald-800 font-medium">
                                {{ $link->widget->title }}
                            </span>
                        @else
                            <span class="text-gray-400 text-xs italic">Standalone</span>
                        @endif
                    </td>
                    <td class="py-3 px-4 text-xs text-gray-500 font-mono">{{ $link->target ?? '_self' }}</td>
                    <td class="py-3 px-4 text-sm text-gray-500">{{ $link->display_order }}</td>
                    <td class="py-3 px-4 text-right">
                        <div class="flex justify-end items-center gap-2">
                            <button type="button" onclick="editLink({{ $link->id }})"
                                class="text-emerald-700 hover:text-emerald-800 p-1" title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </button>
                            <form method="POST" action="{{ route('admin.footer.links.destroy', $link->id) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Delete this link?')"
                                    class="text-red-600 hover:text-red-700 p-1" title="Delete">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.133A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.86L5 7m5 5v6m4-6v6m1-10V4a1 1 0 00-1-1h-2a1 1 0 00-1 1v3m-4 0h6"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center py-8 text-gray-500">No footer links found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Modal -->
<div id="linkModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl p-6 w-full max-w-lg shadow-2xl border border-gray-100">
        <h3 class="text-lg font-bold text-gray-900 mb-4" id="linkModalTitle">Add Footer Link</h3>
        <form id="linkForm" method="POST" action="{{ route('admin.footer.links.store') }}">
            @csrf
            <input type="hidden" name="id" id="linkId">
            <input type="hidden" name="_method" id="linkMethod" value="POST">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Label *</label>
                    <input type="text" name="label" id="linkLabel" required class="admin-input" placeholder="e.g. Privacy Policy">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">URL *</label>
                    <input type="text" name="url" id="linkUrl" required class="admin-input" placeholder="/privacy-policy or https://...">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Widget / Column</label>
                    <select name="footer_widget_id" id="linkWidget" class="admin-input">
                        <option value="">None (Standalone)</option>
                        @foreach($widgets as $widget)
                            <option value="{{ $widget->id }}">{{ $widget->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Target</label>
                    <select name="target" id="linkTarget" class="admin-input">
                        <option value="_self">Same Window (_self)</option>
                        <option value="_blank">New Window (_blank)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Display Order</label>
                    <input type="number" name="display_order" id="linkOrder" class="admin-input" placeholder="0">
                </div>
            </div>
            <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-[#E5E1D5]">
                <button type="button" onclick="closeLinkModal()" class="admin-btn-secondary text-xs">Cancel</button>
                <button type="submit" class="admin-btn-primary">
                    Save Link
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openAddLinkModal() {
    document.getElementById('linkModalTitle').textContent = 'Add Footer Link';
    document.getElementById('linkId').value = '';
    document.getElementById('linkLabel').value = '';
    document.getElementById('linkUrl').value = '';
    document.getElementById('linkWidget').value = '';
    document.getElementById('linkTarget').value = '_self';
    document.getElementById('linkOrder').value = '';
    document.getElementById('linkForm').action = '{{ route('admin.footer.links.store') }}';
    document.getElementById('linkMethod').value = 'POST';

    const modal = document.getElementById('linkModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeLinkModal() {
    const modal = document.getElementById('linkModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

function editLink(id) {
    const row = document.querySelector(`tr[data-id="${id}"]`);
    if (!row) return;

    document.getElementById('linkModalTitle').textContent = 'Edit Footer Link';
    document.getElementById('linkId').value = id;
    document.getElementById('linkLabel').value = row.dataset.label || '';
    document.getElementById('linkUrl').value = row.dataset.url || '';
    document.getElementById('linkWidget').value = row.dataset.widget || '';
    document.getElementById('linkTarget').value = row.dataset.target || '_self';
    document.getElementById('linkOrder').value = row.dataset.order || '0';

    document.getElementById('linkForm').action = '{{ url('admin/footer/links') }}/' + id;
    document.getElementById('linkMethod').value = 'PUT';

    const modal = document.getElementById('linkModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}
</script>
@endsection

