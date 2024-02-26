<?php

namespace App\Policies;

use App\Models\User;
use App\Models\RedeemHistory;
use Illuminate\Auth\Access\Response;

class RedeemHistoryPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('redeemHistoryView') || $user->id == 1;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, RedeemHistory $permission)
    {
        return $user->hasPermissionTo('redeemHistoryView') || $user->id == 1;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('redeemHistoryCreate') || $user->id == 1;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, RedeemHistory $permission)
    {
        return $user->hasPermissionTo('redeemHistoryEdit') || $user->id == 1;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, RedeemHistory $permission)
    {
        return $user->hasPermissionTo('redeemHistoryDelete') || $user->id == 1;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, RedeemHistory $permission)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, RedeemHistory $permission)
    {
        //
    }
}
