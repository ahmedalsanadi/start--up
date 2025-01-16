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
            return redirect()->route('admin.index');
        } elseif ($user->isInvestor()) {
            return redirect('/investor');
        } elseif ($user->isEntrepreneur()) {
            return redirect('/entrepreneur');
        }

        // Fallback if user type is not recognized
        return redirect('/');
    }
    public function destroy(Request $request)
    {
        Auth::logout();

        //to logout on other devices
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
