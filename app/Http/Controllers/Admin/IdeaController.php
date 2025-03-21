<?php

namespace App\Http\Controllers\Admin;

use App\Models\Idea;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Services\NotificationService;

class IdeaController extends Controller
{
    public function index(Request $request)
    {
        // Include trashed records in the query for Idea, but not for entrepreneur
        $query = Idea::withTrashed()
            ->with('entrepreneur')
            ->orderBy('created_at', 'desc') // Primary sort by created_at
            ->orderBy('updated_at', 'desc'); // Secondary sort by updated_at

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhereHas('entrepreneur', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%"); // Do not include trashed entrepreneurs in search
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

        $ideas = $query->paginate(6)->withQueryString();

        // Counts for stats cards
        $total_ideas = Idea::withTrashed()->count(); // Include trashed records in total count
        $total_pending = Idea::where('approval_status', 'pending')->count();
        $total_approved = Idea::where('approval_status', 'approved')->count();
        $total_rejected = Idea::where('approval_status', 'rejected')->withTrashed()->count();



        return view('admin.ideas.index', compact(
            'ideas',
            'total_ideas',
            'total_pending',
            'total_approved',
            'total_rejected',
        ));
    }

    public function show($id)
    {
        // Ensure the idea is retrieved even if it's soft-deleted
        $idea = Idea::withTrashed()->findOrFail($id);

        if ($idea->idea_type == 'creative' && $idea->announcement_id != null) {
            // Eager load relationships for creative ideas with announcements
            $idea->load([
                'entrepreneur',
                'stages',
                'categories',
                'announcement' => function ($query) {
                    $query->withTrashed(); // Include soft-deleted announcements
                },
            ]);
        } else {
            // Eager load relationships for traditional ideas or creative ideas without announcements
            $idea->load([
                'entrepreneur',
                'stages',
                'categories',
            ]);
        }

        return view('admin.ideas.show', compact('idea'));
    }


    public function updateStatus(Request $request, Idea $idea)
    {
        $request->validate([
            'approval_status' => 'required|in:approved,rejected',
            'rejection_reason' => 'nullable|string',
        ]);

        $idea->update([
            'approval_status' => $request->approval_status,
            'rejection_reason' => $request->rejection_reason,
        ]);

        $notificationService = app(NotificationService::class);

        if ($idea->approval_status === 'approved') {
            // 1- Notify the entrepreneur that their idea has been approved
            $notificationService->notify($idea->entrepreneur, [
                'type' => 'idea_approved',
                'title' => 'فكرة معتمدة',
                'message' => 'تمت الموافقة على فكرتك بنجاح.',
                'action_type' => 'view_idea',
                'action_id' => $idea->id,
                'action_url' => route('entrepreneur.ideas.show', $idea->id),
                'initiator_id' => auth()->id(),
                'initiator_type' => 'admin',
            ]);

            if ($idea->announcement_id != null) {
                $announcementOwner = $idea->announcement->investor; // Get the investor
                if ($announcementOwner) {
                    $notificationService->notify($announcementOwner, [
                        'type' => 'new_idea_announcement',
                        'title' => 'فكرة جديدة',
                        'message' => 'تمت إضافة فكرة جديدة إلى إعلانك.',
                        'action_type' => 'view_announcement',
                        'action_id' => $idea->announcement_id,
                        'action_url' => route('investor.announcements.show', $idea->announcement_id),
                        'initiator_id' => $idea->user_id,
                        'initiator_type' => 'entrepreneur',
                    ]);
                } else {
                    \Log::error('Investor not found for Announcement ID: ' . $idea->announcement_id);
                }
            }

        } elseif ($idea->approval_status === 'rejected') {
            // 3- Notify the entrepreneur that their idea has been rejected
            $notificationService->notify($idea->entrepreneur, [
                'type' => 'idea_rejected',
                'title' => 'فكرة مرفوضة',
                'message' => 'تم رفض فكرتك. السبب: ' . $idea->rejection_reason,
                'action_type' => 'view_idea',
                'action_id' => $idea->id,
                'action_url' => route('entrepreneur.ideas.show', $idea->id),
                'initiator_id' => auth()->id(),
                'initiator_type' => 'admin',
            ]);
        }

        return back()->with('success', 'تم تحديث حالة الفكرة بنجاح.');
    }


}
