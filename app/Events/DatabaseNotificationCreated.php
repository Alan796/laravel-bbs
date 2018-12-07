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
        switch (class_basename($this->notification->type)) {
            case 'Followed':
                return '新的粉丝：'.$this->notification->data['follower_name'];

            case 'PostCreated':
                return $this->notification->data['user_name'].' 发布了新的帖子';

            case 'PostReplied':
                return $this->notification->data['replier_name'].' 评论了你的帖子';

            case 'ReplyReplied':
                return $this->notification->data['replier_name'].' 回复了你的评论';

            case 'Liked':
                return $this->notification->data['user_name'].' 赞了你的'.$this->notification->data['likable_name'];

            default:
                return '你有新的通知';
        }
    }


    protected function url()
    {
        return route('notifications.index').'#'.$this->notification->id;
    }
}
