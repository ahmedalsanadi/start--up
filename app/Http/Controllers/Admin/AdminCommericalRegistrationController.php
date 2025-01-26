<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CommercialRegistration;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Http\Request;


use App\Traits\NotificationTrait;


class AdminCommericalRegistrationController extends Controller
{
    use NotificationTrait;

    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function index(Request $request)
    {
        // Start the query
        $registrations = CommercialRegistration::with('user')
            ->latest();

        // Apply status filter
        if ($request->filled('status')) {
            $registrations->where('status', $request->status);
        }

        // Apply search filter by registration number or user name or email
        if ($request->filled('search')) {
            $search = $request->input('search');
            $registrations->where(function ($query) use ($search) {
                $query->where('registration_number', 'like', "%{$search}%")
                      ->orWhereHas('user', function ($q) use ($search) {
                          $q->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                      });
            });
        }

        // Apply date range filter
        if ($request->filled('date_from')) {
            $registrations->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $registrations->whereDate('created_at', '<=', $request->date_to);
        }

        // Paginate the results
        $registrations = $registrations->paginate(10);

        return view('admin.commercial-registrations.index', compact('registrations'));
    }

    public function show(CommercialRegistration $registration)
    {
        $registration->load('user');
        return view('admin.commercial-registrations.show', compact('registration'));
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



    // Notify investor registration owner
        $this->notificationService->notify($registration->user, [
            'type' => 'registration_status_update',
            'title' => 'تم التحقق من السجل التجاري',
            'message' => "تم " . ($validated['status'] == 'approved' ? 'الموافقة على' : 'رفض') . " السجل التجاري الخاص بك.",
            'action_type' => 'registration_status',
            'action_id' => $registration->id,
            'initiator_id' => auth()->id(),
            'initiator_type' => 'admin',
            'additional_data' => [
                'status' => $validated['status'],
                'rejection_reason' => $validated['rejection_reason'] ?? null
            ],
        ]);
        return back()->with('success', 'تم تحديث حالة التسجيل بنجاح');
    }
}
