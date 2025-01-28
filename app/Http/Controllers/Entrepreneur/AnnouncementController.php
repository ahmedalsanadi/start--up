<?php

namespace App\Http\Controllers\Entrepreneur;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Announcement;
use App\Models\Category;

class AnnouncementController extends Controller
{
    public function show(Announcement $announcement)
    {




        if ($announcement->approval_status == 'approved') {
            // Load the announcement with its relationships
            $announcement->load([
                'categories',
                'ideas' => function ($query) {
                    $query->where('entrepreneur_id', auth()->user()->id);

                }
            ]);
            return view('entrepreneur.announcements.show', compact('announcement'));
        } else {
            abort(403);
        }

    }


}
