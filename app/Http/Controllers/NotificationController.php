<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{

    /**
     * Display a listing of all notifications for the authenticated user.
     */
    public function index(Request $request)
    {
        // Fetch all notifications for the authenticated user
        $notifications = Auth::user()->notifications()->paginate(10);

        // Mark all notifications as read when the page is loaded
        Auth::user()->unreadNotifications->markAsRead();

        return view('notifications.index', compact('notifications'));
    }

    /**
     * Mark all notifications as read for the authenticated user.
     */
    public function markAllAsRead(Request $request)
    {
        $request->user()->unreadNotifications->markAsRead();

        return response()->json(['success' => true]);
    }

    /**
     * Mark a single notification as read.
     */
    public function markAsRead(Request $request, DatabaseNotification $notification)
    {
        // Ensure the notification belongs to the authenticated user
        if ($notification->notifiable_id === $request->user()->id) {
            $notification->markAsRead();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 403);
    }

    public function unreadCount(Request $request)
    {
        // Ensure the user is authenticated
        if (!$request->user()) {
            return response()->json(['success' => false], 401);
        }

        // Fetch the unread notification count
        $unreadCount = $request->user()->unreadNotifications->count();
        return response()->json(['unreadCount' => $unreadCount]);
    }
}
