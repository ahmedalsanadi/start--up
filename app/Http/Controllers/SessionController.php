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
        // Validate the login credentials
        $attributes = request()->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'البريد الإلكتروني مطلوب.',
            'email.email' => 'يجب أن يكون البريد الإلكتروني صالحًا.',
            'password.required' => 'كلمة المرور مطلوبة.',
        ]);

        // Attempt to authenticate the user
        if (!Auth::attempt($attributes)) {
            throw ValidationException::withMessages([
                'email' => 'عذرًا، بيانات الاعتماد هذه غير متطابقة.',
            ]);
        }

        // Get the authenticated user
        $user = Auth::user();

        // Check if the user is active
        if (!$user->is_active) {
            // Log the user out immediately
            Auth::logout();

            // Throw a validation error
            throw ValidationException::withMessages([
                'email' => 'حسابك غير نشط. يرجى التواصل مع مدير النظام.',
            ]);
        }

        // Regenerate the session ID for security
        request()->session()->regenerate();

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

        // Default redirect
        return redirect('/');
    }

    public function destroy(Request $request)
    {
        Auth::logout();

        // Invalidate the session and regenerate the CSRF token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
