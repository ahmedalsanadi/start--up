<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckCommercialRegistration
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        if ($user->isInvestor()) {
            $registration = $user->commercialRegistration; 

            if (!$registration) {
                return redirect()->route('commercial-registration.create');
            }

            if ($registration->status !== 'approved') {
                return redirect()->route('registration-pending');
            }
        }

        return $next($request);
    }
}
