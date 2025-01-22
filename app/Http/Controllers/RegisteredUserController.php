<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\ImageFile;
use Illuminate\Support\Facades\Session;

class RegisteredUserController extends Controller
{
    public function create()
    {
        return view("auth.register");
    }

    public function store(Request $request)
    {
        $userAttributes = $request->validate([
            "name" => ["required", "string"],
            "email" => ["required", "email", "unique:users,email"],
            "password" => ["required", "confirmed", Password::min(6)],
            "phone_number" => ["required", "string"],
            "city" => ["required", "string"],
            "address" => ["required", "string"],
            "user_type" => ["required", "integer"],
            'profile_image' => 'nullable|image|mimes:png,jpg,jpeg,webp,svg|max:2048',
        ]);


        // Handle the image upload if provided
        if ($request->hasFile('profile_image')) {
            $imagePath = $request->file('profile_image')->store('profiles', 'public');
            $userAttributes['profile_image'] = $imagePath;
        }


        $user = User::create(array_merge($userAttributes, [
            'is_approved' => $request->user_type !== '2', // Automatically approve non-investors
        ]));

        // dd($user->user_type);
        if ($user) {
            Auth::login($user);
            Session::flash('success', 'Registered Successfully');

            // Redirect based on user type
            if ($user->isAdmin()) {
                return redirect()->route('admin.home');

            } elseif ($user->isInvestor()) {
                // Redirect investor to commercial registration page
                return redirect()->route('commercial-registration.create');

            } elseif ($user->isEntrepreneur()) {
                return redirect()->route('entrepreneur.home');

            } else {
                $route = "login";
            }


        } else {
            Session::flash('error', 'Oops! Registration Failed');
            return back()->withInput();
        }
    }
}
