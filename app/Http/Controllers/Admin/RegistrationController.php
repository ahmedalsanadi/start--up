<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\CommercialRegistration;

class RegistrationController extends Controller
{
    public function index()
    {
        $registrations = CommercialRegistration::with('user')
            ->latest()
            ->paginate(10);

        return view('admin.registrations.index', compact('registrations'));
    }

    public function updateStatus(Request $request, CommercialRegistration $registration)
    {
        $validated = $request->validate([
            'status' => 'required|in:approved,rejected',
            'admin_notes' => 'nullable|string|max:500',
        ]);

        $registration->update($validated);

        return back()->with('success', 'Registration status updated successfully');
    }
}
