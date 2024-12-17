<?php

namespace App\Policies;

use App\Models\SelfDisclosure\UserFamilyMember;
use App\Models\User;

class UserFamilyMemberPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, UserFamilyMember $userFamilyMember): bool
    {
        return $userFamilyMember->selfDisclosure()->first()?->global_user_id ===
            $user->global_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, UserFamilyMember $userFamilyMember): bool
    {
        return $userFamilyMember->selfDisclosure()->first()?->global_user_id ===
            $user->global_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, UserFamilyMember $userFamilyMember): bool
    {
        return $userFamilyMember->selfDisclosure()->first()?->global_user_id ===
            $user->global_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(
        User $user,
        UserFamilyMember $userFamilyMember,
    ): bool {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(
        User $user,
        UserFamilyMember $userFamilyMember,
    ): bool {
        return false;
    }
}
