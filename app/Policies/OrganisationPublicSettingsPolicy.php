<?php

namespace App\Policies;

use App\Authorisation\Enum\OrganisationModule;
use App\Authorisation\Enum\PermissionType;
use App\Models\Tenant\OrganisationPublicSettings;
use App\Models\User;

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
        return $user->hasPermissionTo(
            PermissionType::READ->for(
                OrganisationModule::PUBLIC_SETTINGS->value,
            ),
        ) && $this->belongsToOrganisation($organisationSettings);
    }

    private function belongsToOrganisation(
        OrganisationPublicSettings $settings,
    ): bool {
        if (tenancy()->initialized) {
            return $settings->organisation_id === tenant()->id;
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
        return $user->hasPermissionTo(
            PermissionType::UPDATE->for(
                OrganisationModule::PUBLIC_SETTINGS->value,
            ),
        ) && $this->belongsToOrganisation($organisationSettings);
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
}
