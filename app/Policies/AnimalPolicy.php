<?php

namespace App\Policies;

use App\Enum\DefaultTenantUserRole;
use App\Models\Animal\Animal;
use App\Models\User;

class AnimalPolicy extends BasePolicy
{
    public function before(User $user): ?false
    {
        if (
            !$user
                ->asMember()
                ->hasAnyRole(
                    DefaultTenantUserRole::ADMIN,
                    DefaultTenantUserRole::ADOPTION_LEAD,
                    DefaultTenantUserRole::ADOPTION_HANDLER,
                    DefaultTenantUserRole::FOSTER_HOME,
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
        return $this->isAdmin($user) ||
            $user->asMember()->hasRole(DefaultTenantUserRole::ADOPTION_LEAD) ||
            $animal->handler_id === $user->global_id;
    }

    function isOwner(User $user, $entity): bool
    {
        return false;
    }
}
