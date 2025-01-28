<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{

    public function show()
    {
        $user = Auth::user();

        $statistics = [];
        if ($user->isInvestor()) {
            $statistics = [
                'total_announcements' => $user->announcements()->count(),
                'active_announcements' => $user->announcements()->where('status', 'in-progress')->count(),
                'completed_announcements' => $user->announcements()->where('status', 'completed')->count(),
                'total_budget' => $user->announcements()->sum('budget'),
            ];
        } elseif ($user->isEntrepreneur()) {
            $statistics = [
                'total_ideas' => $user->ideas()->count(),
                'approved_ideas' => $user->ideas()->where('approval_status', 'approved')->count(),
                'pending_ideas' => $user->ideas()->where('approval_status', 'pending')->count(),
                'total_budget_requested' => $user->ideas()->sum('budget'),
            ];
        }

        return view('profile.show', [
            'user' => $user,
            'statistics' => $statistics,
        ]);
    }


    public function edit()
    {
        $user = Auth::user();

        return view('profile.edit', ['user' => $user]);
    }


    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'phone_number' => 'nullable|string|max:20',
            'city' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'profile_image' => 'nullable|image|max:2048',
            'password' => 'nullable|string|min:6|confirmed',
        ]);


        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'city' => $request->city,
            'address' => $request->address,
        ]);


        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('profile_images', 'public');
            $user->update(['profile_image' => $path]);
        }


        if ($request->password) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('profile.show', ['profile' => $user])->with('success', 'تم تحديث الملف الشخصي بنجاح.');
    }
}
