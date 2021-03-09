<?php

namespace App\Policies;

use App\User;

/**
 * User Policy
 */
class UserPolicy extends ModelPolicy
{
    /**
     * Determine whether the user can create model.
     *
     * @param User $user
     * @param null $parent
     * @return mixed
     */
    public function create(User $user, $parent = null)
    {
        $allow = !$user->hasRole(['staff']);
        if ($parent) $allow = $allow && $user->can('create', $parent);
        return $allow;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param User $model
     * @param null $parent
     * @return mixed
     */
    public function update(User $user, $model, $parent = null)
    {
        $allow = (!$user->hasRole(['staff'])) || ($user->getKey() === $model->getKey());
        if ($parent) $allow = $allow && $user->can('update', $parent);
        return $allow;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param User $model
     * @param null $parent
     * @return mixed
     */
    public function delete(User $user, $model, $parent = null)
    {
        $allow = !$user->hasRole(['staff']);
        if ($parent) $allow = $allow && $user->can('delete', $parent);
        return $allow;
    }
}
