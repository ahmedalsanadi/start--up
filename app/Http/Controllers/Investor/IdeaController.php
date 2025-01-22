<?php
// app/Http/Controllers/Investor/IdeaController.php
namespace App\Http\Controllers\Investor;

use App\Models\Idea;
use App\Http\Controllers\Controller;
use App\Models\IdeaStage;
use Illuminate\Http\Request;

class IdeaController extends Controller
{
    public function show(Idea $idea)
    {
        // Ensure the idea is related to an announcement owned by the authenticated investor
        if ($idea->announcement->investor_id !== auth()->id()) {
            abort(403);
        }

        $stagesCount = 5; // Total number of stages
        $completedStages = $idea->stages->where('stage_status', true)->count();
        $progressPercentage = ($completedStages / $stagesCount) * 100;

        // Load the idea with its relationships
        $idea->load([
            'categories',
            'entrepreneur',
            'announcement',
            'stages',
        ]);

        return view('investor.ideas.show', compact('idea', 'progressPercentage'));
    }

    public function updateStage(Request $request, Idea $idea)
{
    // Validate the request
    $request->validate([
        'stage' => 'required|in:new,initial_acceptance,under_review,expert_consultation,final_decision'
    ]);

    // Update the idea stage
    $idea->update(['stage' => $request->stage]);

    // Create new stage record
    IdeaStage::create([
        'idea_id' => $idea->id,
        'stage' => $request->stage,
        'stage_status' => true,
        'changed_at' => now()
    ]);

    return redirect()->back()->with('success', 'تم تحديث مرحلة الفكرة بنجاح');
}
}
