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

        return redirect()->route('admin.ideas.index')->with('success', 'تم تحديث حالة الفكرة بنجاح.');
    }
}
