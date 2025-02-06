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
        $categories = Category::whereNotNull('parent_id')->get();

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

        // Get old category IDs from the session
        $oldCategoryIds = old('categories', []);

        // Map old category IDs to their corresponding category objects
        $oldCategories = $categories->whereIn('id', $oldCategoryIds)->values();

        // Pass the categories, announcement, and old input data to the view
        return view('entrepreneur.ideas.create', [
            'categories' => $categories,
            'announcement_id' => $announcement_id,
            'announcement' => $announcement,
            'oldCategories' => $oldCategories, // Pass old category objects
        ]);
    }

    public function store(Request $request)
    {
        // Common validation rules for both creative and traditional ideas
        $commonValidationRules = [
            'name' => 'required|string',
            'brief_description' => 'required|string|max:255',
            'detailed_description' => 'required|string',
            'budget' => 'required|numeric|min:0',
            'location' => 'required|string',
            'idea_type' => 'required|in:creative,traditional',
            'categories' => 'required|array',
            'feasibility_study' => 'required|file|mimes:pdf,doc,docx|max:4048', // Fixed validation rule
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



    public function edit(Idea $idea)
    {
        // ensure the authenticated user owns the idea
        if ($idea->entrepreneur_id !== auth()->id()) {
            return redirect()->back()
                ->with('error', 'You are not authorized to edit this idea.');
        }

        // common checks for all ideas
        if ($idea->expiry_date < now()) {
            return redirect()->back()
                ->with('error', 'لا يمكن تعديل هذه الفكرة لان الفكرة منتهية الصلاحية.');
        }

        // additional checks for creative ideas
        if ($idea->idea_type === 'creative') {
            $announcement = $idea->announcement;

            if ($announcement->status === 'closed') {
                return redirect()->back()
                    ->with('error', 'لا يمكن تعديل هذه الفكرة لان الاعلان مغلق.');
            }

            if ($idea->status === 'rejected') {
                return redirect()->back()
                    ->with('error', 'لا يمكن تعديل هذه الفكرة لان الفكرة مرفوض.');
            }

            // fetch categories and pass them with the announcement
            $categories = Category::whereNotNull('parent_id')->get();
            return view('entrepreneur.ideas.edit', compact('idea', 'categories', 'announcement'));
        }

        // for non-creative ideas, fetch categories and pass to the view
        $categories = Category::whereNotNull('parent_id')->get();
        return view('entrepreneur.ideas.edit', compact('idea', 'categories'));
    }


    public function update(Request $request, $id)
    {

        $idea = Idea::findOrFail($id);

        // ensure the authenticated user owns the idea
        if ($idea->entrepreneur_id !== auth()->id()) {
            return redirect()->route('entrepreneur.ideas.index')
                ->with('error', 'You are not authorized to update this idea.');
        }

        // common checks for all ideas
        if ($idea->expiry_date < now()) {
            return redirect()->back()
                ->with('error', 'لا يمكن تحديث هذه الفكرة لان الفكرة منتهية الصلاحية.');
        }

        // additional checks for creative ideas
        if ($idea->idea_type === 'creative') {
            $announcement = $idea->announcement;

            if ($announcement->status === 'closed') {
                return redirect()->back()
                    ->with('error', 'لا يمكن تحديث هذه الفكرة لان الاعلان مغلق.');
            }

            if ($idea->status === 'rejected') {
                return redirect()->back()
                    ->with('error', 'لا يمكن تحديث هذه الفكرة لان الفكرة مرفوض.');
            }
        }

        // common validation rules for both creative and traditional ideas
        $commonValidationRules = [
            'name' => 'required|string',
            'brief_description' => 'required|string|max:255',
            'detailed_description' => 'required|string',
            'budget' => 'required|numeric',
            'location' => 'required|string',
            'idea_type' => 'required|in:creative,traditional',
            'categories' => 'required|array',
            'feasibility_study' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];

        // additional validation rules for creative ideas
        if ($request->has('announcement_id') && $request->input('idea_type') === 'creative') {
            $commonValidationRules['announcement_id'] = 'required|exists:announcements,id';
        }

        // validate the request data
        $validatedIdeaData = $request->validate($commonValidationRules);

        // check for duplicate ideas (only for creative ideas)
        if ($validatedIdeaData['idea_type'] === 'creative') {
            $duplicateIdea = Idea::where('id', '!=', $idea->id) // Exclude the current idea
                ->where('is_reusable', false)
                ->where(function ($query) use ($validatedIdeaData) {
                    $query->where('name', $validatedIdeaData['name'])
                        ->where('brief_description', $validatedIdeaData['brief_description'])
                        ->where('detailed_description', $validatedIdeaData['detailed_description']);
                })
                ->first();

            if ($duplicateIdea) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors([
                        'name' => 'هذه الفكرة موجودة بالفعل ولا يمكن إعادة استخدامها.',
                        'brief_description' => 'هذه الفكرة موجودة بالفعل ولا يمكن إعادة استخدامها.',
                        'detailed_description' => 'هذه الفكرة موجودة بالفعل ولا يمكن إعادة استخدامها.',
                    ]);
            }
        }

        // handle file uploads if provided
        if ($request->hasFile('feasibility_study')) {
            $feasibilityStudyPath = $request->file('feasibility_study')->store('feasibility_studies', 'public');
            $validatedIdeaData['feasibility_study'] = $feasibilityStudyPath;
        }

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('idea_images', 'public');
            $validatedIdeaData['image'] = $imagePath;
        }

        // set the approval status to "pending"
        $validatedIdeaData['approval_status'] = 'pending';

        // update the idea
        $idea->update($validatedIdeaData);

        // sync categories
        $idea->categories()->sync($validatedIdeaData['categories']);

        // notify the admin that there is a new announcement needing approval
        $notificationService = app(NotificationService::class);
        $admins = User::where('user_type', '1')->get();
        foreach ($admins as $admin) {
            $notificationService->notify($admin, [
                'type' => 'updated_idea',
                'title' => 'فكرة محدث في انتظار الموافقة',
                'message' => 'تم تحديث فكرة ' . $idea->name . ' وهو في انتظار الموافقة من قبل الإدارة.',
                'action_type' => 'view_idea',
                'action_id' => $idea->id,
                'action_url' => route('admin.ideas.show', $idea->id),
                'initiator_id' => auth()->id(),
                'initiator_type' => 'entrepreneur',
            ]);
        }

        return redirect()->route('entrepreneur.ideas.index')
            ->with('success', 'تم تحديث الفكرة بنجاح.');
    }

    public function destroy(Idea $idea)
    {
        //ensure that the entrepreneur owns this idea
        if ($idea->entrepreneur_id !== auth()->id()) {
            abort(403);
        }

        $idea->update([
            'is-reusable' => true,
        ]);
        $idea->delete();
        return redirect()->route('entrepreneur.ideas.index')
            ->with('success', 'تم حذف الفكرة بنجاح.');
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




