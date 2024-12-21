<?php

namespace App\Policies;

use App\Enum\SelfDisclosure\SelfDisclosureStep;
use App\Models\SelfDisclosure\UserSelfDisclosure;
use App\Models\User;
use App\Services\SelfDisclosureService;
use Illuminate\Database\Eloquent\Model;

class UserSelfDisclosurePolicy extends BasePolicy
{
    function isOwner(User $user, UserSelfDisclosure|Model $entity): bool
    {
        return $entity->global_user_id === $user->global_id;
    }

    function useWizard(User $user): bool
    {
        $service = app(SelfDisclosureService::class);
        $disclosure = $service->getDisclosure($user);
        return $disclosure->furthest_step !==
            SelfDisclosureStep::COMPLETE->value;
    }
}
