<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\CommercialRegistration;
use App\Models\User;
use App\Models\Announcement;

class DashboardController extends Controller
{
    public function index()
    {
        // Retrieve data for the dashboard
        //1- Pending Commercial Registrations
        $pendingRegistrations = CommercialRegistration::with('user')
            ->where('status', 'pending')
            ->latest()
            ->get();

        //2- Recent Users Registered
        $recentUsers = User::latest()
            ->take(5)
            ->get();

        //3- announcements
        $announcements = Announcement::all()->count();

        $stats = [
            'total_users' => User::count(),
            'pending_registrations' => CommercialRegistration::where('status', 'pending')->count(),
            'approved_registrations' => CommercialRegistration::where('status', 'approved')->count(),
            'rejected_registrations' => CommercialRegistration::where('status', 'rejected')->count(),
            'announcements' => $announcements
        ];

        return view('admin.index', compact('pendingRegistrations', 'recentUsers', 'stats'));
    }
}
