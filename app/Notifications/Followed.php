<?php

namespace App\Notifications;

use App\Models\Follow;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class Followed extends Notification implements ShouldQueue
{
    use Queueable;

    protected $follow, $follower;  //follow实例、关注者实例

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Follow $follow)
    {
        $this->follow = $follow;
        $this->follower = $follow->follower;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }


    public function toDatabase($notifiable)
    {
        return [
            'follower_id' => $this->follower->id,
            'follower_name' => $this->follower->name,
            'follower_avatar' => $this->follower->avatar,
            'follow_at' => $this->follow->created_at,
        ];
    }
}
