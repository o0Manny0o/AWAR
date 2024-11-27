<?php

namespace App\Policies;

use App\Enum\CentralUserRole;
use App\Models\User;

class BasePolicy
{
    public function before(User $user): ?true
    {
        return $user->hasAnyRole([
            CentralUserRole::SUPER_ADMIN,
            CentralUserRole::ADMIN]) ? true : null;
    }
}
