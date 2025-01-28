<?php
namespace App\Http\Controllers\Investor;

use App\Models\Announcement;
use App\Models\Category;
use App\Models\Idea;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AnnouncementController extends Controller
{
    use AuthorizesRequests;

    // Display all announcements created by the investor
    public function index()
    {
        $investor = auth()->user();

        // Paginate announcements with 6 records per page

        $announcements = Announcement::with([
            'categories',
            'ideas' => function ($query) {
                $query->where('approval_status', 'approved')
                    ->whereDate('expiry_date', '>', now())
                    ->whereIn('status', ['in-progress', 'approved']);
            }
        ])
            ->where('investor_id', $investor->id)
            ->orderBy('created_at', 'desc')
            ->paginate(6); // Paginate with 10 records per page

        // Calculate statistics
        $statistics = [
            'total' => $announcements->total(), // Total number of announcements (including paginated ones)
            'pending' => $announcements->where('approval_status', 'pending')->count(),
            'approved' => $announcements->where('approval_status', 'approved')->count(),
            'rejected' => $announcements->where('approval_status', 'rejected')->count(),
            'completed' => $announcements->where('status', 'completed')->count(),

        ];

        return view('investor.announcements.index', compact('announcements', 'statistics'));
    }

    // Show the form to create a new announcement
    public function create()
    {
        // $categories = Category::all();
        $categories = Category::whereNotNull('parent_id')
            ->with('children')
            ->get();

        return view('investor.announcements.create', compact('categories'));
    }

    // Store a new announcement
    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|min:3',
            'location' => 'required|string',
            'start_date' => 'required|date|after:today',
            'end_date' => 'required|date|after:start_date',
            'budget' => 'required|numeric|min:1|max:1000000000',
            'categories' => 'required|array|min:1|max:5',
            'categories.*' => 'exists:categories,id'
        ]);

        $announcement = Announcement::create([
            'description' => $request->description,
            'location' => $request->location,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'budget' => $request->budget,
            'investor_id' => auth()->id(),
            'approval_status' => 'pending', // admin approval
            'is_closed' => false,
            'status' => 'in-progress'
        ]);

        $announcement->categories()->attach($request->categories);

        // Notify the admin about the new announcement
        $notificationService = app(NotificationService::class);

        $admins = User::where('user_type', '1')->get();
        foreach ($admins as $admin) {
            $notificationService->notify($admin, [
                'type' => 'new_announcement',
                'title' => 'إعلان جديد في انتظار الموافقة',
                'message' => 'هناك إعلان جديد يحتاج إلى الموافقة.',
                'action_type' => 'view_announcement',
                'action_id' => $announcement->id,
                'action_url' => route('admin.announcements.show', $announcement->id),
                'initiator_id' => auth()->id(),
                'initiator_type' => 'investor',
            ]);
        }

        return redirect()->route('investor.announcements.index')
            ->with('success', 'تم إنشاء الإعلان بنجاح وسيتم مراجعته من قبل الإدارة');
    }



    public function show(Announcement $announcement)
    {
        // ensure the authenticated investor owns this announcement
        if ($announcement->investor_id !== auth()->id()) {
            abort(403);
        }

        // load the announcement with its relationships
        $announcement->load([
            'categories',
            'ideas' => function ($query) {
                $query->where('approval_status', 'approved')
                    ->whereIn('status', ['in-progress', 'approved'])
                    ->whereDate('expiry_date', '>', now());
            }
        ]);

        // Get statistics
        $stats = [
            'total_ideas' => $announcement->ideas()
                ->where('approval_status', 'approved')
                ->whereIn('status', ['in-progress', 'approved'])
                ->whereDate('expiry_date', '>', now())
                ->count(),
        ];


        return view('investor.announcements.show', compact('announcement', 'stats'));
    }

    public function edit(Announcement $announcement)
    {
        // Ensure the authenticated investor owns this announcement
        if ($announcement->investor_id !== auth()->id()) {
            abort(403);
        }

        // Prevent editing if the announcement is closed
        if ($announcement->is_closed == "true") {
            abort(403, 'This announcement is closed and cannot be edited.');
        }

        // Get parent categories and their children
        $categories = Category::whereNotNull('parent_id')
            ->with('children')
            ->get();

        // load the announcement with its relationships
        $announcement->load('categories');

        return view('investor.announcements.edit', compact('announcement', 'categories'));
    }


    public function update(Request $request, Announcement $announcement)
    {
        // ensure the authenticated investor owns this announcement
        if ($announcement->investor_id !== auth()->id()) {
            abort(403);
        }

        // prevent updating if the announcement is closed
        if ($announcement->is_closed == "true") {
            abort(403, 'This announcement is closed and cannot be updated.');
        }

        $request->validate([
            'description' => 'required|min:3',
            'location' => 'required|string',
            'start_date' => 'required|date|after:today',
            'end_date' => 'required|date|after:start_date',
            'budget' => 'required|numeric|min:1|max:1000000000',
            'categories' => 'required|array|min:1|max:5',
            'categories.*' => 'exists:categories,id',
        ]);


        $announcement->update([
            'description' => $request->description,
            'location' => $request->location,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'budget' => $request->budget,
            'approval_status' => 'pending',
        ]);

        // Notify the admin that there is a new announcement needing approval
        $notificationService = app(NotificationService::class);

        $admins = User::where('user_type', '1')->get();
        foreach ($admins as $admin) {
            $notificationService->notify($admin, [
                'type' => 'updated_announcement',
                'title' => 'إعلان محدث في انتظار الموافقة',
                'message' => 'تم تحديث الإعلان وهو في انتظار الموافقة من قبل الإدارة.',
                'action_type' => 'view_announcement',
                'action_id' => $announcement->id,
                'action_url' => route('admin.announcements.show', $announcement->id),
                'initiator_id' => auth()->id(),
                'initiator_type' => 'investor',
            ]);
        }

        // Sync the categories
        $announcement->categories()->sync($request->categories);

        return redirect()->route('investor.announcements.index')
            ->with('success', 'تم تحديث الإعلان بنجاح');
    }


    public function destroy(Announcement $announcement)
    {
        // ensure the authenticated investor owns this announcement
        if ($announcement->investor_id !== auth()->id()) {
            abort(403);
        }

        // prevent deleting if the announcement is closed
        if ($announcement->is_closed == "true") {
            abort(403, 'This announcement is closed and cannot be deleted.');
        }


        $announcement->update([
            'status' => 'deleted_by_investor',
        ]);

        $announcement->delete(); // Soft delete

        //select all the ideas that are related to this announcement and update there status to rejected and notify all the entrepreneurs that their idea was deleted
        $ideas = Idea::where('announcement_id', $announcement->id)->where('status', 'in-progress')->where('approval_status', 'approved')->get();

        foreach ($ideas as $idea) {
            $idea->update([
                'status' => 'rejected',
                'is-reusable' => true,
            ]);

            $notificationService = app(NotificationService::class);

            $notificationService->notify($idea->entrepreneur, [
                'type' => 'announcement_deleted',
                'title' => 'تم حذف الإعلان من قبل المستثمر',
                'message' => 'تم حذف الإعلان المرتبط بهذه الفكرة من قبل المستثمر لذلك يمكنك استخدامها مره اخرى   .و ارسال هذه الفكرة للاعلانات الأخرى',
                'action_type' => 'view_idea',
                'action_id' => $idea->id,
                'action_url' => route('entrepreneur.ideas.show', $idea->id),
                'initiator_id' => auth()->id(),
                'initiator_type' => 'admin',
            ]);
        }

        return redirect()->route('investor.announcements.index')
            ->with('success', 'تم حذف الإعلان بنجاح');
    }

}
