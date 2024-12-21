<?php

namespace App\Policies;

use App\Models\Tenant\OrganisationLocation;
use App\Models\User;

class OrganisationLocationPolicy extends BasePolicy
{
    private function belongsToOrganisation(OrganisationLocation $location): bool
    {
        if (tenancy()->initialized) {
            return $location->organisation_id === tenant()->id;
        }
        return false;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $this->isMember($user);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(
        User $user,
        OrganisationLocation $organisationLocation,
    ): bool {
        return $this->isMember($user) &&
            $this->belongsToOrganisation($organisationLocation);
    }

    /**
     * Determine whether the user can view the public model.
     */
    public function viewPublic(
        User $user,
        OrganisationLocation $organisationLocation,
    ): bool {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $this->isAdmin($user);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(
        User $user,
        OrganisationLocation $organisationLocation,
    ): bool {
        return $this->isAdmin($user) &&
            $this->belongsToOrganisation($organisationLocation);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(
        User $user,
        OrganisationLocation $organisationLocation,
    ): bool {
        return $this->isAdmin($user) &&
            $this->belongsToOrganisation($organisationLocation);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(
        User $user,
        OrganisationLocation $organisationLocation,
    ): bool {
        return $this->isAdmin($user) &&
            $this->belongsToOrganisation($organisationLocation);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(
        User $user,
        OrganisationLocation $organisationLocation,
    ): bool {
        return $this->isAdmin($user) &&
            $this->belongsToOrganisation($organisationLocation);
    }

    function isOwner(User $user, $entity): bool
    {
        return $this->isAdmin($user);
    }
}
