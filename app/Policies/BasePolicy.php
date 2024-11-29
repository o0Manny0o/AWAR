<?php

namespace App\Policies;

use App\Enum\CentralUserRole;
use App\Enum\DefaultTenantUserRole;
use App\Models\Tenant\Member;
use App\Models\User;

abstract class BasePolicy
{
    public function before(User $user): ?true
    {
        if ($user->hasRole(CentralUserRole::SUPER_ADMIN)) {
            return true;
        }

        return null;
    }

    protected function isAdmin(User $user): bool
    {
        if (tenancy()->initialized) {
            /** @var Member $member */
            $member = Member::find($user->id);
            return $member?->hasRole(DefaultTenantUserRole::ADMIN) ?? false;
        } else {
            return $user->hasRole(CentralUserRole::ADMIN);
        }
    }

    protected function isAdminOrOwner($user, $entity): bool
    {
        return $this->isAdmin($user) || $this->isOwner($user, $entity);
    }

    abstract function isOwner(User $user, $entity): bool;

    public function viewAny(User $user): bool
    {
        return $this->isAdmin($user);
    }
}
