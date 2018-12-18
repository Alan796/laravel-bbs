<?php

namespace App\Notifications;

use App\Models\Like;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class Liked extends Notification implements ShouldQueue
{
    use Queueable;

    protected $like, $user, $likable; //点赞实例、点赞者实例、被点赞的实例

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Like $like)
    {
        $this->like = $like;
        $this->user = $like->user;
        $this->likable = $like->likable;
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
        $data = [
            'likable_id' => $this->likable->id,
            'likable_type' => $this->like->likable_type,
            'user_id' => $this->user->id,
            'user_name' => $this->user->name,
            'user_avatar' => $this->user->avatar,
        ];

        switch (class_basename($this->like->likable_type)) {
            case 'Post':
                $data['likable_title'] = $this->likable->title;
                $data['likable_url'] = $this->likable->link();
                $data['likable_name'] = '帖子';
                break;

            case 'Reply':
                $data['likable_title'] = $this->likable->body;
                $data['likable_url'] = route('replies.show', $this->likable->id).'#reply'.$this->likable->id;
                $data['likable_name'] = '评论';
                break;
        }

        $data['text'] = $this->user->name.' 赞了你的'.$data['likable_name'];

        return $data;
    }
}
