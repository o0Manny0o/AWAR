<?php

namespace App\Policies;

use App\Enum\CentralUserRole;
use App\Enum\DefaultTenantUserRole;
use App\Models\Tenant\Member;
use App\Models\User;
use function Symfony\Component\Translation\t;

class BasePolicy
{
    public function before(User $user): ?true
    {
        if ($user->hasRole(CentralUserRole::SUPER_ADMIN)) {
            return true;
        }

        if (tenancy()) {
            /** @var Member $member */
            $member = Member::find($user->id);
            return $member?->hasRole(DefaultTenantUserRole::ADMIN);
        } else {
            return $user->hasRole(CentralUserRole::ADMIN);
        }
    }
}
