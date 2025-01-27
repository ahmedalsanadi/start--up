<?php
namespace App\Http\Controllers\Admin;

use App\Models\Idea;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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

            //redirect back with success message
            return back()->with('success', 'تم تحديث حالة الفكرة بنجاح.');
    }
}


