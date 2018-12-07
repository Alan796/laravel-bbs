<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    public function follower()
    {
        return $this->belongsTo(User::class);
    }


    public function followee()
    {
        return $this->belongsTo(User::class);
    }
}
