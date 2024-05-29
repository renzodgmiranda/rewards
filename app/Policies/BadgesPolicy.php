<?php

namespace App\Policies;

use App\Models\Badges;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BadgesPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('badgePolicy') || $user->id == 1;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Badges $badges): bool
    {
        return $user->hasPermissionTo('badgePolicy') || $user->id == 1;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('badgePolicy') || $user->id == 1;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Badges $badges): bool
    {
        return $user->hasPermissionTo('badgePolicy') || $user->id == 1;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Badges $badges): bool
    {
        return $user->hasPermissionTo('badgePolicy') || $user->id == 1;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Badges $badges)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Badges $badges)
    {
        //
    }
}
