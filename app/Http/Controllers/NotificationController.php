<?php

namespace App\Http\Controllers;

use App\Models\AppNotification;
use App\Services\NotificationService;

class NotificationController extends Controller
{
    public function __construct(private NotificationService $service) {}

    public function index()
    {
        $notifications = auth()->user()->appNotifications()->latest()->paginate(20);
        return view('notifications.index', compact('notifications'));
    }

    public function markRead(AppNotification $notification)
    {
        abort_unless($notification->user_id === auth()->id(), 403);
        $notification->markAsRead();
        return back();
    }

    public function markAllRead()
    {
        $this->service->markAllRead(auth()->user());
        return back()->with('success', 'All notifications marked as read.');
    }

    public function destroy(AppNotification $notification)
    {
        abort_unless($notification->user_id === auth()->id(), 403);
        $notification->delete();
        return back();
    }
}
