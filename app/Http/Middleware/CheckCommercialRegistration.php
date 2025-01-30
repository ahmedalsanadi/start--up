<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckCommercialRegistration
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        $excludedRoutes = [
            'commercial-registration.create',
            'commercial-registration.store',
            'pending-commercial-registration',
            'check.registration.status',
            'logout',
            'dashboard'
        ];

        if ($user->isInvestor() && !in_array($request->route()->getName(), $excludedRoutes)) {
            $registration = $user->commercialRegistration;

            if (!$registration) {
                return redirect()->route('commercial-registration.create');
            }

            if ($registration->status !== 'approved') {
                return redirect()->route('pending-commercial-registration');
            }
        }

        return $next($request);
    }
}
