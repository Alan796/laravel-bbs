<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RegisterValidate extends Mailable
{
    use Queueable, SerializesModels;

    public $token, $email, $expireAt;

    /**
     * Create a new message instance.
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
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.register_validate')->subject('注册验证');
    }
}
