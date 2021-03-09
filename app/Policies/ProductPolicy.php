<?php

namespace App\Policies;

use App\User;
use App\Product;

/**
 * Product Policy
 */
class ProductPolicy extends ModelPolicy
{
    /**
     * Determine whether the user can approve the contact.
     *
     * @param User $user
     * @param Product $model
     * @return mixed
     */
    public function adjust(User $user, $model, $parent = null)
    {
        $allow = $user->hasRole(['admin']);
        if ($parent) $allow = $allow && $user->can('adjust', $parent);
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
        $allow = !$user->hasRole(['staff']);
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
