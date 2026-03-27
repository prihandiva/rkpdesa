<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function markAsRead($id)
    {
        $user = auth()->user() ?? \App\Models\User::find(session('user_id'));
        
        if ($user) {
            $notification = $user->unreadNotifications->where('id', $id)->first();
            if ($notification) {
                $notification->markAsRead();
                return redirect($notification->data['url'] ?? '#');
            }
        }
        
        return back();
    }

    public function markAllAsRead()
    {
        $user = auth()->user() ?? \App\Models\User::find(session('user_id'));
        
        if ($user) {
            $user->unreadNotifications->markAsRead();
        }
        
        return back();
    }
}
