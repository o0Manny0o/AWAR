<?php

namespace App\Policies;

use App\Models\Address;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class AddressPolicy extends BasePolicy
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
    public function view(User $user, Address $address): bool
    {
        return $this->isOwner($user, $address);
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
    public function update(User $user, Address $address): bool
    {
        return $this->isOwner($user, $address);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Address $address): bool
    {
        return $this->isOwner($user, $address);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Address $address): bool
    {
        return $this->isOwner($user, $address);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Address $address): bool
    {
        return $this->isOwner($user, $address);
    }

    function isOwner(User $user, Model|Address $entity): bool
    {
        return $entity->addressable_type === User::class &&
            $entity->addressable_id === $user->id;
    }
}
