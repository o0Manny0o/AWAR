<?php

namespace App\Policies;

use App\Authorisation\Enum\CentralModule;
use App\Authorisation\Enum\PermissionType;
use App\Models\OrganisationApplication;
use App\Models\User;

class OrganisationApplicationPolicy extends BasePolicy
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
        OrganisationApplication $organisationApplication,
    ): bool {
        return $user->hasPermissionTo(
            PermissionType::READ->for(
                CentralModule::ORGANISATION_APPLICATIONS->value,
            ),
        ) || $this->isOwner($user, $organisationApplication);
    }

    function isOwner(User $user, $entity): bool
    {
        return $user->id === $entity->user_id;
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
    public function update(
        User $user,
        OrganisationApplication $organisationApplication,
    ): bool {
        return $this->isOwner($user, $organisationApplication) &&
            !$organisationApplication->isLocked();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(
        User $user,
        OrganisationApplication $organisationApplication,
    ): bool {
        return $this->isOwner($user, $organisationApplication) &&
            !$organisationApplication->isLocked() &&
            $organisationApplication->deleted_at == null;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(
        User $user,
        OrganisationApplication $organisationApplication,
    ): bool {
        return $this->isOwner($user, $organisationApplication) &&
            !$organisationApplication->isLocked() &&
            $organisationApplication->deleted_at !== null;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(
        User $user,
        OrganisationApplication $organisationApplication,
    ): bool {
        return $this->isOwner($user, $organisationApplication) &&
            !$organisationApplication->isLocked();
    }

    /**
     * Determine whether the user can submit the model.
     */
    public function submit(
        User $user,
        OrganisationApplication $organisationApplication,
    ): bool {
        return $this->isOwner($user, $organisationApplication) &&
            !$organisationApplication->isLocked() &&
            $organisationApplication->isComplete();
    }
}
