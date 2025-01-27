<?php
namespace App\Http\Controllers\Entrepreneur;

use App\Models\Idea;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Announcement;

class IdeaController extends Controller
{
    public function index()
    {
        $entrepreneur = auth()->user();

        // Paginate ideas with 6 records per page
        $ideas = Idea::with([
            'categories',
            'announcement',
            'stages' => function ($query) {
                $query->orderBy('changed_at', 'desc');
            }
        ])
            ->where('entrepreneur_id', $entrepreneur->id)
            ->orderBy('created_at', 'desc')
            ->paginate(6);

        // Calculate statistics
        $statistics = [
            'total' => $ideas->total(), // Total number of ideas (including paginated ones)
            'pending' => $ideas->where('approval_status', 'pending')->count(),
            'approved' => $ideas->where('approval_status', 'approved')->count(),
            'rejected' => $ideas->where('approval_status', 'rejected')->count(),
            'in_progress' => $ideas->where('status', 'in-progress')->count(),
            'expired' => $ideas->where('status', 'expired')->count(),
        ];

        return view('entrepreneur.ideas.index', compact('ideas', 'statistics'));
    }

    public function create(Request $request)
    {
        $categories = Category::whereNull('parent_id')
            ->with('children')
            ->get();

        // Pass the announcement_id to the view if it exists
        $announcement_id = $request->query('announcement_id');

        return view('entrepreneur.ideas.create', compact('categories', 'announcement_id'));
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
            'feasibility_study' => 'nullable|file|mimes:pdf|max:2048',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Handle file uploads
        $feasibilityStudyPath = $request->file('feasibility_study') ? $request->file('feasibility_study')->store('feasibility_studies', 'public') : null;
        $imagePath = $request->file('image') ? $request->file('image')->store('idea_images', 'public') : null;

        // Create the idea
        $idea = Idea::create([
            'name' => $request->name,
            'brief_description' => $request->brief_description,
            'detailed_description' => $request->detailed_description,
            'budget' => $request->budget,
            'location' => $request->location,
            'idea_type' => $request->idea_type,
            'entrepreneur_id' => auth()->id(),
            'announcement_id' => $request->announcement_id,
            'feasibility_study' => $feasibilityStudyPath,
            'image' => $imagePath,
        ]);

        // Attach categories
        $idea->categories()->attach($request->categories);

        return redirect()->route('entrepreneur.ideas.index')->with('success', 'تم إنشاء الفكرة بنجاح.');
    }
}
