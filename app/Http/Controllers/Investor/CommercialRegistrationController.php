<?php

namespace App\Http\Controllers\Investor;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\CommercialRegistration;

class CommercialRegistrationController extends Controller
{

    public function index()
    {


    }

    public function create()
    {
        return view('investor.commercial-registration.create');
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

        return redirect()->route('registration-pending');
    }


}

