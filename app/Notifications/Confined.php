<?php

namespace App\Notifications;

use App\Models\Confinement;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class Confined extends Notification implements ShouldQueue
{
    use Queueable;

    protected $confinement, $confiner;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Confinement $confinement)
    {
        $this->confinement = $confinement;
        $this->confiner = $confinement->confiner;
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
            'is_permanent' => $this->confinement->is_permanent,
            'confiner_id' => $this->confiner->id,
            'confiner_name' => $this->confiner->name,
            'confiner_avatar' => $this->confiner->avatar,
            'confined_at' => $this->confinement->confined_at->toDateTimeString(),
            'expired_at' => $this->confinement->expired_at->toDateTimeString(),
            'text' => '你已被管理员禁言',
        ];
    }
}
