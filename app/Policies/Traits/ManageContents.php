<?php

namespace App\Policies\Traits;

trait ManageContents
{
    public function before($user, $ability)
    {
        if ($user->can('manage contents')) {
            return true;
        }
    }
}