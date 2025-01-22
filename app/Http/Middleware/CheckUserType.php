<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $type
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $type)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login'); // Redirect to login if no user is authenticated
        }

        switch ($type) {
            case 'admin':
                if (!$user->isAdmin()) {
                    abort(403, 'You are not authorized to visit this page.'); // Return 403 Forbidden
                }
                break;

            case 'investor':
                if (!$user->isInvestor()) {
                    abort(403, 'You are not authorized to visit this page.'); // Return 403 Forbidden
                }
                break;

            case 'entrepreneur':
                if (!$user->isEntrepreneur()) {
                    abort(403, 'You are not authorized to visit this page.'); // Return 403 Forbidden
                }
                break;

            default:
                abort(403, 'You are not authorized to visit this page.'); // Default fallback
        }

        return $next($request);
    }
}
