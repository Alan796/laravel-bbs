<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Confinement extends Model
{
    public $timestamps = false;

    protected $dates = ['confined_at', 'expired_at'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function confiner()
    {
        return $this->belongsTo(User::class, 'confined_by');
    }


    public function scopeEffective($query)
    {
        return $query->where('is_abolished', false)
            ->where(function($query) {
                $query->where('is_permanent', true)->orWhereRaw('expired_at >= now()');
            });
    }
}
