<?php

namespace App\Http\Controllers\Admin;

use App\Models\Announcement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminAnnouncementController extends Controller
{
    public function index(Request $request)
    {
        $query = Announcement::with('investor')->latest();

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                    ->orWhereHas('investor', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // Status Filter
        if ($request->filled('status')) {
            $query->where('approval_status', $request->status);
        }

        // Date Range Filter
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $announcements = $query->paginate(6)->withQueryString();

        $total_announcements = Announcement::count();
        $total_pending_announcements = Announcement::where('approval_status', 'pending')->count();
        $total_active_announcements = Announcement::where('approval_status', 'approved')->count();
        $total_rejected_announcements = Announcement::where('approval_status', 'rejected')->count();

        return view('admin.announcements.index', compact(
            'announcements',
            'total_announcements',
            'total_active_announcements',
            'total_pending_announcements',
            'total_rejected_announcements'
        ));
    }

    public function show(Announcement $announcement)
    {
        // The $announcement instance is already resolved by Laravel's route model binding
        $announcement->load(['investor', 'categories']); // Eager load related data

        // Pass the announcement to the view
        return view('admin.announcements.show', compact('announcement'));
    }


    public function updateStatus(Request $request, Announcement $announcement)
    {
        $request->validate([
            'approval_status' => 'required|in:approved,rejected',
            'rejection_reason' => 'nullable|string',
        ]);

        $announcement->update([
            'approval_status' => $request->approval_status,
            'rejection_reason' => $request->rejection_reason,
        ]);

        //redirect back with success message
        return back()->with('success', 'تم تحديث حالة الإعلان بنجاح.');
    }

}
