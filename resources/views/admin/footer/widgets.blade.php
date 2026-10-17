@extends('admin.layouts.master')

@section('title', 'Footer Widgets')
@section('header', 'Footer Management')

@section('admin-content')
<div class="flex gap-4 mb-6 border-b border-[#E5E1D5]">
    <a href="{{ route('admin.footer.widgets.index') }}"
        class="border-b-2 border-[#B85D19] text-[#B85D19] pb-3 text-sm font-bold">
        Footer Widgets
    </a>
    <a href="{{ route('admin.footer.links.index') }}"
        class="text-stone-500 hover:text-stone-900 pb-3 text-sm font-medium">
        Footer Links
    </a>
</div>

<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
    <div>
        <h2 class="text-xl font-bold text-stone-900">Footer Widgets</h2>
        <p class="text-xs text-stone-500 mt-0.5">Manage columns and text sections displayed in the website footer.</p>
    </div>
    <button type="button" onclick="openAddWidgetModal()" class="admin-btn-primary">
        + Add Widget
    </button>
</div>

<div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm">
    <table class="w-full">
        <thead>
            <tr class="border-b border-gray-200 bg-gray-50">
                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase">Title</th>
                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase">Content</th>
                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase">Links</th>
                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase">Status</th>
                <th class="text-right py-3 px-4 text-xs font-semibold text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($widgets as $widget)
                <tr class="hover:bg-gray-50 transition-colors"
                    data-id="{{ $widget->id }}"
                    data-title="{{ $widget->title }}"
                    data-content="{{ $widget->content }}"
                    data-enabled="{{ $widget->is_enabled ? '1' : '0' }}">
                    <td class="py-3 px-4 font-semibold text-gray-900">{{ $widget->title }}</td>
                    <td class="py-3 px-4 text-sm text-gray-500 max-w-xs truncate">{{ Str::limit(strip_tags($widget->content ?? ''), 60) ?: '—' }}</td>
                    <td class="py-3 px-4 text-sm text-gray-500">{{ $widget->links->count() }} links</td>
                    <td class="py-3 px-4">
                        <span class="inline-flex px-2.5 py-1 text-xs rounded-full font-medium {{ $widget->is_enabled ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">
                            {{ $widget->is_enabled ? 'Enabled' : 'Disabled' }}
                        </span>
                    </td>
                    <td class="py-3 px-4 text-right">
                        <div class="flex justify-end items-center gap-2">
                            <button type="button" onclick="editWidget({{ $widget->id }})"
                                class="text-emerald-700 hover:text-emerald-800 p-1" title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </button>
                            <form method="POST" action="{{ route('admin.footer.widgets.destroy', $widget->id) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Delete this widget? Associated links may be unassigned.')"
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
                    <td colspan="5" class="text-center py-8 text-gray-500">No footer widgets found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Modal -->
<div id="addWidgetModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl p-6 w-full max-w-lg shadow-2xl border border-gray-100">
        <h3 class="text-lg font-bold text-gray-900 mb-4" id="widgetModalTitle">Add Footer Widget</h3>
        <form id="widgetForm" method="POST" action="{{ route('admin.footer.widgets.store') }}">
            @csrf
            <input type="hidden" name="id" id="widgetId">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Title *</label>
                    <input type="text" name="title" id="widgetTitle" required class="admin-input" placeholder="e.g. Quick Links or About">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Content / Description</label>
                    <textarea name="content" id="widgetContent" rows="3" class="admin-textarea" placeholder="Optional text or details..."></textarea>
                </div>
                <div class="flex items-center gap-2 pt-2">
                    <input type="checkbox" name="is_enabled" value="1" id="widgetEnabled" checked class="rounded border-gray-300 text-emerald-700 focus:ring-emerald-700">
                    <label for="widgetEnabled" class="text-sm text-gray-700 select-none">Enabled</label>
                </div>
            </div>
            <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-[#E5E1D5]">
                <button type="button" onclick="closeWidgetModal()" class="admin-btn-secondary text-xs">Cancel</button>
                <button type="submit" class="admin-btn-primary">
                    Save Widget
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openAddWidgetModal() {
    document.getElementById('widgetModalTitle').textContent = 'Add Footer Widget';
    document.getElementById('widgetId').value = '';
    document.getElementById('widgetTitle').value = '';
    document.getElementById('widgetContent').value = '';
    document.getElementById('widgetEnabled').checked = true;

    const form = document.getElementById('widgetForm');
    form.action = '{{ route('admin.footer.widgets.store') }}';
    const methodInput = form.querySelector('input[name="_method"]');
    if (methodInput) {
        methodInput.remove();
    }

    const modal = document.getElementById('addWidgetModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeWidgetModal() {
    const modal = document.getElementById('addWidgetModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

function editWidget(id) {
    const row = document.querySelector(`tr[data-id="${id}"]`);
    if (!row) return;

    const title = row.dataset.title;
    const content = row.dataset.content;
    const enabled = row.dataset.enabled === '1';

    document.getElementById('widgetModalTitle').textContent = 'Edit Footer Widget';
    document.getElementById('widgetId').value = id;
    document.getElementById('widgetTitle').value = title;
    document.getElementById('widgetContent').value = content;
    document.getElementById('widgetEnabled').checked = enabled;

    const form = document.getElementById('widgetForm');
    form.action = '{{ url('admin/footer/widgets') }}/' + id;
    let methodInput = form.querySelector('input[name="_method"]');
    if (!methodInput) {
        methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        form.appendChild(methodInput);
    }
    methodInput.value = 'PUT';

    const modal = document.getElementById('addWidgetModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}
</script>
@endsection

