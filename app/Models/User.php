<?php

namespace App\Models;

use App\Notifications\Register;
use App\Notifications\ResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'introduction', 'avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function sendRegisterNotification($token, $email, $expireAt)
    {
        $this->fill(['email' => $email])->notify(new Register($token, $email, $expireAt));
    }


    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }
}
