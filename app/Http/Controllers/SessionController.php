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

        // Get the intended URL if it exists
        $intended = session()->pull('url.intended', null);

        if ($intended) {
            return redirect()->to($intended);
        }

        // Redirect based on user type
        if ($user->isAdmin()) {
            return redirect()->route('admin.home');
        } elseif ($user->isInvestor()) {
            $commercialRegistration = $user->commercialRegistration;

            if (!$commercialRegistration) {
                return redirect()->route('commercial-registration.create');
            } elseif ($commercialRegistration->status == 'pending') {
                return redirect()->route('pending-commercial-registration');
            } elseif ($commercialRegistration->status === 'approved') {
                return redirect()->route('investor.home');
            } else {
                return redirect()->route('commercial-registration.create');
            }
        } elseif ($user->isEntrepreneur()) {
            return redirect()->route('entrepreneur.home');
        }

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
