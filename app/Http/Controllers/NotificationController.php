<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Display notifications for authenticated user
     */
    public function index()
    {
        $user = Auth::user();

        // Get all notifications for the user
        $notifications = $user->notifications;

        // Get unread count
        $unreadCount = $user->unread_notification_count;

        return view('user.notifications', compact('notifications', 'user', 'unreadCount'));
    }

    /**
     * Mark a single notification as read
     */
    public function markAsRead($id)
    {
        $notification = Notification::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $notification->markAsRead();

        return response()->json([
            'success' => true,
            'message' => 'Notification marked as read'
        ]);
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead()
    {
        Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json([
            'success' => true,
            'message' => 'All notifications marked as read'
        ]);
    }

    /**
     * Delete a single notification
     */
    public function delete($id)
    {
        $notification = Notification::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $notification->delete();

        return response()->json([
            'success' => true,
            'message' => 'Notification deleted'
        ]);
    }

    /**
     * Get unread notification count (for AJAX badge update)
     */
    public function getUnreadCount()
    {
        $count = Auth::user()->unread_notification_count ?? 0;

        return response()->json([
            'count' => $count,
        ]);
    }

    /**
     * Delete all read notifications
     */
    public function deleteAll()
    {
        Notification::where('user_id', Auth::id())
            ->where('is_read', true)
            ->delete();

        return response()->json([
            'success' => true,
            'message' => 'All read notifications deleted'
        ]);
    }
}
