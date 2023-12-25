<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Application;
use Illuminate\Auth\Access\HandlesAuthorization;

class ApplicationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the application can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list applications');
    }

    /**
     * Determine whether the application can view the model.
     */
    public function view(User $user, Application $model): bool
    {
        return $user->hasPermissionTo('view applications');
    }

    /**
     * Determine whether the application can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create applications');
    }

    /**
     * Determine whether the application can update the model.
     */
    public function update(User $user, Application $model): bool
    {
        return $user->hasPermissionTo('update applications');
    }

    /**
     * Determine whether the application can delete the model.
     */
    public function delete(User $user, Application $model): bool
    {
        return $user->hasPermissionTo('delete applications');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete applications');
    }

    /**
     * Determine whether the application can restore the model.
     */
    public function restore(User $user, Application $model): bool
    {
        return false;
    }

    /**
     * Determine whether the application can permanently delete the model.
     */
    public function forceDelete(User $user, Application $model): bool
    {
        return false;
    }
}
