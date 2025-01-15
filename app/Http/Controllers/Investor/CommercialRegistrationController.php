<?php

namespace App\Http\Controllers\Investor;

use App\Http\Controllers\Controller;

use Auth;
use Illuminate\Http\Request;
use App\Models\CommercialRegistration;

class CommercialRegistrationController extends Controller
{

    public function create()
    {
        $commercialRegistration = Auth::user()->commercialRegistration;

        // Check if commercialRegistration exists
        if (!$commercialRegistration) {
            return view('investor.commercial-registration.create');
        }
        else
        {

            $status = $commercialRegistration->status;
            if($status == 'approved')
            {
                return redirect()->route('investor.dashboard');
            }

            if($status == 'pending')
            {
                return redirect()->route('pending-commercial-registration');
            }


        }

    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'registration_number' => 'required|string|min:5',
            'registration_number_confirmation' => 'required|same:registration_number',
        ]);

        $registration = CommercialRegistration::create([
            'user_id' => auth()->id(),
            'registration_number' => $validated['registration_number'],
            'status' => 'pending'
        ]);

        return redirect()->route('pending-commercial-registration');
    }

    public function displayPendingPage()
    {

        $status = Auth::user()->commercialRegistration->status;
        if($status == 'approved')
        {

            return redirect()->route('investor.dashboard');
        }

        return view('investor.pending.registration-pending' , ['status' => $status]);
    }

    public function checkStatus()
{
    $status = Auth::user()->commercialRegistration->status;
    return response()->json(['status' => $status]);
}


}

