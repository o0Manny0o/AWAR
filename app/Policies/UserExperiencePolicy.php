<?php

namespace App\Policies;

use App\Models\SelfDisclosure\UserExperience;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class UserExperiencePolicy
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
    public function view(User $user, UserExperience $userExperience): bool
    {
        return $this->isOwner($user, $userExperience);
    }

    function isOwner(User $user, UserExperience|Model $entity): bool
    {
        return $entity->selfDisclosure()->first()?->user_id === $user->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        $experiences = $user->load('selfDisclosure.userExperiences')
            ->selfDisclosure->userExperiences;
        return $user->selfDisclosure()->exists() && $experiences->count() < 5;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, UserExperience $userExperience): bool
    {
        return $this->isOwner($user, $userExperience);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, UserExperience $userExperience): bool
    {
        return $this->isOwner($user, $userExperience);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, UserExperience $userExperience): bool
    {
        return $this->isOwner($user, $userExperience);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(
        User $user,
        UserExperience $userExperience,
    ): bool {
        return false;
    }
}
