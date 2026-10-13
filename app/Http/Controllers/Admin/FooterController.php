<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FooterLink;
use App\Models\FooterWidget;
use Illuminate\Http\Request;

class FooterController extends Controller
{
    public function widgetsIndex()
    {
        $widgets = FooterWidget::orderBy('display_order')->get();

        return view('admin.footer.widgets', compact('widgets'));
    }

    public function widgetsStore(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['nullable', 'string'],
            'is_enabled' => ['boolean'],
        ]);

        $data['display_order'] = FooterWidget::max('display_order') + 1;
        $data['is_enabled'] = $request->boolean('is_enabled', true);

        FooterWidget::create($data);

        return back()->with('success', 'Footer widget created successfully.');
    }

    public function widgetsUpdate(Request $request, $id)
    {
        $widget = FooterWidget::findOrFail($id);

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['nullable', 'string'],
            'is_enabled' => ['boolean'],
        ]);

        $data['is_enabled'] = $request->boolean('is_enabled');

        $widget->update($data);

        return back()->with('success', 'Footer widget updated successfully.');
    }

    public function widgetsDestroy($id)
    {
        $widget = FooterWidget::findOrFail($id);
        $widget->delete();

        return back()->with('success', 'Footer widget deleted successfully.');
    }

    public function linksIndex()
    {
        $widgets = FooterWidget::orderBy('display_order')->get();
        $links = FooterLink::whereNull('footer_widget_id')->orderBy('display_order')->get();

        return view('admin.footer.links', compact('widgets', 'links'));
    }

    public function linksStore(Request $request)
    {
        $data = $request->validate([
            'label' => ['required', 'string', 'max:255'],
            'url' => ['required', 'string', 'max:255'],
            'target' => ['nullable', 'in:_self,_blank'],
            'footer_widget_id' => ['nullable', 'exists:footer_widgets,id'],
            'display_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $data['target'] = $data['target'] ?? '_self';
        $data['display_order'] = $data['display_order'] ?? FooterLink::max('display_order') + 1;

        FooterLink::create($data);

        return back()->with('success', 'Footer link created successfully.');
    }

    public function linksUpdate(Request $request, $id)
    {
        $link = FooterLink::findOrFail($id);

        $data = $request->validate([
            'label' => ['required', 'string', 'max:255'],
            'url' => ['required', 'string', 'max:255'],
            'target' => ['nullable', 'in:_self,_blank'],
            'footer_widget_id' => ['nullable', 'exists:footer_widgets,id'],
            'display_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $link->update($data);

        return back()->with('success', 'Footer link updated successfully.');
    }

    public function linksDestroy($id)
    {
        FooterLink::findOrFail($id)->delete();

        return back()->with('success', 'Footer link deleted successfully.');
    }
}
