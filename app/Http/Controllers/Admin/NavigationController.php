<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NavigationItem;
use Illuminate\Http\Request;

class NavigationController extends Controller
{
    public function index()
    {
        $items = NavigationItem::orderBy('display_order')->get();

        return view('admin.navigation.index', compact('items'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'label' => ['required', 'string', 'max:255'],
            'url' => ['required', 'string', 'max:255'],
            'target' => ['nullable', 'in:_self,_blank'],
            'is_visible' => ['boolean'],
        ]);

        $data['display_order'] = NavigationItem::max('display_order') + 1;
        $data['nav_type'] = 'header';
        $data['is_visible'] = $request->boolean('is_visible', true);
        $data['target'] = $data['target'] ?? '_self';

        NavigationItem::create($data);

        return back()->with('success', 'Navigation item added successfully.');
    }

    public function update(Request $request, $id)
    {
        $item = NavigationItem::findOrFail($id);

        $data = $request->validate([
            'label' => ['required', 'string', 'max:255'],
            'url' => ['required', 'string', 'max:255'],
            'target' => ['nullable', 'in:_self,_blank'],
            'is_visible' => ['boolean'],
        ]);

        $data['is_visible'] = $request->boolean('is_visible');

        $item->update($data);

        return back()->with('success', 'Navigation item updated successfully.');
    }

    public function destroy($id)
    {
        NavigationItem::findOrFail($id)->delete();

        return back()->with('success', 'Navigation item deleted successfully.');
    }

    public function reorder(Request $request)
    {
        $order = $request->input('order', []);

        foreach ($order as $id => $displayOrder) {
            NavigationItem::where('id', $id)->update(['display_order' => $displayOrder]);
        }

        return response()->json(['success' => true]);
    }
}
