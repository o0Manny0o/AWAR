<?php

namespace App\Policies;

use App\Authorisation\Enum\OrganisationRole;
use App\Models\Animal\Animal;
use App\Models\User;

class AnimalPolicy extends BasePolicy
{
    public function before(User $user): ?bool
    {
        if ($this->isOrganisationAdmin($user)) {
            return true;
        }

        if (
            !$user->hasAnyRole(
                OrganisationRole::ANIMAL_LEAD,
                OrganisationRole::ANIMAL_HANDLER,
                OrganisationRole::FOSTER_HOME,
            )
        ) {
            return false;
        }
        return null;
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
    public function view(User $user, Animal $animal): bool
    {
        return true;
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
    public function update(User $user, Animal $animal): bool
    {
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Animal $animal): bool
    {
        return true;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Animal $animal): bool
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Animal $animal): bool
    {
        return true;
    }

    /**
     * Determine whether the user can publish the animal.
     */
    public function publish(User $user, Animal $animal): bool
    {
        return $animal->published_at === null;
    }

    /**
     * Determine whether the user can assign a handler to the animal.
     */
    public function assign(User $user, Animal $animal): bool
    {
        return $this->isLeadOrHandler($user, $animal);
    }

    function isLeadOrHandler(User $user, Animal $animal): bool
    {
        return $user->hasRole(OrganisationRole::ANIMAL_LEAD) ||
            $animal->handler_id === $user->global_id;
    }

    public function assignFosterHome(User $user, Animal $animal): bool
    {
        return $this->isLeadOrHandler($user, $animal);
    }

    public function assignLocation(User $user, Animal $animal): bool
    {
        return $this->isLeadOrHandler($user, $animal);
    }

    function isOwner(User $user, $entity): bool
    {
        return false;
    }
}
