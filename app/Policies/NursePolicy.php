<?php

namespace App\Policies;

use App\Models\Nurse;
use App\Models\User;

class NursePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('read nurse');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Nurse $nurse): bool
    {
        return $user->can('read nurse');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create nurse');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Nurse $nurse): bool
    {
        return $user->can('update nurse');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Nurse $nurse): bool
    {
        return $user->can('delete nurse');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Nurse $nurse): bool
    {
        // usually same as delete
        return $user->can('delete nurse');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Nurse $nurse): bool
    {
        // usually same as delete
        return $user->can('delete nurse');
    }
}
