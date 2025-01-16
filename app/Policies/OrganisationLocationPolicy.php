<?php

namespace App\Policies;

use App\Authorisation\Enum\OrganisationModule;
use App\Authorisation\Enum\PermissionType;
use App\Models\Tenant\OrganisationLocation;
use App\Models\User;

class OrganisationLocationPolicy extends BasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo(
            PermissionType::READ->for(OrganisationModule::LOCATIONS->value),
        );
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(
        User $user,
        OrganisationLocation $organisationLocation,
    ): bool {
        return $user->hasPermissionTo(
            PermissionType::READ->for(OrganisationModule::LOCATIONS->value),
        ) && $this->belongsToOrganisation($organisationLocation);
    }

    private function belongsToOrganisation(OrganisationLocation $location): bool
    {
        if (tenancy()->initialized) {
            return $location->organisation_id === tenant()->id;
        }
        return false;
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
        return $user->hasPermissionTo(
            PermissionType::CREATE->for(OrganisationModule::LOCATIONS->value),
        );
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(
        User $user,
        OrganisationLocation $organisationLocation,
    ): bool {
        return $user->hasPermissionTo(
            PermissionType::UPDATE->for(OrganisationModule::LOCATIONS->value),
        ) && $this->belongsToOrganisation($organisationLocation);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(
        User $user,
        OrganisationLocation $organisationLocation,
    ): bool {
        return $user->hasPermissionTo(
            PermissionType::DELETE->for(OrganisationModule::LOCATIONS->value),
        ) && $this->belongsToOrganisation($organisationLocation);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(
        User $user,
        OrganisationLocation $organisationLocation,
    ): bool {
        return $user->hasPermissionTo(
            PermissionType::RESTORE->for(OrganisationModule::LOCATIONS->value),
        ) && $this->belongsToOrganisation($organisationLocation);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(
        User $user,
        OrganisationLocation $organisationLocation,
    ): bool {
        return $user->hasPermissionTo(
            PermissionType::FORCE_DELETE->for(
                OrganisationModule::LOCATIONS->value,
            ),
        ) && $this->belongsToOrganisation($organisationLocation);
    }

    function isOwner(User $user, $entity): bool
    {
        return false;
    }
}
