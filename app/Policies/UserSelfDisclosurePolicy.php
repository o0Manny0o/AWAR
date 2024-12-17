<?php

namespace App\Policies;

use App\Models\User;

class UserSelfDisclosurePolicy extends BasePolicy
{
    function isOwner(User $user, $entity): bool
    {
        return $entity->global_user_id === $user->global_id;
    }

    function useWizard(User $user): true
    {
        // TODO: Only allow wizard if not completely filled out yet
        return true;
    }
}
