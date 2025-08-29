<?php

namespace App\Policies;

use App\Models\TestRequest;
use App\Models\User;

class TestRequestPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('read testrequest');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, TestRequest $testrequest): bool
    {
        return $user->can('read testrequest');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create testrequest');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, TestRequest $testrequest): bool
    {
        return $user->can('update testrequest');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TestRequest $testrequest): bool
    {
        return $user->can('delete testrequest');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, TestRequest $testrequest): bool
    {
        // usually same as delete
        return $user->can('delete testrequest');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, TestRequest $testrequest): bool
    {
        // usually same as delete
        return $user->can('delete testrequest');
    }
}
