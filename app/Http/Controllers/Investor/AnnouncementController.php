<?php
namespace App\Http\Controllers\Investor;

use App\Models\Announcement;
use App\Models\Category;
use App\Models\Idea;
use App\Models\User;
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
                $query->where('approval_status', 'approved');
            }
        ])
            ->where('investor_id', $investor->id)
            ->orderBy('created_at', 'desc')
            ->paginate(6); // Paginate with 6 records per page

        // Calculate statistics
        $statistics = [
            'total' => $announcements->total(), // Total number of announcements (including paginated ones)
            'pending' => $announcements->where('approval_status', 'pending')->count(),
            'approved' => $announcements->where('approval_status', 'approved')->count(),
            'rejected' => $announcements->where('approval_status', 'rejected')->count(),

        ];

        return view('investor.announcements.index', compact('announcements', 'statistics'));
    }

    // Show the form to create a new announcement
    public function create()
    {
        // $categories = Category::all();
        $categories = Category::whereNull('parent_id')
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
            'approval_status' => 'pending',
            'is_active' => true
        ]);

        $announcement->categories()->attach($request->categories);

        // // Notify admin about new announcement
        // $admins = User::where('user_type', '1')->get();
        // Notification::send($admins, new NewAnnouncementNotification($announcement));

        return redirect()->route('investor.announcements.index')
            ->with('success', 'تم إنشاء الإعلان بنجاح وسيتم مراجعته من قبل الإدارة');
    }


    public function show(Announcement $announcement)
    {
        // Ensure the authenticated investor owns this announcement
        if ($announcement->investor_id !== auth()->id()) {
            abort(403);
        }

        // Load the announcement with its relationships
        $announcement->load([
            'categories',
            'ideas' => function ($query) {
                $query->where('approval_status', 'approved')
                    ->where('is_active', true)
                    ->whereDate('expiry_date', '>', now());
            }
        ]);

        // Get statistics
        $stats = [
            'total_ideas' => $announcement->ideas->count()
        ];

        return view('investor.announcements.show', compact('announcement', 'stats'));
    }

    public function edit(Announcement $announcement)
    {
        // Ensure the authenticated investor owns this announcement
        if ($announcement->investor_id !== auth()->id()) {
            abort(403);
        }

        // Get parent categories and their children
        $categories = Category::whereNull('parent_id')
            ->with('children')
            ->get();

        // Load the announcement with its relationships
        $announcement->load('categories');

        return view('investor.announcements.edit', compact('announcement', 'categories'));
    }
    // Show the form to edit an existing announcement


    public function update(Request $request, Announcement $announcement)
    {
        // Ensure the authenticated investor owns this announcement
        if ($announcement->investor_id !== auth()->id()) {
            abort(403);
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

        // Update the announcement
        $announcement->update([
            'description' => $request->description,
            'location' => $request->location,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'budget' => $request->budget,
            'approval_status' => 'pending',
            'is_active' => true,
        ]);

        // Sync the categories
        $announcement->categories()->sync($request->categories);

        return redirect()->route('investor.announcements.index')
            ->with('success', 'تم تحديث الإعلان بنجاح');
    }

    public function destroy(Announcement $announcement)
    {
        // Ensure the authenticated investor owns this announcement
        if ($announcement->investor_id !== auth()->id()) {
            abort(403);
        }

        $announcement->delete(); // Soft delete

        return redirect()->route('investor.announcements.index')
            ->with('success', 'تم حذف الإعلان بنجاح');
    }

}
