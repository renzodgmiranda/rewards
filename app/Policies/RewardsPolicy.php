<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Rewards;
use Illuminate\Auth\Access\Response;

class RewardsPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('rewardsView') || $user->id == 1;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Rewards $permission)
    {
        return $user->hasPermissionTo('rewardsView') || $user->id == 1;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('rewardsCreate') || $user->id == 1;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Rewards $permission)
    {
        return $user->hasPermissionTo('rewardsEdit') || $user->id == 1;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Rewards $permission)
    {
        return $user->hasPermissionTo('rewardsDelete') || $user->id == 1;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Rewards $permission)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Rewards $permission)
    {
        //
    }
}
