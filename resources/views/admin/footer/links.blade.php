@extends('admin.layouts.master')

@section('title', 'Footer Links')
@section('header', 'Footer Management')

@section('admin-content')
<div class="space-y-6">

    <!-- Top Navigation Tabs & Banner -->
    <div class="flex gap-4 border-b border-[#E5E0D5]">
        <a href="{{ route('admin.footer.widgets.index') }}"
            class="text-stone-500 hover:text-stone-900 pb-3 text-sm font-medium flex items-center gap-1.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/></svg>
            Footer Columns / Widgets
        </a>
        <a href="{{ route('admin.footer.links.index') }}"
            class="border-b-2 border-[#B85D19] text-[#B85D19] pb-3 text-sm font-bold flex items-center gap-1.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
            Footer Links
        </a>
    </div>

    <div class="flex flex-col gap-4 rounded-2xl border border-[#E5E0D5] bg-gradient-to-br from-white to-[#FAF9F5] p-5 shadow-xs sm:flex-row sm:items-center sm:justify-between sm:p-6">
        <div>
            <div class="flex items-center gap-2">
                <span class="inline-flex h-2 w-2 rounded-full bg-[#B85D19]"></span>
                <p class="text-xs font-mono font-bold uppercase tracking-wider text-[#B85D19]">Footer Hyperlinks</p>
            </div>
            <h2 class="mt-1 text-xl font-bold tracking-tight text-stone-900 sm:text-2xl">Footer Links Catalog</h2>
            <p class="mt-1 text-xs text-stone-500 sm:text-sm">Manage URLs categorized under footer widgets or standalone bottom links.</p>
        </div>
        <div class="flex items-center gap-2.5">
            <button type="button" onclick="openAddLinkModal()" class="admin-btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Add Link</span>
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

    <!-- Links Table Card -->
    <div class="admin-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-stone-700">
                <thead class="border-b border-[#E5E0D5] bg-[#FAF9F5] text-xs font-semibold uppercase tracking-wider text-stone-500">
                    <tr>
                        <th class="px-5 py-3.5">Label</th>
                        <th class="px-5 py-3.5">Destination URL</th>
                        <th class="px-5 py-3.5">Assigned Widget</th>
                        <th class="px-5 py-3.5">Target</th>
                        <th class="px-5 py-3.5">Order</th>
                        <th class="px-5 py-3.5 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E5E0D5]">
                    @php
                        $allLinks = \App\Models\FooterLink::with('widget')->orderBy('display_order')->get();
                    @endphp
                    @forelse($allLinks as $link)
                        <tr class="hover:bg-[#FAF9F5] transition-colors"
                            data-id="{{ $link->id }}"
                            data-label="{{ $link->label }}"
                            data-url="{{ $link->url }}"
                            data-widget="{{ $link->footer_widget_id }}"
                            data-target="{{ $link->target ?? '_self' }}"
                            data-order="{{ $link->display_order }}">
                            <td class="px-5 py-4 font-bold text-stone-900">{{ $link->label }}</td>
                            <td class="px-5 py-4 text-xs text-stone-600 font-mono">
                                <a href="{{ $link->url }}" target="_blank" class="hover:text-[#B85D19] hover:underline flex items-center gap-1">
                                    {{ $link->url }}
                                </a>
                            </td>
                            <td class="px-5 py-4 text-xs">
                                @if($link->widget)
                                    <span class="px-2.5 py-1 rounded-full font-semibold bg-[#B85D19]/10 text-[#B85D19] border border-[#B85D19]/20">
                                        {{ $link->widget->title }}
                                    </span>
                                @else
                                    <span class="text-stone-400 italic">Standalone</span>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-xs font-mono text-stone-500">{{ $link->target ?? '_self' }}</td>
                            <td class="px-5 py-4 text-xs font-mono text-stone-500">#{{ $link->display_order }}</td>
                            <td class="px-5 py-4 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <button type="button" onclick="editLink({{ $link->id }})"
                                        class="rounded-lg p-1.5 text-[#B85D19] hover:bg-[#B85D19]/10 transition" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </button>
                                    <form method="POST" action="{{ route('admin.footer.links.destroy', $link->id) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Delete this link?')"
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
                            <td colspan="6" class="px-5 py-10 text-center text-xs text-stone-400">
                                No footer links found. Click "+ Add Link" to create one.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Dialog -->
<div id="linkModal" class="fixed inset-0 bg-[#18191B]/60 backdrop-blur-xs hidden items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl p-6 w-full max-w-lg shadow-xl border border-[#E5E0D5]">
        <div class="flex items-center justify-between pb-3 border-b border-[#E5E0D5] mb-4">
            <h3 class="text-base font-bold text-[#18191B]" id="linkModalTitle">Add Footer Link</h3>
            <button type="button" onclick="closeLinkModal()" class="text-stone-400 hover:text-stone-700 text-lg leading-none">&times;</button>
        </div>

        <form id="linkForm" method="POST" action="{{ route('admin.footer.links.store') }}">
            @csrf
            <input type="hidden" name="id" id="linkId">
            <input type="hidden" name="_method" id="linkMethod" value="POST">
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-stone-600 mb-1">Link Label <span class="text-rose-500">*</span></label>
                    <input type="text" name="label" id="linkLabel" required class="admin-input" placeholder="e.g. Privacy Policy, Github, Contact">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-stone-600 mb-1">Target URL <span class="text-rose-500">*</span></label>
                    <input type="text" name="url" id="linkUrl" required class="admin-input" placeholder="/privacy-policy, https://github.com/...">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-stone-600 mb-1">Assign to Column / Widget</label>
                    <select name="footer_widget_id" id="linkWidget" class="admin-select">
                        <option value="">None (Standalone)</option>
                        @foreach($widgets as $widget)
                            <option value="{{ $widget->id }}">{{ $widget->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-stone-600 mb-1">Window Target</label>
                    <select name="target" id="linkTarget" class="admin-select">
                        <option value="_self">Same Window (_self)</option>
                        <option value="_blank">New Window (_blank)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-stone-600 mb-1">Display Order</label>
                    <input type="number" name="display_order" id="linkOrder" class="admin-input w-32" placeholder="0" min="0">
                </div>
            </div>
            <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-[#E5E0D5]">
                <button type="button" onclick="closeLinkModal()" class="admin-btn-secondary text-xs">Cancel</button>
                <button type="submit" class="admin-btn-primary text-xs">Save Link</button>
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
    document.getElementById('linkOrder').value = '0';
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

document.getElementById('linkModal').addEventListener('click', function(e) {
    if (e.target === this) closeLinkModal();
});
</script>
@endsection
