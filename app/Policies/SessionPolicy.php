<?php

namespace App\Policies;

use App\Models\AccessLevel;
use App\Models\User;
use App\Models\Session;
use Illuminate\Auth\Access\HandlesAuthorization;

class SessionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the session.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Session  $session
     * @return mixed
     */
    public function update(User $user, Session $session)
    {
        return $user->hasPermission(AccessLevel::ADMIN) || $session->dungeonMaster->id === $user->id;
    }

    /**
     * Determine whether the user can delete the session.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Session  $session
     * @return mixed
     */
    public function delete(User $user, Session $session)
    {
        return $user->hasPermission(AccessLevel::ADMIN) || $session->dungeonMaster->id === $user->id;
    }
}
