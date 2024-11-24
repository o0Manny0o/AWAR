<?php

namespace App\Policies;

use App\Models\OrganisationApplication;
use App\Models\User;

class OrganisationApplicationPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, OrganisationApplication $organisationApplication): bool
    {
        return $user->id === $organisationApplication->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // TODO: User Profile/Self-Disclosure filled
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, OrganisationApplication $organisationApplication): bool
    {
        return $user->id === $organisationApplication->user_id && !$organisationApplication->isLocked();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, OrganisationApplication $organisationApplication): bool
    {
        return $user->id === $organisationApplication->user_id && !$organisationApplication->isLocked();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, OrganisationApplication $organisationApplication): bool
    {
        return $user->id === $organisationApplication->user_id && !$organisationApplication->isLocked();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, OrganisationApplication $organisationApplication): bool
    {
        return $user->id === $organisationApplication->user_id && !$organisationApplication->isLocked();
    }

    /**
     * Determine whether the user can submit the model.
     */
    public function submit(User $user, OrganisationApplication $organisationApplication): bool
    {
        return $user->id === $organisationApplication->user_id && $organisationApplication->isComplete() && !$organisationApplication->isLocked();
    }
}
