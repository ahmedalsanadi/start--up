<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserType
{
    public function handle(Request $request, Closure $next, $type)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to access this page.');
        }

        $user = Auth::user();

        $typeMap = [
            'admin' => 'isAdmin',
            'investor' => 'isInvestor',
            'entrepreneur' => 'isEntrepreneur'
        ];

        if (!isset($typeMap[$type]) || !$user->{$typeMap[$type]}()) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }

            return redirect()->route('dashboard')
                ->with('error', 'You are not authorized to access this page.');
        }

        return $next($request);
    }
}
