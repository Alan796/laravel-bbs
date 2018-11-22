<?php

namespace App\Observers;

use App\Models\User;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class UserObserver
{
    public function saving(User $user)
    {
        if (!$user->avatar) {
            $user->avatar = config('app.url').'/images/avatars/PtDKbASVcz.png';
        }
    }
}