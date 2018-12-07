<?php

namespace App\Notifications;

use App\Models\Reply;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PostReplied extends Notification implements ShouldQueue
{
    use Queueable;

    protected $reply, $replier, $post;  //评论实例、评论者实例、帖子实例

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Reply $reply)
    {
        $this->reply = $reply;
        $this->replier = $reply->user;
        $this->post = $reply->post;
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
            'reply_id' => $this->reply->id,
            'reply_body' => $this->reply->body,
            'reply_at' => $this->reply->created_at,
            'replier_id' => $this->replier->id,
            'replier_name' => $this->reply->user->name,
            'replier_avatar' => $this->reply->user->avatar,
            'post_id' => $this->post->id,
            'post_title' => $this->post->title,
            'post_url' => $this->post->link(['#reply'.$this->reply->id]),
        ];
    }
}
