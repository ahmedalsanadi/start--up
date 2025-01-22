<?php
// app/Http/Controllers/Investor/IdeaController.php
namespace App\Http\Controllers\Investor;

use App\Models\Idea;
use App\Http\Controllers\Controller;

class IdeaController extends Controller
{
    public function show(Idea $idea)
    {
        // Ensure the idea is related to an announcement owned by the authenticated investor
        if ($idea->announcement->investor_id !== auth()->id()) {
            abort(403);
        }

        // Load the idea with its relationships
        $idea->load([
            'categories',
            'entrepreneur',
            'announcement',
            'stages',
        ]);

        return view('investor.ideas.show', compact('idea'));
    }
}
