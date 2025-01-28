<?php
namespace App\Http\Controllers\Entrepreneur;

use App\Models\Idea;
use App\Models\IdeaStage;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Announcement;
use App\Models\User;

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

    public function show(Idea $idea)
    {
        if ($idea->idea === 'creative') {
            //ensure the idea owned by this entrepreneur
            if ($idea->entrepreneur_id !== auth()->id()) {
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

            return view('entrepreneur.ideas.show', compact('idea', 'progressPercentage'));

        } else {
            $idea->load([
                'categories',
                'entrepreneur',
            ]);
            return view('entrepreneur.ideas.show', compact('idea'));

        }

    }

    public function create(Request $request)
    {
        $categories = Category::whereNotNull('parent_id')
            ->get();

        // Fetch the announcement_id from the request
        $announcement_id = $request->query('announcement_id');

        // Fetch the announcement details if announcement_id is provided
        $announcement = null;
        if ($announcement_id) {
            $announcement = Announcement::find($announcement_id);
            if (!$announcement) {
                // Handle the case where the announcement does not exist
                return redirect()->route('entrepreneur.ideas.create')
                    ->with('error', 'الإعلان المحدد غير موجود.');
            }
        }

        // Pass the categories and announcement to the view
        return view('entrepreneur.ideas.create', compact('categories', 'announcement_id', 'announcement'));
    }


    public function store(Request $request)
    {
        // Common validation rules for both creative and traditional ideas
        $commonValidationRules = [
            'name' => 'required|string',
            'brief_description' => 'required|string|max:255',
            'detailed_description' => 'required|string',
            'budget' => 'required|numeric',
            'location' => 'required|string',
            'idea_type' => 'required|in:creative,traditional',
            'categories' => 'required|array',
            'feasibility_study' => 'required|file|mimes:pdf,doc,docx|max:2048', // Fixed validation rule
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ];

        // Additional validation rules for creative ideas
        if ($request->has('announcement_id') && $request->input('idea_type') === 'creative') {
            $commonValidationRules['announcement_id'] = 'required|exists:announcements,id';
        }

        // Validate the request data
        $validatedIdeaData = $request->validate($commonValidationRules);

        // Check for duplicate ideas (only for creative ideas)
        if ($request->input('idea_type') === 'creative') {
            $existingIdea = Idea::where('name', $validatedIdeaData['name'])
                ->orWhere('brief_description', $validatedIdeaData['brief_description'])
                ->orWhere('detailed_description', $validatedIdeaData['detailed_description'])
                ->where('is_reusable', false)
                ->first();

            if ($existingIdea) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors([
                        'name' => 'هذه الفكرة موجودة بالفعل ولا يمكن إعادة استخدامها.',
                        'brief_description' => 'هذه الفكرة موجودة بالفعل ولا يمكن إعادة استخدامها.',
                        'detailed_description' => 'هذه الفكرة موجودة بالفعل ولا يمكن إعادة استخدامها.',
                    ]);
            }
        }

        // Handle file uploads
        $feasibilityStudyPath = $request->file('feasibility_study')->store('feasibility_studies', 'public');
        $imagePath = $request->file('image')->store('idea_images', 'public');

        // Create the idea
        $ideaData = [
            'name' => $validatedIdeaData['name'],
            'brief_description' => $validatedIdeaData['brief_description'],
            'detailed_description' => $validatedIdeaData['detailed_description'],
            'budget' => $validatedIdeaData['budget'],
            'location' => $validatedIdeaData['location'],
            'entrepreneur_id' => auth()->id(),
            'feasibility_study' => $feasibilityStudyPath,
            'image' => $imagePath,
            'approval_status' => 'pending',
            'status' => 'in-progress',
            'idea_type' => $validatedIdeaData['idea_type'],
            'is_reusable' => $validatedIdeaData['idea_type'] === 'creative' ? false : true,
        ];

        // Additional fields for creative ideas
        if ($validatedIdeaData['idea_type'] === 'creative') {
            $ideaData['announcement_id'] = $validatedIdeaData['announcement_id'];
            $ideaData['stage'] = 'new';
            $ideaData['expiry_date'] = now()->addMonths(1); // 1 month expiry for creative ideas
        } else {
            $ideaData['expiry_date'] = now()->addMonths(2); // 2 months expiry for traditional ideas
        }

        // Create the idea
        $idea = Idea::create($ideaData);

        // Attach categories
        $idea->categories()->attach($validatedIdeaData['categories']);

        // Create initial idea stage (only for creative ideas)
        if ($validatedIdeaData['idea_type'] === 'creative') {
            IdeaStage::create([
                'idea_id' => $idea->id,
                'stage' => 'new',
                'stage_status' => true,
            ]);
        }

        // Notify the admin that a new idea has been created
        $this->notifyAdminAboutNewIdea($idea);

        return redirect()->route('entrepreneur.ideas.index')
            ->with('success', 'تم إنشاء الفكرة بنجاح.');
    }

    /**
     * Notify the admin that a new idea has been created.
     */
    protected function notifyAdminAboutNewIdea(Idea $idea)
    {
        // Fetch all admin users
        $admins = User::where('user_type', 1)->get();

        // Prepare notification data
        $data = [
            'type' => 'new_idea_created',
            'title' => 'فكرة جديدة تحتاج إلى الموافقة',
            'message' => 'تم إنشاء فكرة جديدة: ' . $idea->name,
            'action_type' => 'new_idea_created',
            'action_id' => $idea->id,
            'action_url' => route('admin.ideas.show', $idea->id),
            'initiator_id' => $idea->entrepreneur_id,
            'initiator_type' => 'entrepreneur',
            'additional_data' => [
                    'idea_title' => $idea->name,
                    'entrepreneur_name' => $idea->entrepreneur->name,
                ],
        ];

        // Send notification to all admins
        app(NotificationService::class)->notifyAdmins($data);
    }
}




