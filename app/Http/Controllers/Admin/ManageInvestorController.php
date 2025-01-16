<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CommercialRegistration;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use App\Notifications\RegistrationStatusUpdated;

use App\Traits\NotificationTrait;


class ManageInvestorController extends Controller
{
    use NotificationTrait;

    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function index()
    {
        $registrations = CommercialRegistration::with('user')
            ->latest()
            ->paginate(10);

        return view('admin.investors.index', compact('registrations'));
    }

    public function show(CommercialRegistration $registration)
    {
        $registration->load('user');
        return view('admin.investors.show', compact('registration'));
    }

    public function updateRegistrationStatus(Request $request, CommercialRegistration $registration)
    {
        $validated = $request->validate([
            'status' => 'required|in:approved,rejected',
            'rejection_reason' => 'required_if:status,rejected|nullable|string|max:500'
        ]);

        $registration->update([
            'status' => $validated['status'],
            'rejection_reason' => $validated['status'] === 'rejected' ? $validated['rejection_reason'] : null,
            'reviewed_at' => now(),
            'reviewed_by' => auth()->id()
        ]);


        // $registration->user->notify(new RegistrationStatusUpdated($registration));
        // Notify investor registration owner
        $this->notificationService->notify($registration->user, [
            'type' => 'registration_status_update',
            'title' => 'Registration Status Updated',
            'message' => "Your registration has been {$validated['status']}",
            'action_type' => 'registration_status',
            'action_id' => $registration->id,
            'initiator_id' => auth()->id(),
            'initiator_type' => 'admin',
            'additional_data' => [
                'status' => $validated['status'],
                'rejection_reason' => $validated['rejection_reason'] ?? null
            ],
        ]);

        return back()->with('success', 'Registration status updated successfully');
    }
}
