<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\CommercialRegistration;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        $pendingRegistrations = CommercialRegistration::with('user')
            ->where('status', 'pending')
            ->latest()
            ->get();

        $recentUsers = User::latest()
            ->take(5)
            ->get();

        $stats = [
            'total_users' => User::count(),
            'pending_registrations' => CommercialRegistration::where('status', 'pending')->count(),
            'approved_registrations' => CommercialRegistration::where('status', 'approved')->count(),
            'rejected_registrations' => CommercialRegistration::where('status', 'rejected')->count(),
        ];

        return view('admin.index', compact('pendingRegistrations', 'recentUsers', 'stats'));
    }

    public function registrations()
    {
        $registrations = CommercialRegistration::with('user')
            ->latest()
            ->paginate(10);

        return view('admin.registrations.index', compact('registrations'));
    }

    public function updateRegistrationStatus(Request $request, CommercialRegistration $registration)
    {
        $validated = $request->validate([
            'status' => 'required|in:approved,rejected',
            'admin_notes' => 'nullable|string|max:500'
        ]);

        $registration->update($validated);

        return back()->with('success', 'Registration status updated successfully');
    }

    public function users()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function toggleUserStatus(User $user)
    {
        $user->update(['is_active' => !$user->is_active]);
        return back()->with('success', 'User status updated successfully');
    }
}
