<?php

namespace App\Policies;

use App\Authorisation\Enum\OrganisationModule;
use App\Authorisation\Enum\PermissionType;
use App\Models\Animal\AnimalListing;
use App\Models\User;

class AnimalListingPolicy
{
    public function before(User $user): ?bool
    {
        if (
            !$user->hasPermissionTo(
                PermissionType::READ->for(OrganisationModule::LISTINGS->value),
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
    public function view(User $user, AnimalListing $animalListing): bool
    {
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
    public function update(User $user, AnimalListing $animalListing): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, AnimalListing $animalListing): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, AnimalListing $animalListing): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, AnimalListing $animalListing): bool
    {
        return false;
    }
}
