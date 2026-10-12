@extends('admin.layouts.master')

@section('title', 'Footer Widgets')
@section('header', 'Footer Management')

@section('admin-content')
<ul class="flex gap-4 mb-6 border-b border-gray-200">
    <li>
        <a href="{{ route('admin.footer.widgets.index') }}"
            class="border-b-2 border-blue-600 text-blue-600 pb-2 text-sm font-medium">
            Widgets
        </a>
    </li>
    <li>
        <a href="{{ route('admin.footer.links.index') }}"
            class="text-gray-600 pb-2 text-sm font-medium">
            Links
        </a>
    </li>
</ul>

<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-semibold text-gray-900">Footer Widgets</h2>
    <button type="button" onclick="document.getElementById('addWidgetModal').classList.remove('hidden')"
        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
        Add Widget
    </button>
</div>

<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    <table class="w-full">
        <thead>
            <tr class="border-b border-gray-200">
                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase">Title</th>
                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase">Content</th>
                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase">Links</th>
                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase">Status</th>
                <th class="text-right py-3 px-4 text-xs font-semibold text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($widgets as $widget)
                <tr class="border-b border-gray-100">
                    <td class="py-3 px-4 font-medium">{{ $widget->title }}</td>
                    <td class="py-3 px-4 text-sm text-gray-500">{{ Str::limit(strip_tags($widget->content ?? ''), 60) ?: '—' }}</td>
                    <td class="py-3 px-4 text-sm text-gray-500">{{ $widget->links->count() }} links</td>
                    <td class="py-3 px-4">
                        <span class="inline-flex px-2 py-1 text-xs rounded-full {{ $widget->is_enabled ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">
                            {{ $widget->is_enabled ? 'Enabled' : 'Disabled' }}
                        </span>
                    </td>
                    <td class="py-3 px-4 text-right">
                        <button type="button" onclick="editWidget({{ $widget->id }})"
                            class="text-blue-600 hover:text-blue-700 inline-block mr-2">
                            Edit
                        </button>
                        <form method="POST" action="{{ route('admin.footer.widgets.destroy', $widget->id) }}" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Delete this widget?')"
                                class="text-red-600 hover:text-red-700">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center py-8 text-gray-500">No widgets found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div id="addWidgetModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl p-6 w-full max-w-lg">
        <h3 class="text-lg font-semibold mb-4">Add Footer Widget</h3>
        <form id="widgetForm" method="POST" action="{{ route('admin.footer.widgets.store') }}">
            @csrf
            <input type="hidden" name="id" id="widgetId">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                    <input type="text" name="title" id="widgetTitle" class="admin-input">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Content</label>
                    <textarea name="content" id="widgetContent" rows="3" class="admin-textarea"></textarea>
                </div>
                <label class="flex items-center gap-2 text-sm text-gray-700">
                    <input type="checkbox" name="is_enabled" value="1" checked>
                    Enabled
                </label>
            </div>
            <div class="flex justify-end gap-3 mt-6">
                <button type="button" onclick="document.getElementById('addWidgetModal').classList.add('hidden')"
                    class="text-gray-600 hover:text-gray-900 px-4 py-2">Cancel</button>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">Save</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/7/tinymce.min.js"></script>
<script>
function editWidget(id) {
    fetch('/admin/footer/widgets/' + id + '/edit').then(() => {
        const row = document.querySelector(`tr[data-id="${id}"]`);
        const title = row.querySelector('td:first-child').textContent;
        document.getElementById('widgetTitle').value = title;
        document.getElementById('widgetForm').action = '/admin/footer/widgets/' + id;
    });
    document.getElementById('addWidgetModal').classList.remove('hidden');
}
</script>
@endsection
