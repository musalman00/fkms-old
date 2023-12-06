<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Kiosk;
use Illuminate\Auth\Access\HandlesAuthorization;

class KioskPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the kiosk can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list kiosks');
    }

    /**
     * Determine whether the kiosk can view the model.
     */
    public function view(User $user, Kiosk $model): bool
    {
        return $user->hasPermissionTo('view kiosks');
    }

    /**
     * Determine whether the kiosk can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create kiosks');
    }

    /**
     * Determine whether the kiosk can update the model.
     */
    public function update(User $user, Kiosk $model): bool
    {
        return $user->hasPermissionTo('update kiosks');
    }

    /**
     * Determine whether the kiosk can delete the model.
     */
    public function delete(User $user, Kiosk $model): bool
    {
        return $user->hasPermissionTo('delete kiosks');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete kiosks');
    }

    /**
     * Determine whether the kiosk can restore the model.
     */
    public function restore(User $user, Kiosk $model): bool
    {
        return false;
    }

    /**
     * Determine whether the kiosk can permanently delete the model.
     */
    public function forceDelete(User $user, Kiosk $model): bool
    {
        return false;
    }
}
