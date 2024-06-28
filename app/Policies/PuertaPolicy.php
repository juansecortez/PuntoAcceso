<?php
namespace App\Policies;

use App\User;
use App\Puerta;
use Illuminate\Auth\Access\HandlesAuthorization;

class PuertaPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any puertas.
     *
     * @param  \App\User  $user
     * @return boolean
     */
    public function viewAny(User $user)
    {
        return $user->isAdmin() || $user->isCreator() || $user->isMember();
    }

    /**
     * Determine whether the user can view the puerta.
     *
     * @param  \App\User  $user
     * @param  \App\Puerta  $puerta
     * @return boolean
     */
    public function view(User $user, Puerta $puerta)
    {
        return $user->isAdmin() || $user->isCreator() || $user->isMember();
    }

    /**
     * Determine whether the user can create puertas.
     *
     * @param  \App\User $user
     * @return boolean
     */
    public function create(User $user)
    {
        return $user->isAdmin() || $user->isCreator();
    }

    /**
     * Determine whether the user can update the puerta.
     *
     * @param  \App\User  $user
     * @param  \App\Puerta  $puerta
     * @return boolean
     */
    public function update(User $user, Puerta $puerta)
    {
        return $user->isAdmin() || $user->isCreator();
    }

    /**
     * Determine whether the user can delete the puerta.
     *
     * @param  \App\User  $user
     * @param  \App\Puerta  $puerta
     * @return boolean
     */
    public function delete(User $user, Puerta $puerta)
    {
        return $user->isAdmin() || $user->isCreator();
    }
}
