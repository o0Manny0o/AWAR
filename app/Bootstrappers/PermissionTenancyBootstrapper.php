<?php

namespace App\Bootstrappers;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Stancl\Tenancy\Contracts\TenancyBootstrapper;
use Stancl\Tenancy\Contracts\Tenant;

class PermissionTenancyBootstrapper implements TenancyBootstrapper
{
    public function bootstrap(Tenant $tenant)
    {
        setPermissionsTeamId($tenant);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function revert()
    {
        $publicId = global_cache()->get('public_tenant')?->id;
        setPermissionsTeamId($publicId);
    }
}
