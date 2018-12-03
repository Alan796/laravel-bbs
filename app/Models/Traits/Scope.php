<?php

namespace App\Models\Traits;

trait Scope
{
    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
}
