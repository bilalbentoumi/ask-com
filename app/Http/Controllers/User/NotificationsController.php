<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function read(Request $request)
    {
        $notification = Notification::findOrFail($request->id);

        if (Auth::user()->id == $notification->user_id) {
            $notification->read = true;
            $notification->save();
        }
    }

    public function get()
    {
        return view('user.notifications.notification');
    }
}
