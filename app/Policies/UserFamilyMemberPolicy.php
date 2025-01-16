<?php

namespace App\Policies;

use App\Models\SelfDisclosure\UserFamilyMember;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class UserFamilyMemberPolicy extends BasePolicy
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
        return $this->isOwner($user, $userFamilyMember);
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
        return $this->isOwner($user, $userFamilyMember);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, UserFamilyMember $userFamilyMember): bool
    {
        return $this->isOwner($user, $userFamilyMember);
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

    function isOwner(User $user, UserFamilyMember|Model $entity): bool
    {
        return $entity->selfDisclosure()->first()?->user_id === $user->id;
    }
}
