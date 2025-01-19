<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use Illuminate\Http\Request;

class IdeaController extends Controller
{
    // Create a new idea
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'brief_description' => 'required|string',
            'detailed_description' => 'required|string',
            'budget' => 'required|numeric',
            'location' => 'required|string',
            'idea_type' => 'required|in:creative,traditional',
            'categories' => 'required|array', // Array of category IDs
        ]);

        $idea = Idea::create([
            'name' => $request->name,
            'brief_description' => $request->brief_description,
            'detailed_description' => $request->detailed_description,
            'budget' => $request->budget,
            'location' => $request->location,
            'idea_type' => $request->idea_type,
            'entrepreneur_id' => auth()->id(), // Logged-in entrepreneur
        ]);

        // Attach categories
        $idea->categories()->attach($request->categories);

        return response()->json($idea, 201);
    }

    // Admin approves or rejects an idea
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

        return response()->json($idea);
    }
}
