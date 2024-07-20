<?php

namespace App\Policies;

use App\User;
use App\Organization;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrganizationPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Organization $organization = null)
    {
        return $user->role_id == 1;
    }
}
