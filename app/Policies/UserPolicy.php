<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;

class UserPolicy
{
    use HandlesAuthorization;

    public function update(User $currentUser, User $user)
    {
        if ($currentUser->is_admin) {
            return true;
        }
        return $currentUser->id === $user->id;
    }

    public function destroy(User $currentUser, User $user)
    {
        if ($user->is_admin) {
            return false;
        } elseif ($currentUser->is_admin) {
            return true;
        }
        return $currentUser->id === $user->id;
    }
    public function follow(User $currentUser, User $user)
    {
        return $currentUser->id !== $user->id;
    }
}
