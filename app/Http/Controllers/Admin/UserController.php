<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // Get user statistics
        $statistics = [
            'totalActiveUsers' => User::where('is_active', 1)->count(),
            'totalInactiveUsers' => User::where('is_active', 0)->count(),
            'totalInvestors' => User::where('user_type', 2)->count(),
            'totalEntrepreneurs' => User::where('user_type', 3)->count()
        ];

        $query = User::query();

        // Search filter
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function (Builder $query) use ($searchTerm) {
                $query->where('name', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('email', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('phone_number', 'LIKE', "%{$searchTerm}%");
            });
        }

        // User type filter
        if ($request->filled('user_type')) {
            $query->where('user_type', $request->user_type);
        }

        // Active status filter
        if ($request->filled('is_active')) {
            $query->where('is_active', $request->is_active);
        }

        // Get paginated results
        $users = $query->latest()
                      ->paginate(10)
                      ->withQueryString(); // Maintains filter parameters in pagination links

        return view('admin.users.index', compact('users', 'statistics'));
    }

    public function show(User $user)
    {
        $user->load(['commercialRegistration', 'announcements', 'ideas']);

        // Get statistics based on user type
        $statistics = [];

        if ($user->isInvestor()) {
            $statistics = [
                'total_announcements' => $user->announcements()->count(),
                'active_announcements' => $user->announcements()->where('status', 'in-progress')->count(),
                'completed_announcements' => $user->announcements()->where('status', 'completed')->count(),
                'total_budget' => $user->announcements()->sum('budget'),
            ];
        } elseif ($user->isEntrepreneur()) {
            $statistics = [
                'total_ideas' => $user->ideas()->count(),
                'approved_ideas' => $user->ideas()->where('approval_status', 'approved')->count(),
                'pending_ideas' => $user->ideas()->where('approval_status', 'pending')->count(),
                'total_budget_requested' => $user->ideas()->sum('budget'),
            ];
        }

        return view('admin.users.show', compact('user', 'statistics'));
    }

    public function toggleActive(User $user)
    {
        // Toggle the is_active status
        $user->update([
            'is_active' => !$user->is_active,
        ]);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'تم تعديل حالة المستخدم بنجاح');
    }
}
