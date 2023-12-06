<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Promotion;
use Illuminate\Auth\Access\HandlesAuthorization;

class PromotionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the promotion can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list promotions');
    }

    /**
     * Determine whether the promotion can view the model.
     */
    public function view(User $user, Promotion $model): bool
    {
        return $user->hasPermissionTo('view promotions');
    }

    /**
     * Determine whether the promotion can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create promotions');
    }

    /**
     * Determine whether the promotion can update the model.
     */
    public function update(User $user, Promotion $model): bool
    {
        return $user->hasPermissionTo('update promotions');
    }

    /**
     * Determine whether the promotion can delete the model.
     */
    public function delete(User $user, Promotion $model): bool
    {
        return $user->hasPermissionTo('delete promotions');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete promotions');
    }

    /**
     * Determine whether the promotion can restore the model.
     */
    public function restore(User $user, Promotion $model): bool
    {
        return false;
    }

    /**
     * Determine whether the promotion can permanently delete the model.
     */
    public function forceDelete(User $user, Promotion $model): bool
    {
        return false;
    }
}
