<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;
use Spatie\Permission\Models\Role;

class AssignRoleToNewUser
{
    /**
     * Handle the event.
     *
     * @param  Registered $event
     * @return void
     */
    public function handle(Registered $event)
    {
        // Assuming 'Employee' role exists
        $role = Role::where('name', 'Employee')->first();

        if ($role) {
            $event->user->assignRole($role);
        }
    }
}
