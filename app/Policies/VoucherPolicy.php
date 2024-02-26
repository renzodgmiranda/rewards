<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Voucher;

class VoucherPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('voucherView') || $user->id == 1;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Voucher $permission)
    {
        return $user->hasPermissionTo('voucherView') || $user->id == 1;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('voucherCreate') || $user->id == 1;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Voucher $permission)
    {
        return $user->hasPermissionTo('voucherEdit') || $user->id == 1;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Voucher $permission)
    {
        return $user->hasPermissionTo('voucherDelete') || $user->id == 1;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Voucher $permission)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Voucher $permission)
    {
        //
    }
}
