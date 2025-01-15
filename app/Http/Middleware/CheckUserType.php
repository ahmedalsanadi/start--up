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
                    return redirect('/'); // Redirect if not an admin
                }
                break;

            case 'investor':
                if (!$user->isInvestor()) {
                    return redirect('/'); // Redirect if not an investor
                }
                break;

            case 'entrepreneur':
                if (!$user->isEntrepreneur()) {
                    return redirect('/'); // Redirect if not an entrepreneur
                }
                break;

            default:
                return redirect('/'); // Default fallback
        }

        return $next($request);
    }
}
