<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;

class UserPolicy
{
    use HandlesAuthorization;

    public function update(User $currentUser, User $user)
    {
        if ($currentUser->id === 1) {
            return true;
        }
        return $currentUser->id === $user->id;
    }
}
