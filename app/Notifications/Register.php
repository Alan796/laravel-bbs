<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class Register extends Notification implements ShouldQueue
{
    use Queueable;

    protected $token;
    protected $email;
    protected $expireAt;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token, $email, $expireAt)
    {
        $this->token = $token;
        $this->email = $email;
        $this->expireAt = $expireAt;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('注册验证')
                    ->line('感谢使用'.config('app.name').'，请在'.$this->expireAt.'前点击链接完成注册')
                    ->action('继续注册', url(route('users.validateEmail', [$this->token, $this->email], false)));
    }
}
