<?php

namespace App\Policies;

use App\Models\User;
use App\Models\KioskParticipant;
use Illuminate\Auth\Access\HandlesAuthorization;

class KioskParticipantPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the kioskParticipant can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list kioskparticipants');
    }

    /**
     * Determine whether the kioskParticipant can view the model.
     */
    public function view(User $user, KioskParticipant $model): bool
    {
        return $user->hasPermissionTo('view kioskparticipants');
    }

    /**
     * Determine whether the kioskParticipant can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create kioskparticipants');
    }

    /**
     * Determine whether the kioskParticipant can update the model.
     */
    public function update(User $user, KioskParticipant $model): bool
    {
        return $user->hasPermissionTo('update kioskparticipants');
    }

    /**
     * Determine whether the kioskParticipant can delete the model.
     */
    public function delete(User $user, KioskParticipant $model): bool
    {
        return $user->hasPermissionTo('delete kioskparticipants');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete kioskparticipants');
    }

    /**
     * Determine whether the kioskParticipant can restore the model.
     */
    public function restore(User $user, KioskParticipant $model): bool
    {
        return false;
    }

    /**
     * Determine whether the kioskParticipant can permanently delete the model.
     */
    public function forceDelete(User $user, KioskParticipant $model): bool
    {
        return false;
    }
}
