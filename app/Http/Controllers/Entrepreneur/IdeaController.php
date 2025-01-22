<?php
namespace App\Http\Controllers\Entrepreneur;

use App\Models\Idea;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IdeaController extends Controller
{
    public function index()
    {
        $ideas = Idea::where('entrepreneur_id', auth()->id())->latest()->paginate(10);
        return view('entrepreneur.ideas.index', compact('ideas'));
    }

    public function create()
    {
        return view('entrepreneur.ideas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'brief_description' => 'required|string',
            'detailed_description' => 'required|string',
            'budget' => 'required|numeric',
            'location' => 'required|string',
            'idea_type' => 'required|in:creative,traditional',
            'categories' => 'required|array',
        ]);

        $idea = Idea::create([
            'name' => $request->name,
            'brief_description' => $request->brief_description,
            'detailed_description' => $request->detailed_description,
            'budget' => $request->budget,
            'location' => $request->location,
            'idea_type' => $request->idea_type,
            'entrepreneur_id' => auth()->id(),
        ]);

        $idea->categories()->attach($request->categories);

        return redirect()->route('entrepreneur.ideas.index')->with('success', 'تم إنشاء الفكرة بنجاح.');
    }
}
