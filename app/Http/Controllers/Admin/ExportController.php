<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Services\ExportService;
use Illuminate\Http\Request;
use App\Models\Announcement;
use App\Models\User;
use App\Models\Idea;

class ExportController extends Controller
{
    protected $exportService;

    public function __construct(ExportService $exportService)
    {
        $this->exportService = $exportService;
    }

    public function export(Request $request, $type)
    {
        $data = $this->getDataForExport($request, $type);
        return $this->exportService->export($data, $type);
    }

    protected function getDataForExport(Request $request, $type)
    {
        switch ($type) {
            case 'announcement':
                return $this->getAnnouncementsQuery($request)->get();
            case 'user':
                return $this->getUsersQuery($request)->get();
            case 'idea':
                return $this->getIdeasQuery($request)->get();
            default:
                abort(404);
        }
    }

    protected function getAnnouncementsQuery($request)
    {
        $query = Announcement::with('investor')->latest();

        if ($request->filled('search')) {
            $query->where('description', 'like', "%{$request->search}%");
        }

        if ($request->filled('status')) {
            $query->where('approval_status', $request->status);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        return $query;
    }

    protected function getUsersQuery($request)
    {
        $query = User::withCount([
            'announcements' => function ($query) {
                $query->where('user_type', 2); // Only count announcements for investors
            },
            'ideas' => function ($query) {
                $query->where('user_type', 3); // Only count ideas for entrepreneurs
            },
        ])->latest();

        // Apply filters
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone_number', 'like', "%{$search}%");
            });
        }

        if ($request->filled('user_type')) {
            $query->where('user_type', $request->input('user_type'));
        }

        if ($request->filled('is_active')) {
            $query->where('is_active', $request->input('is_active'));
        }

        return $query;
    }

    protected function getIdeasQuery($request)
    {
        $query = Idea::latest();
        // Add filters as needed
        return $query;
    }
}
