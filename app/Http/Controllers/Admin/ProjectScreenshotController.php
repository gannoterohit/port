<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProjectScreenshot;
use App\Traits\HandlesFileUploads;
use Illuminate\Http\Request;

class ProjectScreenshotController extends Controller
{
    use HandlesFileUploads;

    public function destroy(ProjectScreenshot $screenshot)
    {
        $this->deleteFile($screenshot->image);
        $screenshot->delete();

        return back()->with('success', 'Screenshot deleted successfully.');
    }

    public function reorder(Request $request)
    {
        $order = $request->input('order', []);

        foreach ($order as $id => $displayOrder) {
            ProjectScreenshot::where('id', $id)->update(['display_order' => $displayOrder]);
        }

        return response()->json(['success' => true]);
    }
}
