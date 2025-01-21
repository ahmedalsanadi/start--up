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

        $announcements = Announcement::with([
            'categories',
            'ideas' => function ($query) {
                $query->where('approval_status', 'approved');
            }
        ])
            ->where('investor_id', $investor->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $statistics = [
            'total' => $announcements->count(),
            'pending' => $announcements->where('approval_status', 'pending')->count(),
            'approved' => $announcements->where('approval_status', 'approved')->count(),
            'rejected' => $announcements->where('approval_status', 'rejected')->count(),
            'active_ideas' => $announcements->flatMap->ideas->where('status', 'active')->count(),
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
            'status' => 'active'
        ]);

        $announcement->categories()->attach($request->categories);

        // // Notify admin about new announcement
        // $admins = User::where('user_type', '1')->get();
        // Notification::send($admins, new NewAnnouncementNotification($announcement));

        return redirect()->route('investor.announcements.index')
            ->with('success', 'تم إنشاء الإعلان بنجاح وسيتم مراجعته من قبل الإدارة');
    }

    // Show a specific announcement
// InvestorAnnouncementController.php

public function show(Announcement $announcement)
{
    // Security check to ensure the investor owns this announcement
    if ($announcement->investor_id !== auth()->id()) {
        abort(403);
    }

    // Load the announcement with its categories and approved ideas (including stages)
    $announcement->load([
        'categories',
        'ideas' => function ($query) {
            $query->where('approval_status', 'approved')
                  ->with('stages');
        }
    ]);

    // Calculate statistics
    $statistics = [
        'total_ideas' => $announcement->ideas->count(),
        'initial_approve' => $announcement->ideas->filter(function ($idea) {
            // Get the latest stage for the idea
            $latestStage = $idea->stages->sortByDesc('changed_at')->first();
            return $latestStage?->stage === 'initial_approve';
        })->count(),
        'under_review' => $announcement->ideas->filter(function ($idea) {
            // Get the latest stage for the idea
            $latestStage = $idea->stages->sortByDesc('changed_at')->first();
            return $latestStage?->stage === 'under_review';
        })->count(),
        'last_decision' => $announcement->ideas->filter(function ($idea) {
            // Get the latest stage for the idea
            $latestStage = $idea->stages->sortByDesc('changed_at')->first();
            return $latestStage?->stage === 'last_decision';
        })->count(),
       'days_remaining' => round(now()->diffInDays($announcement->end_date, false))
    ];

    return view('investor.announcements.show', compact('announcement', 'statistics'));
}
    // Show the form to edit an announcement
    public function edit(Announcement $announcement)
    {
        $this->authorize('update', $announcement); // Ensure the investor owns the announcement
        $categories = Category::all();
        return view('investor.announcements.edit', compact('announcement', 'categories'));
    }
}
