<?php
namespace App\Http\Controllers\Admin;

use App\Models\Idea;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IdeaController extends Controller
{
    public function index()
    {
        $ideas = Idea::with('entrepreneur')->latest()->paginate(10);
        return view('admin.ideas.index', compact('ideas'));
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


