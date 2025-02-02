<?php

namespace App\Http\Controllers\Investor;

use App\Http\Controllers\Controller;

use App\Traits\NotificationTrait;
use Auth;
use Illuminate\Http\Request;
use App\Models\CommercialRegistration;
use App\Services\NotificationService;

class CommercialRegistrationController extends Controller
{
    use NotificationTrait;

    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }


    public function create()
    {
        $commercialRegistration = Auth::user()->commercialRegistration;

        if (!$commercialRegistration) {
            return view('investor.commercial-registration.create');
        }

        return match($commercialRegistration->status) {
            'approved' => redirect()->route('investor.home'),
            'pending' => redirect()->route('pending-commercial-registration'),
            'rejected' => view('investor.commercial-registration.rejected', [
                'reason' => $commercialRegistration->rejection_reason
            ]),
            default => redirect()->route('commercial-registration.create')
        };
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'registration_number' => 'required|string|min:5',
            'registration_number_confirmation' => 'required|same:registration_number',
        ], [
            'registration_number.required' => 'حقل رقم السجل التجاري مطلوب.',
            'registration_number.string' => 'يجب أن يكون رقم السجل التجاري نصًا.',
            'registration_number.min' => 'يجب أن يكون رقم السجل التجاري على الأقل 5 أحرف.',
            'registration_number_confirmation.required' => 'يرجى تأكيد رقم السجل التجاري.',
            'registration_number_confirmation.same' => 'رقم السجل التجاري غير متطابق.',
        ]);

        $registration = Auth::user()->commercialRegistration;

        if ($registration && $registration->status === 'rejected') {
            $registration->update([
                'registration_number' => $validated['registration_number'],
                'status' => 'pending',
                'rejection_reason' => null
            ]);
        } else {
            $registration = CommercialRegistration::create([
                'user_id' => auth()->id(),
                'registration_number' => $validated['registration_number'],
                'status' => 'pending'
            ]);
        }

        // Notify admins about the new registration
        $this->notificationService->notifyAdmins([
            'type' => 'commercial_registration',
            'title' => 'سجل تجاري جديد',
            'message' => "تم إنشاء سجل تجاري جديد من قبل " . auth()->user()->name,
            'action_type' => 'commercial_registration',
            'action_id' => $registration->id,
            'initiator_id' => auth()->id(),
            'initiator_type' => 'investor',
            'additional_data' => [
                'registration_number' => $registration->registration_number
            ],
        ]);

        return redirect()->route('pending-commercial-registration');
    }


    public function displayPendingPage()
    {
        $commercialRegistration = Auth::user()->commercialRegistration;

        if (!$commercialRegistration) {
            return redirect()->route('commercial-registration.create');
        }

        return match($commercialRegistration->status) {
            'approved' => redirect()->route('investor.home'),
            'rejected' => redirect()->route('commercial-registration.create'),
            'pending' => view('investor.pending.registration-pending', [
                'status' => $commercialRegistration->status
            ]),
            default => redirect()->route('commercial-registration.create')
        };
    }

    public function checkStatus()
    {
        $registration = Auth::user()->commercialRegistration;
        return response()->json([
            'status' => $registration->status,
            'rejection_reason' => $registration->rejection_reason
        ]);
    }
}
