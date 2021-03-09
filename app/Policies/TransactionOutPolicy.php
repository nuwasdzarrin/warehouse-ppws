<?php

namespace App\Policies;

use App\User;
use App\TransactionOut;

/**
 * TransactionOut Policy
 */
class TransactionOutPolicy extends ModelPolicy
{
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
