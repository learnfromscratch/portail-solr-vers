<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        if ($user->role->name === 'SuperAdmin')
        {
            return true;
        }
    }

    public function read(User $user)
    {
        $role = $user->role;
        foreach ($role->permissions as $permission)
        {
            if ($permission->name === 'read')
                return true;
        }
    }

    public function create(User $user)
    {
        $role = $user->role;
        foreach ($role->permissions as $permission)
        {
            if ($permission->name === 'create')
                return true;
        }
    }

    public function update(User $user)
    {
        $role = $user->role;
        foreach ($role->permissions as $permission)
        {
            if ($permission->name === 'update')
                return true;
        }
    }

    public function destroy(User $user)
    {
        $role = $user->role;
        foreach ($role->permissions as $permission)
        {
            if ($permission->name === 'destroy')
                return true;
        }
    }
}
