<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the user.
     *
     * @param  \App\Models\User  $updater
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function update(User $updater, User $user)
    {
        return $updater->access_level > $user->access_level;
    }
}
