<?php

namespace App\Policies;

use App\Authorisation\Enum\OrganisationModule;
use App\Authorisation\Enum\PermissionType;
use App\Models\Animal\Animal;
use App\Models\User;

class AnimalPolicy extends BasePolicy
{
    public function before(User $user): ?bool
    {
        if (
            !$user->hasPermissionTo(
                PermissionType::READ->for(OrganisationModule::ANIMALS->value),
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
        return $user->hasPermissionTo(
            PermissionType::READ->for(OrganisationModule::ANIMALS->value),
        );
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo(
            PermissionType::CREATE->for(OrganisationModule::ANIMALS->value),
        );
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Animal $animal): bool
    {
        if (
            $user->hasPermissionTo(
                PermissionType::UPDATE->for(OrganisationModule::ANIMALS->value),
            )
        ) {
            return true;
        } elseif (
            $user->hasPermissionTo(
                PermissionType::UPDATE->for(
                    OrganisationModule::ASSIGNED_ANIMALS->value,
                ),
            )
        ) {
            return $this->isOwner($user, $animal);
        } else {
            return false;
        }
    }

    function isOwner(User $user, $entity): bool
    {
        return $entity->handler_id === $user->id ||
            $entity->foster_home_id === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Animal $animal): bool
    {
        if (
            $user->hasPermissionTo(
                PermissionType::DELETE->for(OrganisationModule::ANIMALS->value),
            )
        ) {
            return true;
        } elseif (
            $user->hasPermissionTo(
                PermissionType::DELETE->for(
                    OrganisationModule::ASSIGNED_ANIMALS->value,
                ),
            )
        ) {
            return $this->isOwner($user, $animal);
        } else {
            return false;
        }
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
        if (
            $user->hasPermissionTo(
                PermissionType::ASSIGN->for(OrganisationModule::ANIMALS->value),
            )
        ) {
            return true;
        } elseif (
            $user->hasPermissionTo(
                PermissionType::ASSIGN->for(
                    OrganisationModule::ASSIGNED_ANIMALS->value,
                ),
            )
        ) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can assign a handler to the animal.
     */
    public function assignLocation(User $user, Animal $animal): bool
    {
        if (
            $user->hasPermissionTo(
                PermissionType::ASSIGN->for(OrganisationModule::ANIMALS->value),
            )
        ) {
            return true;
        } elseif (
            $user->hasPermissionTo(
                PermissionType::ASSIGN->for(
                    OrganisationModule::ASSIGNED_ANIMALS->value,
                ),
            )
        ) {
            return $this->isOwner($user, $animal);
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can assign a handler to the animal.
     */
    public function assignFosterHome(User $user, Animal $animal): bool
    {
        if (
            $user->hasPermissionTo(
                PermissionType::ASSIGN->for(OrganisationModule::ANIMALS->value),
            )
        ) {
            return true;
        } elseif (
            $user->hasPermissionTo(
                PermissionType::ASSIGN->for(
                    OrganisationModule::ASSIGNED_ANIMALS->value,
                ),
            )
        ) {
            return $this->isOwner($user, $animal);
        } else {
            return false;
        }
    }
}
