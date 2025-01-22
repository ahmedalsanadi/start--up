<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class SessionController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store()
    {
        $attributes = request()->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (!Auth::attempt($attributes)) {
            throw ValidationException::withMessages([
                'email' => 'Sorry, those credentials do not match.',
            ]);
        }

        request()->session()->regenerate();

        $user = Auth::user();

        // Redirect based on user type
        if ($user->isAdmin()) {
            return redirect()->route('admin.home');
        } elseif ($user->isInvestor()) {
            // Check the investor's commercial registration status
            $commercialRegistration = $user->commercialRegistration;

            if (!$commercialRegistration) {
                // Redirect to the commercial registration page if no registration exists
                return redirect()->route('commercial-registration.create');
            } elseif ($commercialRegistration->status == 'pending') {
                // Redirect to the pending page if the registration is pending
                return redirect()->route('pending-commercial-registration');
            } elseif ($commercialRegistration->status === 'approved') {
                // Redirect to the investor dashboard if the registration is approved
                return redirect()->route('investor.home');
            } elseif ($commercialRegistration->status === 'rejected') {
                // Redirect to the commercial registration page if the registration is rejected
                return redirect()->route('commercial-registration.create');
            }
        } elseif ($user->isEntrepreneur()) {
            return redirect()->route('entrepreneur.home');
        }

        // Fallback if user type is not recognized
        return redirect('/');
    }

    public function destroy(Request $request)
    {
        Auth::logout();

        // To logout on other devices
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
