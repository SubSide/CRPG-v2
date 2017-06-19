<?php

namespace App\Policies;

use App\Models\AccessLevel;
use App\Models\Character;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CharacterPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the session.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Character  $character
     * @return mixed
     */
    public function update(User $user, Character $character)
    {
        return $user->hasPermission(AccessLevel::ADMIN) || $character->user->id === $user->id;
    }

    /**
     * Determine whether the user can delete the session.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Character  $character
     * @return mixed
     */
    public function delete(User $user, Character $character)
    {
        return $user->hasPermission(AccessLevel::ADMIN) || $character->user->id === $user->id;
    }
}
