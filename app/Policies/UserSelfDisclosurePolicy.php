<?php

namespace App\Policies;

use App\Models\SelfDisclosure\UserSelfDisclosure;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class UserSelfDisclosurePolicy extends BasePolicy
{
    function isOwner(User $user, UserSelfDisclosure|Model $entity): bool
    {
        return $entity->global_user_id === $user->global_id;
    }

    function useWizard(User $user): bool
    {
        $disclosure = UserSelfDisclosure::ofUser($user)->first();
        return $disclosure->furthest_step !== null;
    }
}
