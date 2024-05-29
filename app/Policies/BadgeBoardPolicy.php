<?php

namespace App\Policies;

use App\Models\BadgeBoard;
use App\Models\User;

class BadgeBoardPolicy
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
    public function view(User $user, BadgeBoard $badges): bool
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
    public function update(User $user, BadgeBoard $badges): bool
    {
        return $user->hasPermissionTo('badgePolicy') || $user->id == 1;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, BadgeBoard $badges): bool
    {
        return $user->hasPermissionTo('badgePolicy') || $user->id == 1;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, BadgeBoard $badges)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, BadgeBoard $badges)
    {
        //
    }
}
