<?php

namespace App\Policies;

use App\User;
use App\Contrato;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContratoPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any contratos.
     *
     * @param  \App\User  $user
     * @return boolean
     */
    public function viewAny(User $user)
    {
        return $user->isAdmin() || $user->isCreator() || $user->isMember();
    }

    /**
     * Determine whether the user can view the contrato.
     *
     * @param  \App\User  $user
     * @param  \App\Contrato  $contrato
     * @return boolean
     */
    public function view(User $user, Contrato $contrato)
    {
        return $user->isAdmin() || $user->isCreator() || $user->isMember();
    }

    /**
     * Determine whether the user can create contratos.
     *
     * @param  \App\User $user
     * @return boolean
     */
    public function create(User $user)
    {
        return $user->isAdmin() || $user->isCreator();
    }

    /**
     * Determine whether the user can update the contrato.
     *
     * @param  \App\User  $user
     * @param  \App\Contrato  $contrato
     * @return boolean
     */
    public function update(User $user, Contrato $contrato)
    {
        return $user->isAdmin() || $user->isCreator();
    }

    /**
     * Determine whether the authenticate user can manage contratos.
     *
     * @param  \App\User  $user
     * @return boolean
     */
    public function manageContratos(User $user)
    {
        return $user->isAdmin() || $user->isCreator();
    }

    /**
     * Determine whether the user can delete the contrato.
     *
     * @param  \App\User  $user
     * @param  \App\Contrato  $contrato
     * @return boolean
     */
    public function delete(User $user, Contrato $contrato)
    {
        return $user->isAdmin() || $user->isCreator();
    }
}
