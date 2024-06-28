<?php

namespace App\Policies;

use App\User;
use App\Empleado;
use Illuminate\Auth\Access\HandlesAuthorization;

class EmpleadoPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any empleados.
     *
     * @param  \App\User  $user
     * @return boolean
     */
    public function viewAny(User $user)
    {
        return $user->isAdmin() || $user->isCreator() || $user->isMember();
    }

    /**
     * Determine whether the user can view the empleado.
     *
     * @param  \App\User  $user
     * @param  \App\Empleado  $empleado
     * @return boolean
     */
    public function view(User $user, Empleado $empleado)
    {
        return $user->isAdmin() || $user->isCreator() || $user->isMember();
    }

    /**
     * Determine whether the user can create empleados.
     *
     * @param  \App\User $user
     * @return boolean
     */
    public function create(User $user)
    {
        return $user->isAdmin() || $user->isCreator();
    }

    /**
     * Determine whether the user can update the empleado.
     *
     * @param  \App\User  $user
     * @param  \App\Empleado  $empleado
     * @return boolean
     */
    public function update(User $user, Empleado $empleado)
    {
        return $user->isAdmin() || $user->isCreator();
    }
     /**
     * Determine whether the authenticate user can manage other users.
     *
     * @param  \App\User  $user
     * @return boolean
     */
    public function manageEmpleados(User $user)
    {
        return $user->isAdmin() || $user->isCreator();
    }
    /**
     * Determine whether the user can delete the empleado.
     *
     * @param  \App\User  $user
     * @param  \App\Empleado  $empleado
     * @return boolean
     */
    public function delete(User $user, Empleado $empleado)
    {
        return $user->isAdmin() || $user->isCreator();
    }
}
