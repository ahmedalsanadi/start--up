<?php
namespace App\Http\Controllers\Investor;

use App\Models\Announcement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::where('investor_id', auth()->id())->latest()->paginate(10);
        return view('investor.announcements.index', compact('announcements'));
    }

    public function create()
    {
        return view('investor.announcements.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string',
            'location' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'budget' => 'required|numeric',
            'categories' => 'required|array',
        ]);

        $announcement = Announcement::create([
            'description' => $request->description,
            'location' => $request->location,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'budget' => $request->budget,
            'investor_id' => auth()->id(),
        ]);

        $announcement->categories()->attach($request->categories);

        return redirect()->route('investor.announcements.index')->with('success', 'تم إنشاء الإعلان بنجاح.');
    }
}
