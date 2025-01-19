<?php

namespace App\Http\Controllers\Admin;

use App\Models\Announcement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminAnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::with('investor')->latest()->paginate(10);
        return view('admin.announcements.index', compact('announcements'));
    }

    public function updateStatus(Request $request, Announcement $announcement)
    {
        $request->validate([
            'approval_status' => 'required|in:approved,rejected',
            'rejection_reason' => 'nullable|string',
        ]);

        $announcement->update([
            'approval_status' => $request->approval_status,
            'rejection_reason' => $request->rejection_reason,
        ]);

        return redirect()->route('admin.announcements.index')->with('success', 'تم تحديث حالة الإعلان بنجاح.');
    }
}
