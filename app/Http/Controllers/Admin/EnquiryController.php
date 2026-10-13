<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use App\Models\EnquiryStatusLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnquiryController extends Controller
{
    public function index(Request $request)
    {
        $query = Enquiry::query();

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        if ($request->filled('search')) {
            $query->search($request->search);
        }

        $enquiries = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        return view('admin.enquiries.index', compact('enquiries'));
    }

    public function show(Enquiry $enquiry)
    {
        $enquiry->update(['read_at' => $enquiry->read_at ?? now()]);

        $statusLogs = $enquiry->statusLogs;

        return view('admin.enquiries.show', compact('enquiry', 'statusLogs'));
    }

    public function update(Request $request, Enquiry $enquiry)
    {
        $data = $request->validate([
            'status' => ['required', 'in:new,in_progress,contacted,converted,closed'],
            'internal_notes' => ['nullable', 'string'],
        ]);

        if ($enquiry->status !== $data['status']) {
            EnquiryStatusLog::create([
                'enquiry_id' => $enquiry->id,
                'status' => $data['status'],
                'user_id' => Auth::id(),
                'note' => 'Status changed',
            ]);
        }

        $enquiry->update($data);

        return back()->with('success', 'Enquiry updated successfully.');
    }

    public function addNote(Request $request, Enquiry $enquiry)
    {
        $data = $request->validate([
            'note' => ['required', 'string'],
            'status' => ['nullable', 'in:new,in_progress,contacted,converted,closed'],
        ]);

        if (isset($data['status']) && $enquiry->status !== $data['status']) {
            $enquiry->update(['status' => $data['status']]);

            EnquiryStatusLog::create([
                'enquiry_id' => $enquiry->id,
                'status' => $data['status'],
                'user_id' => Auth::id(),
                'note' => $data['note'],
            ]);
        }

        return back()->with('success', 'Note added successfully.');
    }

    public function destroy(Enquiry $enquiry)
    {
        $enquiry->statusLogs()->delete();
        $enquiry->delete();

        return back()->with('success', 'Enquiry deleted successfully.');
    }

    public function export(Request $request)
    {
        $query = Enquiry::query();

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        if ($request->filled('search')) {
            $query->search($request->search);
        }

        $enquiries = $query->orderBy('created_at', 'desc')->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="enquiries_'.now()->format('Y-m-d').'.csv"',
        ];

        $callback = function () use ($enquiries) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Name', 'Email', 'Phone', 'Subject', 'Message', 'Status', 'Created At']);

            foreach ($enquiries as $enquiry) {
                fputcsv($file, [
                    $enquiry->id,
                    $enquiry->name,
                    $enquiry->email,
                    $enquiry->phone,
                    $enquiry->subject,
                    $enquiry->message,
                    $enquiry->status,
                    $enquiry->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
