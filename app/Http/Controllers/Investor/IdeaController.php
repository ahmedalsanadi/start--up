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
        //ensure the idea has status pending or approved
        if ($idea->announcement->investor_id !== auth()->id() || !in_array($idea->status, ['pending', 'approved'])) {
            abort(403);
        }
        // dd($idea->status);

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

    public function rejectIdea(Request $request, Idea $idea)
    {
        // Ensure the idea is related to an announcement owned by the authenticated investor
        // Ensure the idea has status pending or approved
        if ($idea->announcement->investor_id !== auth()->id() || !in_array($idea->status, ['pending', 'approved'])) {
            abort(403);
        }

        // Update the idea status to 'rejected' and set is_reusable to true
        $idea->update([
            'status' => 'rejected',
            'is_reusable' => true,
        ]);


        // TODO Notify the entrepreneur that their idea has been rejected




        return redirect()->route('investor.announcements.show', $idea->announcement)
            ->with('success', 'تم رفض الفكرة بنجاح.');
    }


    public function approveIdea(Request $request, Idea $idea)
    {

        // Ensure the idea has status pending or approved
        if ($idea->announcement->investor_id !== auth()->id() || !in_array($idea->status, ['pending', 'approved'])) {
            abort(403);
        }

        // Handle final decision stage
        if ($idea->stage === 'final_decision') {
            // Reject all other ideas related to the same announcement
            Idea::where('announcement_id', $idea->announcement_id)
                ->where('id', '!=', $idea->id)
                ->update([
                        'status' => 'rejected',
                        'is_reusable' => true,
                    ]);

            // Approve the selected idea
            $idea->update([
                'status' => 'approved',
                'stage' => 'final_decision',
            ]);

            IdeaStage::create([
                'idea_id' => $idea->id,
                'stage' => $idea->stage,
                'stage_status' => true,
                'changed_at' => now()
            ]);

            // Update the announcement
            $idea->announcement->update([
                'is_closed' => true,
                'closed_at' => now(),
                'status' => 'completed',
            ]);

            return redirect()->route('investor.ideas.show', $idea)
                ->with('success', 'تمت الموافقة على الفكرة بنجاح وسيتم التواصل مع صاحب الفكرة لعقد اتفاقية.');
        }

        // Move to the next stage
        $stages = ['new', 'initial_acceptance', 'under_review', 'expert_consultation', 'final_decision'];
        $currentStageIndex = array_search($idea->stage, $stages);
        $nextStage = $stages[$currentStageIndex + 1] ?? $idea->stage;

        $idea->update([
            'stage' => $nextStage,
        ]);

        IdeaStage::create([
            'idea_id' => $idea->id,
            'stage' => $nextStage,
            'stage_status' => true,
            'changed_at' => now()
        ]);

        return redirect()->route('investor.ideas.show', $idea)
            ->with('success', 'تم نقل الفكرة إلى المرحلة التالية.');
    }

    // public function updateStage(Request $request, Idea $idea)
    // {
    //     // Validate the request
    //     $request->validate([
    //         'stage' => 'required|in:new,initial_acceptance,under_review,expert_consultation,final_decision'
    //     ]);

    //     // Update the idea stage
    //     $idea->update(['stage' => $request->stage]);

    //     // Create new stage record
    //     IdeaStage::create([
    //         'idea_id' => $idea->id,
    //         'stage' => $request->stage,
    //         'stage_status' => true,
    //         'changed_at' => now()
    //     ]);

    //     return redirect()->back()->with('success', 'تم تحديث مرحلة الفكرة بنجاح');
    // }
}
