<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $notifications = $request->user()->notifications;
        return view('Admin.Notification.index', compact('notifications'));
    }

    public function MarkAsRead($id, Request $request)
    {
        $notification = $request->user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        return back()->with('success', 'Notification marquée comme lue.');
    }

    public function show($id)
{
    $notification = auth()->user()->notifications()->findOrFail($id);

    if (is_null($notification->read_at)) {
        $notification->markAsRead();
    }

    return view('Admin.Notification.read', compact('notification'));
}
}
