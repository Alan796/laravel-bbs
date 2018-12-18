<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Reply;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReplyPolicy
{
    use HandlesAuthorization, Traits\ManageContents;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }


    public function destroy(User $currentUser, Reply $reply)
    {
        return $currentUser->isAuthorOf($reply);
    }
}
