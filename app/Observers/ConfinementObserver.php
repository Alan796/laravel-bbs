<?php

namespace App\Observers;

use App\Models\Confinement;
use App\Notifications\Confined;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class ConfinementObserver
{
    public function created(Confinement $confinement)
    {
        $confinement->user->notify(new Confined($confinement));
    }
}