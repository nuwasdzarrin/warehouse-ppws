<?php

namespace App\Policies;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Role Policy
 */
class ModelPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view list of model.
     *
     * @param User $user
     * @param null $parent
     * @return mixed
     */
    public function index(User $user, $parent = null)
    {
        $allow = true;
        if ($parent) $allow = $allow && $user->can('view', $parent);
        return $allow;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Model $model
     * @param null $parent
     * @return mixed
     */
    public function view(User $user, $model, $parent = null)
    {
        $allow = true;
        if ($parent) $allow = $allow && $user->can('view', $parent);
        return $allow;
    }

    /**
     * Determine whether the user can create model.
     *
     * @param User $user
     * @param null $parent
     * @return mixed
     */
    public function create(User $user, $parent = null)
    {
        $allow = true;
        if ($parent) $allow = $allow && $user->can('update', $parent);
        return $allow;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Model $model
     * @param null $parent
     * @return mixed
     */
    public function update(User $user, $model, $parent = null)
    {
        $allow = true;
        if ($parent) $allow = $allow && $user->can('update', $parent);
        return $allow;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Model $model
     * @param null $parent
     * @return mixed
     */
    public function delete(User $user, $model, $parent = null)
    {
        $allow = true;
        if ($parent) $allow = $allow && $user->can('update', $parent);
        return $allow;
    }

    /**
     * Determine whether the user can restore the contact.
     *
     * @param User $user
     * @param Model $model
     * @return mixed
     */
    public function restore(User $user, $model, $parent = null)
    {
        $allow = true;
        if ($parent) $allow = $allow && $user->can('update', $parent);
        return $allow;
    }

    /**
     * Determine whether the user can permanently delete the contact.
     *
     * @param User $user
     * @param Model $model
     * @return mixed
     */
    public function forceDelete(User $user, $model, $parent = null)
    {
        $allow = true;
        if ($parent) $allow = $allow && $user->can('update', $parent);
        return $allow;
    }
}
