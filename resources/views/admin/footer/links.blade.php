@extends('admin.layouts.master')

@section('title', 'Footer Links')
@section('header', 'Footer Links')

@section('admin-content')
<ul class="flex gap-4 mb-6 border-b border-gray-200">
    <li>
        <a href="{{ route('admin.footer.widgets.index') }}" class="text-gray-600 pb-2 text-sm font-medium">
            Widgets
        </a>
    </li>
    <li>
        <a href="{{ route('admin.footer.links.index') }}"
            class="border-b-2 border-blue-600 text-blue-600 pb-2 text-sm font-medium">
            Links
        </a>
    </li>
</ul>

<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-semibold text-gray-900">Footer Links</h2>
    <button type="button" onclick="document.getElementById('linkModal').classList.remove('hidden')"
        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
        Add Link
    </button>
</div>

<div class="overflow-x-auto">
    <table class="w-full">
        <thead>
            <tr class="border-b border-gray-200">
                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase">Label</th>
                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase">URL</th>
                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase">Widget</th>
                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase">Order</th>
                <th class="text-right py-3 px-4 text-xs font-semibold text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($links as $link)
                <tr class="border-b border-gray-100" data-id="{{ $link->id }}">
                    <td class="py-3 px-4">{{ $link->label }}</td>
                    <td class="py-3 px-4 text-sm text-gray-500">{{ $link->url }}</td>
                    <td class="py-3 px-4 text-sm text-gray-500">{{ $link->widget ? $link->widget->title : 'Orphaned' }}</td>
                    <td class="py-3 px-4">{{ $link->display_order }}</td>
                    <td class="py-3 px-4 text-right">
                        <a href="#" onclick="editLink({{ $link->id }})" class="text-blue-600 hover:text-blue-700">Edit</a>
                        <form method="POST" action="{{ route('admin.footer.links.destroy', $link->id) }}" class="inline ml-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Delete this link?')"
                                class="text-red-600 hover:text-red-700">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center py-8 text-gray-500">No links found.</td>
                </tr>
            @endforelse

            @foreach($widgets as $widget)
                @foreach($widget->links as $link)
                    <tr class="border-b border-gray-100" data-id="{{ $link->id }}">
                        <td class="py-3 px-4">{{ $link->label }}</td>
                        <td class="py-3 px-4 text-sm text-gray-500">{{ $link->url }}</td>
                        <td class="py-3 px-4 text-sm text-gray-500">{{ $widget->title }}</td>
                        <td class="py-3 px-4">{{ $link->display_order }}</td>
                        <td class="py-3 px-4 text-right">
                            <a href="#" onclick="editLink({{ $link->id }})" class="text-blue-600 hover:text-blue-700">Edit</a>
                            <form method="POST" action="{{ route('admin.footer.links.destroy', $link->id) }}" class="inline ml-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Delete this link?')"
                                    class="text-red-600 hover:text-red-700">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</div>

<div id="linkModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl p-6 w-full max-w-lg">
        <h3 class="text-lg font-semibold mb-4" id="linkModalTitle">Add Footer Link</h3>
        <form id="linkForm" method="POST" action="{{ route('admin.footer.links.store') }}">
            @csrf
            <input type="hidden" name="id" id="linkId">
            <input type="hidden" name="_method" id="linkMethod" value="POST">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Label *</label>
                    <input type="text" name="label" id="linkLabel" required class="admin-input">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">URL *</label>
                    <input type="text" name="url" id="linkUrl" required class="admin-input" placeholder="/about">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Widget</label>
                    <select name="footer_widget_id" id="linkWidget" class="admin-input">
                        <option value="">None (orphaned)</option>
                        @foreach($widgets as $widget)
                            <option value="{{ $widget->id }}">{{ $widget->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Target</label>
                    <select name="target" id="linkTarget" class="admin-input">
                        <option value="_self">Same Window</option>
                        <option value="_blank">New Window</option>
                    </select>
                </div>
            </div>
            <div class="flex justify-end gap-3 mt-6">
                <button type="button" onclick="document.getElementById('linkModal').classList.add('hidden')"
                    class="text-gray-600 hover:text-gray-900 px-4 py-2">Cancel</button>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">Save</button>
            </div>
        </form>
    </div>
</div>

<script>
function editLink(id) {
    const row = document.querySelector(`tr[data-id="${id}"]`);
    document.getElementById('linkModalTitle').textContent = 'Edit Footer Link';
    document.getElementById('linkForm').action = '/admin/footer/links/' + id;
    document.getElementById('linkMethod').value = 'PUT';
    document.getElementById('linkModal').classList.remove('hidden');
}
</script>
@endsection
