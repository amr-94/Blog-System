<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    //
    public function index()
    {
        $user = Auth::user();
        return view('allnotifcation', [
            'notifications' => $user->notifications

        ]);
    }
    public function read($id)
    {
        $user = Auth::user();
        $notify = $user->notifications()->find($id);
        if ($notify && $notify->unread()) {
            $notify->markAsread();
        }
        return redirect()->to($notify->data['url']);
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $notification = $user->notifications->find($id);
        $notification->destroy($id);
        return redirect(route('notifay.index'));
    }
    public function destroyall()
    {
        $user = Auth::user();
        $notification = $user->notifications();
        $notification->delete();
        return redirect(route('notifay.index'));
    }
}
