<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserNotificationsController extends Controller
{
    /**
     * UserNotificationsController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Gets all the user's notifications.
     *
     * @param \App\Models\User $user
     * @return mixed
     * @author Brandon Abbasspour <babbassp@umflint.edu>
     */
    public function index(User $user)
    {
        return auth()->user()->unreadNotifications;
    }

    /**
     * Marks a user's notification as read.
     *
     * @param \App\Models\User $user
     * @param int              $notificationId
     * @author Brandon Abbasspour <babbassp@umflint.edu>
     */
    public function destroy(User $user, $notificationId)
    {
        auth()->user()->notifications()->findOrFail($notificationId)->markAsRead();
    }
}
