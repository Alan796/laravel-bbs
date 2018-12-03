<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $fillable = ['likable_id', 'likable_type'];


    public function likable()
    {
        return $this->morphTo();
    }
}
