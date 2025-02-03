<?php
// app/Http/Controllers/Investor/IdeaController.php
namespace App\Http\Controllers\Investor;

use App\Models\Idea;
use App\Http\Controllers\Controller;
use App\Models\IdeaStage;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class IdeaController extends Controller
{
    public function show(Idea $idea)
    {
        if ($idea->idea === 'creative') {
            //ensure the idea has status pending or approved
            if ($idea->announcement->investor_id !== auth()->id() || !in_array($idea->status, ['in-progress', 'approved'])) {
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

        } else {
            $idea->load([
                'categories',
                'entrepreneur',
            ]);
            return view('investor.ideas.show', compact('idea'));

        }

    }

    public function rejectIdea(Request $request, Idea $idea)
    {

        // Ensure the idea has status pending or approved
        if ($idea->announcement->investor_id !== auth()->id() || !in_array($idea->status, ['in-progress', 'approved'])) {
            abort(403);
        }

        // Update the idea status to 'rejected' and set is_reusable to true
        $idea->update([
            'status' => 'rejected',
            'is_reusable' => true,
        ]);


        // Notify the entrepreneur that their idea has been rejected
        app(NotificationService::class)->notify($idea->entrepreneur, [
            'type' => 'idea_rejected',
            'title' => 'تم رفض الفكرة',
            'message' => 'تم رفض فكرتك للإعلان: ' . $idea->announcement->description,
            'action_type' => 'idea_rejected',
            'action_id' => $idea->id,
            'action_url' => route('entrepreneur.ideas.show', $idea->id),
            'initiator_id' => auth()->id(),
            'initiator_type' => 'investor',
        ]);



        return redirect()->route('investor.announcements.show', $idea->announcement)
            ->with('success', 'تم رفض الفكرة بنجاح.');
    }


    public function approveIdea(Request $request, Idea $idea)
    {
        // Ensure the idea has status pending or approved
        if ($idea->announcement->investor_id !== auth()->id() || !in_array($idea->status, ['in-progress', 'approved'])) {
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

            // Notify the entrepreneur that their idea has been rejected
            foreach ($idea->announcement->ideas as $otherIdea) {
                if ($otherIdea->id !== $idea->id && $otherIdea->status === 'in-progress' && $otherIdea->approval_status != 'rejected') {
                    app(NotificationService::class)->notify($otherIdea->entrepreneur, [
                        'type' => 'idea_rejected',
                        'title' => 'تم رفض الفكرة',
                        'message' => 'تم رفض فكرتك للإعلان: ' . $idea->announcement->description,
                        'action_type' => 'idea_rejected',
                        'action_id' => $otherIdea->id,
                        'action_url' => route('entrepreneur.ideas.show', $otherIdea->id),
                        'initiator_id' => auth()->id(),
                        'initiator_type' => 'investor',
                    ]);
                }
            }

            //Notify the admin that an idea has been approved
            app(NotificationService::class)->notifyAdmins([
                'type' => 'idea_approved_final',
                'title' => 'تمت الموافقة على فكرة نهائية',
                'message' => 'تمت الموافقة على الفكرة: ' . $idea->name . ' للإعلان: ' . $idea->announcement->description,
                'action_type' => 'idea_approved_final',
                'action_id' => $idea->id,
                'action_url' => route('admin.announcements.show', $idea->announcement), // Route for admin to view the idea
                'initiator_id' => auth()->id(),
                'initiator_type' => 'investor',
            ]);


            // Approve the selected idea
            $idea->update([
                'status' => 'approved',
                'stage' => 'final_decision',
            ]);

            // Notify the entrepreneur that their idea has been approved
            app(NotificationService::class)->notify($idea->entrepreneur, [
                'type' => 'idea_approved',
                'title' => 'تمت الموافقة على الفكرة',
                'message' => 'تمت الموافقة على فكرتك للإعلان: ' . $idea->announcement->description,
                'action_type' => 'idea_approved',
                'action_id' => $idea->id,
                'action_url' => route('entrepreneur.ideas.show', $idea->id),
                'initiator_id' => auth()->id(),
                'initiator_type' => 'investor',
            ]);

            IdeaStage::create([
                'idea_id' => $idea->id,
                'stage' => $idea->stage,
                'stage_status' => true,
                'changed_at' => now(),
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
            'changed_at' => now(),
        ]);

        // Notify the entrepreneur that their idea has been moved to the next stage
        app(NotificationService::class)->notify($idea->entrepreneur, [
            'type' => 'idea_stage_updated',
            'title' => 'تم نقل الفكرة إلى المرحلة التالية',
            'message' => 'تم نقل فكرتك للإعلان: ' . $idea->announcement->description . ' إلى المرحلة: ' . __("ideas.stages.$nextStage"),
            'action_type' => 'idea_stage_updated',
            'action_id' => $idea->id,
            'action_url' => route('entrepreneur.ideas.show', $idea->id),
            'initiator_id' => auth()->id(),
            'initiator_type' => 'investor',
        ]);

        return redirect()->route('investor.ideas.show', $idea)
            ->with('success', 'تم نقل الفكرة إلى المرحلة التالية.');
    }

}
