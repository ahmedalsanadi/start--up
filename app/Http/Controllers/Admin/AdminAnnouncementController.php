<?php

namespace App\Http\Controllers\Admin;

use App\Models\Announcement;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminAnnouncementController extends Controller
{
    public function index(Request $request)
    {
        $query = Announcement::withTrashed()->with('investor')
        ->orderBy('created_at', 'desc')
        ->orderBy('updated_at', 'desc');


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
            $query->where('status', $request->status);
        }

        // Approval Status Filter
        if ($request->filled('approval_status')) {
            $query->where('approval_status', $request->approval_status);
        }

        // Date Range Filter
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $announcements = $query->paginate(6)->withQueryString();

        $total_announcements = Announcement::withTrashed()->count();
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

        // Fetch the announcement, including soft-deleted ones
        $announcement = Announcement::withTrashed()
            ->with([
                'investor',
                'categories',
                'ideas' => function ($query) {
                    $query->withTrashed(); // Include soft-deleted ideas
                }
            ])->findOrFail($announcement->id);

        return view('admin.announcements.show', compact('announcement'));

    }


    public function updateStatus(Request $request, Announcement $announcement)
    {
        $request->validate([
            'approval_status' => 'required|in:approved,rejected',
            'rejection_reason' => 'nullable|string',
        ]);

        // Update the announcement status
        $announcement->update([
            'approval_status' => $request->approval_status,
            'rejection_reason' => $request->rejection_reason,
        ]);

        // Notify the investor about the status change
        if ($request->approval_status === 'approved') {
            // Notify the investor that their announcement has been approved
            app(NotificationService::class)->notify($announcement->investor, [
                'type' => 'announcement_approved',
                'title' => 'تمت الموافقة على الإعلان',
                'message' => 'تمت الموافقة على إعلانك: ' . $announcement->description,
                'action_type' => 'announcement_approved',
                'action_id' => $announcement->id,
                'action_url' => route('investor.announcements.show', $announcement->id),
                'initiator_id' => auth()->id(),
                'initiator_type' => 'admin',
            ]);
        } elseif ($request->approval_status === 'rejected') {
            // Notify the investor that their announcement has been rejected
            app(NotificationService::class)->notify($announcement->investor, [
                'type' => 'announcement_rejected',
                'title' => 'تم رفض الإعلان',
                'message' => 'تم رفض إعلانك: ' . $announcement->description . ($request->rejection_reason ? ' بسبب: ' . $request->rejection_reason : ''),
                'action_type' => 'announcement_rejected',
                'action_id' => $announcement->id,
                'action_url' => route('investor.announcements.show', $announcement->id),
                'initiator_id' => auth()->id(),
                'initiator_type' => 'admin',
            ]);
        }

        // Redirect back with success message
        return back()->with('success', 'تم تحديث حالة الإعلان بنجاح.');
    }

}
