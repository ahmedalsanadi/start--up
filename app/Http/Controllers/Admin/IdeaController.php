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
        $total_pending = Idea::where('status', 'pending')->withTrashed()->count();
        $total_in_progress = Idea::where('status', 'in-progress')->withTrashed()->count();
        $total_approved = Idea::where('status', 'approved')->withTrashed()->count();
        $total_rejected = Idea::where('status', 'rejected')->withTrashed()->count();
        $total_deleted = Idea::where('status', 'deleted_by_entrepreneur')->withTrashed()->count();
        $total_expired = Idea::where('status', 'expired')->withTrashed()->count();

        return view('admin.ideas.index', compact(
            'ideas',
            'total_ideas',
            'total_pending',
            'total_in_progress',
            'total_approved',
            'total_rejected',
            'total_deleted',
            'total_expired'
        ));
    }

    public function show(Idea $idea)
    {
        // Ensure the idea is retrieved even if it's soft-deleted
        $idea = Idea::withTrashed()->findOrFail($idea->id);

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

            return view('admin.ideas.show', compact('idea'));
        } else {
            // Eager load relationships for traditional ideas or creative ideas without announcements
            $idea->load([
                'entrepreneur',
                'stages',
                'categories',
            ]);

            return view('admin.ideas.show', compact('idea'));
        }
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

        // Check if the idea was approved
        if ($idea->approval_status === 'approved') {
            // 1- Notify the entrepreneur that their idea has been approved
            $this->notifyEntrepreneur($idea);

            // 2- Notify the investor that there is a new idea in their announcement
            $this->notifyInvestor($idea);
        }

        // Redirect back with success message
        return back()->with('success', 'تم تحديث حالة الفكرة بنجاح.');
    }

    /**
     * Notify the entrepreneur that their idea has been approved.
     */
    protected function notifyEntrepreneur(Idea $idea)
    {
        $entrepreneur = $idea->user; // Assuming the entrepreneur is the owner of the idea
        $data = [
            'type' => 'idea_approved',
            'title' => 'تمت الموافقة على فكرتك',
            'message' => 'تمت الموافقة على فكرتك: ' . $idea->title,
            'action_type' => 'idea_approved',
            'action_id' => $idea->id,
            'action_url' => route('entrepreneur.ideas.show', $idea->id), // Link to the idea details
            'initiator_id' => $idea->user_id,
            'initiator_type' => 'entrepreneur',
            'additional_data' => [
                'idea_title' => $idea->title,
            ],
        ];

        app(NotificationService::class)->notify($entrepreneur, $data);
    }

    /**
     * Notify the investor that there is a new idea in their announcement.
     */
    protected function notifyInvestor(Idea $idea)
    {
        $investor = $idea->announcement->user; 
        $data = [
            'type' => 'new_idea_in_announcement',
            'title' => 'فكرة جديدة في إعلانك',
            'message' => 'تمت إضافة فكرة جديدة إلى إعلانك: ' . $idea->title,
            'action_type' => 'new_idea_in_announcement',
            'action_id' => $idea->id,
            'action_url' => route('investor.ideas.show', $idea->id),
            'initiator_id' => $idea->user_id,
            'initiator_type' => 'entrepreneur',
            'additional_data' => [
                'idea_title' => $idea->title,
                'announcement_title' => $idea->announcement->title,
            ],
        ];

        app(NotificationService::class)->notify($investor, $data);
    }
}
