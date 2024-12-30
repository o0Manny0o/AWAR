<?php

namespace App\Policies;

use App\Authorisation\Enum\OrganisationModule;
use App\Authorisation\Enum\PermissionType;
use App\Models\Tenant\Member;
use App\Models\User;

class MemberPolicy extends BasePolicy
{
    function isOwner(User $user, $entity): bool
    {
        return true;
    }

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
    public function view(User $user, Member $member): bool
    {
        return $user->hasPermissionTo(
            PermissionType::READ->for(OrganisationModule::MEMBERS->value),
        );
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
    public function update(User $user, Member $member): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Member $member): bool
    {
        return $user->hasPermissionTo(
            PermissionType::UPDATE->for(OrganisationModule::MEMBERS->value),
        );
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Member $member): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Member $member): bool
    {
        return false;
    }
}
