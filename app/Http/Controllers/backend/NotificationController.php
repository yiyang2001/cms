<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::orderBy('created_at', 'desc')->get();
        return view('notifications.index', compact('notifications'));
    }

    public function markAsRead(Request $request, $id)
    {
        $notification = Notification::findOrFail($id);
        $notification->markAsRead();
        return redirect()->back()->with('success', 'Notification marked as read.');
    }

    public function delete(Request $request, $id)
    {
        $notification = Notification::findOrFail($id);
        $notification->delete();
        return redirect()->back()->with('success', 'Notification deleted.');
    }

    public function renderNavbar()
    {
        $notifications = Notification::orderBy('created_at', 'desc')->take(5)->get();
        // $notificationsCount = Notification::count();

        return view('backend.layouts.navbar', compact('notifications', 'notificationsCount'));
    }
}
