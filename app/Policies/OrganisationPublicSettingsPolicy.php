<?php

namespace App\Policies;

use App\Models\Tenant\OrganisationPublicSettings;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class OrganisationPublicSettingsPolicy extends BasePolicy
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
    public function view(
        User $user,
        OrganisationPublicSettings $organisationSettings,
    ): bool {
        return $this->isMember($user) &&
            $this->isAdmin($user) &&
            $this->belongsToOrganisation($organisationSettings);
    }

    private function belongsToOrganisation(
        OrganisationPublicSettings $location,
    ): bool {
        if (tenancy()->initialized) {
            return $location->organisation_id === tenant()->id;
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(
        User $user,
        OrganisationPublicSettings $organisationSettings,
    ): bool {
        return $this->isMember($user) &&
            $this->isAdmin($user) &&
            $this->belongsToOrganisation($organisationSettings);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(
        User $user,
        OrganisationPublicSettings $organisationSettings,
    ): bool {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(
        User $user,
        OrganisationPublicSettings $organisationSettings,
    ): bool {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(
        User $user,
        OrganisationPublicSettings $organisationSettings,
    ): bool {
        return false;
    }

    function isOwner(User $user, Model $entity): bool
    {
        return false;
    }
}
