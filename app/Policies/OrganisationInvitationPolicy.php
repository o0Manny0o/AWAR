<?php

namespace App\Policies;

use App\Models\Tenant\OrganisationInvitation;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class OrganisationInvitationPolicy extends BasePolicy
{

    function isOwner(User $user, $entity): bool
    {
      return $user->asMember()?->id === $entity->member_id;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, OrganisationInvitation $organisationInvitation): bool
    {
        return $this->isAdmin($user);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $this->isAdmin($user);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, OrganisationInvitation $organisationInvitation): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, OrganisationInvitation $organisationInvitation): bool
    {
        return false;
    }

    /**
     * Determine whether the user can resend the model.
     */
    public function resend(User $user, OrganisationInvitation $organisationInvitation): bool
    {
        return $this->isAdmin($user) && $organisationInvitation->sent_at->diffInHours(now()) > 3;
    }

}
