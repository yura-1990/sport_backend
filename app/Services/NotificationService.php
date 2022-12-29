<?php

namespace App\Services;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationService
{
    public function create($title, $body=[], $user_id=[])
    {
        $model = new Notification();
        $model->fill([
            'title' => $title,
            'body' => $body,
            'user_id' => $user_id[0],
        ]);
        $model->save();
    }

    public function getAll()
    {
        return Notification::query()->get();
    }

    public function getUserUnreadNotifications()
    {
        return Notification::query()->newOnly()->where('user_id', Auth::id())->get();
    }

    public function setNotificationAsRead(Notification $notification)
    {
        $notification->is_read = true;
        $notification->save();
    }

}
