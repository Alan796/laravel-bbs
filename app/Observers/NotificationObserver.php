<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Notifications\DatabaseNotification as Notification;
use App\Events\DatabaseNotificationCreated;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class NotificationObserver
{
    public function created(Notification $notification)
    {
        if ($notification->notifiable_type === User::class) {
            User::where('id', $notification->notifiable_id)->increment('notification_count');
            event(new DatabaseNotificationCreated($notification));
        }
    }
}