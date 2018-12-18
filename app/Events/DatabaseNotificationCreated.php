<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\DatabaseNotification as Notification;

class DatabaseNotificationCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $notification;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Notification $notification)
    {
        $this->notification = $notification;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('User.'.$this->notification->notifiable_id);
    }


    public function broadcastWith()
    {
        return [
            'notification_count' => $this->notification->notifiable->notification_count,
            'data' => [
                'text' => $this->text(),
                'url' => $this->url(),
            ],
        ];
    }


    protected function text()
    {
        return $this->notification->data['text'] ? : '你有新的通知';
    }


    protected function url()
    {
        return route('notifications.index').'#'.$this->notification->id;
    }
}
