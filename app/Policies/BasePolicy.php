<?php

namespace App\Policies;

use App\Authorisation\Enum\CentralRole;
use App\Authorisation\Enum\OrganisationRole;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

abstract class BasePolicy
{
    protected function isOrganisationAdmin(User $user): bool
    {
        if ($this->isSuperAdmin($user)) {
            return true;
        }

        return $user->hasRole(OrganisationRole::ADMIN);
    }

    protected function isCentralAdmin(User $user): bool
    {
        if ($this->isSuperAdmin($user)) {
            return true;
        }

        return $user->hasRole(CentralRole::ADMIN);
    }

    protected function isSuperAdmin(User $user): bool
    {
        // Super-Admins are admins in all contexts
        $sessionTeam = getPermissionsTeamId();
        setPermissionsTeamId(global_cache()->get('public_tenant')->id);
        $user->unsetRelation('roles')->unsetRelation('permissions');
        $isSuperAdmin = $user->hasRole(CentralRole::SUPER_ADMIN);
        setPermissionsTeamId($sessionTeam);
        $user->unsetRelation('roles')->unsetRelation('permissions');

        return $isSuperAdmin;
    }

    protected function isMember(User $user): bool
    {
        if (tenancy()->initialized) {
            return !!$user->whereHas('tenants', function (Builder $query) {
                $query->where('organisations.id', tenant('id'));
            });
        }
        return false;
    }

    abstract function isOwner(User $user, Model $entity): bool;

    public function viewAny(User $user): bool
    {
        return $this->isSuperAdmin($user);
    }
}
