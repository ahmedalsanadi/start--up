<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CommercialRegistration;
use App\Models\User;
use Illuminate\Http\Request;

class ManageInvestorController extends Controller
{
    public function index()
    {
        // Fetch users with their commercial registration
        $users = User::with('commercialRegistration')
            ->whereHas('commercialRegistration') // Use the correct relationship name
            ->latest()
            ->paginate(10);

        return view('admin.investors.index', compact('users'));
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
}
