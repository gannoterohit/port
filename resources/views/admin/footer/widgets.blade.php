@extends('admin.layouts.master')

@section('title', 'Footer Widgets')
@section('header', 'Footer Management')

@section('admin-content')
<div class="space-y-6">

    <!-- Top Navigation Tabs & Banner -->
    <div class="flex gap-4 border-b border-[#E5E0D5]">
        <a href="{{ route('admin.footer.widgets.index') }}"
            class="border-b-2 border-[#B85D19] text-[#B85D19] pb-3 text-sm font-bold flex items-center gap-1.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/></svg>
            Footer Columns / Widgets
        </a>
        <a href="{{ route('admin.footer.links.index') }}"
            class="text-stone-500 hover:text-stone-900 pb-3 text-sm font-medium flex items-center gap-1.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
            Footer Links
        </a>
    </div>

    <div class="flex flex-col gap-4 rounded-2xl border border-[#E5E0D5] bg-gradient-to-br from-white to-[#FAF9F5] p-5 shadow-xs sm:flex-row sm:items-center sm:justify-between sm:p-6">
        <div>
            <div class="flex items-center gap-2">
                <span class="inline-flex h-2 w-2 rounded-full bg-[#B85D19]"></span>
                <p class="text-xs font-mono font-bold uppercase tracking-wider text-[#B85D19]">Footer Layout</p>
            </div>
            <h2 class="mt-1 text-xl font-bold tracking-tight text-stone-900 sm:text-2xl">Footer Widgets &amp; Column Content</h2>
            <p class="mt-1 text-xs text-stone-500 sm:text-sm">Configure multi-column sections, description blurbs, and link groupings rendered in the site footer.</p>
        </div>
        <div class="flex items-center gap-2.5">
            <button type="button" onclick="openAddWidgetModal()" class="admin-btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Add Widget</span>
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

    <!-- Widgets Table Card -->
    <div class="admin-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-stone-700">
                <thead class="border-b border-[#E5E0D5] bg-[#FAF9F5] text-xs font-semibold uppercase tracking-wider text-stone-500">
                    <tr>
                        <th class="px-5 py-3.5">Widget Title</th>
                        <th class="px-5 py-3.5">Content Summary</th>
                        <th class="px-5 py-3.5">Nested Links</th>
                        <th class="px-5 py-3.5">Status</th>
                        <th class="px-5 py-3.5 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E5E0D5]">
                    @forelse($widgets as $widget)
                        <tr class="hover:bg-[#FAF9F5] transition-colors"
                            data-id="{{ $widget->id }}"
                            data-title="{{ $widget->title }}"
                            data-content="{{ $widget->content }}"
                            data-enabled="{{ $widget->is_enabled ? '1' : '0' }}">
                            <td class="px-5 py-4 font-bold text-stone-900">{{ $widget->title }}</td>
                            <td class="px-5 py-4 text-xs text-stone-600 max-w-sm truncate leading-relaxed">
                                {{ Str::limit(strip_tags($widget->content ?? ''), 75) ?: '—' }}
                            </td>
                            <td class="px-5 py-4 text-xs font-medium text-stone-700">
                                <span class="px-2 py-0.5 rounded bg-stone-100 text-stone-700 border border-stone-200 font-mono">
                                    {{ $widget->links->count() }} links
                                </span>
                            </td>
                            <td class="px-5 py-4">
                                @if($widget->is_enabled)
                                    <span class="admin-badge-success">Enabled</span>
                                @else
                                    <span class="admin-badge-neutral">Disabled</span>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <button type="button" onclick="editWidget({{ $widget->id }})"
                                        class="rounded-lg p-1.5 text-[#B85D19] hover:bg-[#B85D19]/10 transition" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </button>
                                    <form method="POST" action="{{ route('admin.footer.widgets.destroy', $widget->id) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Delete this widget? Associated links may become standalone.')"
                                            class="rounded-lg p-1.5 text-stone-400 hover:bg-rose-50 hover:text-rose-600 transition" title="Delete">
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
                            <td colspan="5" class="px-5 py-10 text-center text-xs text-stone-400">
                                No footer widgets created yet. Click "+ Add Widget" to add columns.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Dialog -->
<div id="addWidgetModal" class="fixed inset-0 bg-[#18191B]/60 backdrop-blur-xs hidden items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl p-6 w-full max-w-lg shadow-xl border border-[#E5E0D5]">
        <div class="flex items-center justify-between pb-3 border-b border-[#E5E0D5] mb-4">
            <h3 class="text-base font-bold text-[#18191B]" id="widgetModalTitle">Add Footer Widget</h3>
            <button type="button" onclick="closeWidgetModal()" class="text-stone-400 hover:text-stone-700 text-lg leading-none">&times;</button>
        </div>

        <form id="widgetForm" method="POST" action="{{ route('admin.footer.widgets.store') }}">
            @csrf
            <input type="hidden" name="id" id="widgetId">
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-stone-600 mb-1">Column / Widget Title <span class="text-rose-500">*</span></label>
                    <input type="text" name="title" id="widgetTitle" required class="admin-input" placeholder="e.g. Quick Links, About Me, Resources">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-stone-600 mb-1">Content / Description (Optional)</label>
                    <textarea name="content" id="widgetContent" rows="3" class="admin-textarea" placeholder="Optional paragraph text displayed below title..."></textarea>
                </div>
                <div class="flex items-center gap-2 pt-2">
                    <input type="checkbox" name="is_enabled" value="1" id="widgetEnabled" checked class="w-4 h-4 rounded text-[#B85D19] focus:ring-[#B85D19] border-[#E5E0D5]">
                    <label for="widgetEnabled" class="text-xs font-semibold text-stone-800 select-none">Enabled on live footer</label>
                </div>
            </div>
            <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-[#E5E0D5]">
                <button type="button" onclick="closeWidgetModal()" class="admin-btn-secondary text-xs">Cancel</button>
                <button type="submit" class="admin-btn-primary text-xs">Save Widget</button>
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
    if (methodInput) methodInput.remove();

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

    document.getElementById('widgetModalTitle').textContent = 'Edit Footer Widget';
    document.getElementById('widgetId').value = id;
    document.getElementById('widgetTitle').value = row.dataset.title;
    document.getElementById('widgetContent').value = row.dataset.content;
    document.getElementById('widgetEnabled').checked = row.dataset.enabled === '1';

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

document.getElementById('addWidgetModal').addEventListener('click', function(e) {
    if (e.target === this) closeWidgetModal();
});
</script>
@endsection
