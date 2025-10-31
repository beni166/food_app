<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $notifications = $request->user()->notifications;
        return view('user.notification.index', compact('notifications'));
    }

    public function markAsRead($id, Request $request)
    {
        $notification = $request->user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        return back()->with('success', 'Notification marquée comme lue.');
    }


public function show($id)
{
    $notification = auth()->user()->notifications()->findOrFail($id);

    // Marquer comme lu automatiquement si ce n’est pas déjà fait
    if (is_null($notification->read_at)) {
        $notification->markAsRead();
    }

    return view('user.notification.read', compact('notification'));
}
   
}
