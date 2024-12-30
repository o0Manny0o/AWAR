<?php

namespace App\Authorisation;

use App\Models\Organisation;
use App\Models\User;

class PermissionContext
{
    /**
     * Run a callback in the tenant permission context.
     * Atomic, safely reverts to previous context.
     *
     * @param User $user
     * @param Organisation $organisation
     * @param callable $callback
     * @return mixed
     */
    public static function tenant(
        User $user,
        callable $callback,
        Organisation $organisation = null,
    ): mixed {
        if (!$organisation) {
            $organisation = tenant();
        }
        $sessionTeam = getPermissionsTeamId();
        setPermissionsTeamId($organisation);
        $user->unsetRelation('roles')->unsetRelation('permissions');

        $result = $callback($user);

        if ($sessionTeam) {
            setPermissionsTeamId($sessionTeam);
            $user->unsetRelation('roles')->unsetRelation('permissions');
        }

        return $result;
    }

    /**
     * Run a callback in the central permission context.
     * Atomic, safely reverts to previous context.
     *
     * @param callable $callback
     * @return mixed
     */
    public static function central(User $user, callable $callback): mixed
    {
        $sessionTeam = getPermissionsTeamId();

        $publicId = global_cache()->get('public_tenant')?->id;
        setPermissionsTeamId($publicId);
        $user->unsetRelation('roles')->unsetRelation('permissions');

        $result = $callback($user);

        if ($sessionTeam) {
            setPermissionsTeamId($sessionTeam);
            $user->unsetRelation('roles')->unsetRelation('permissions');
        }

        return $result;
    }
}
