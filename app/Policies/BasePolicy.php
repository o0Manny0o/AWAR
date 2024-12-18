<?php

namespace App\Policies;

use App\Enum\CentralUserRole;
use App\Enum\DefaultTenantUserRole;
use App\Models\User;

abstract class BasePolicy
{
    protected function isAdmin(User $user): bool
    {
        // Super-Admins are admins in all contexts
        if ($user->hasRole(CentralUserRole::SUPER_ADMIN)) {
            return true;
        }

        if (tenancy()->initialized) {
            return $user->member?->hasRole(DefaultTenantUserRole::ADMIN) ??
                false;
        } else {
            return $user->hasRole(CentralUserRole::ADMIN);
        }
    }

    protected function isMember(User $user): bool
    {
        if (tenancy()->initialized) {
            return !!$user->member;
        }
        return false;
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
