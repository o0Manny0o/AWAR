<?php

namespace App\Enum;

use App\Traits\HasValues;

enum DefaultTenantUserRole: string
{
    use HasValues;
    case MEMBER = 'member';
    case ADMIN = 'admin';
    case ADOPTION_LEAD = 'adoption-lead';
    case ADOPTION_HANDLER = 'adoption-handler';
    case FOSTER_HOME_LEAD = 'foster-home-lead';
    case FOSTER_HOME_HANDLER = 'foster-home-handler';
    case FOSTER_HOME = 'foster-home';

    function permissions(): array
    {
        return match ($this) {
            self::ADMIN => TenantPermission::values(),
            self::ADOPTION_LEAD => [
                TenantPermission::SEE_ALL_ANIMALS->value,
                TenantPermission::EDIT_ALL_ANIMALS->value,
                TenantPermission::DELETE_ANIMALS->value,
                TenantPermission::PUBLISH_ANIMALS->value,
                TenantPermission::UNPUBLISH_ANIMALS->value,
            ],
            self::ADOPTION_HANDLER => [
                TenantPermission::SEE_ASSIGNED_ANIMALS->value,
                TenantPermission::EDIT_ASSIGNED_ANIMALS->value,
            ],
            self::FOSTER_HOME => [
                TenantPermission::SEE_FOSTERED_ANIMALS->value,
            ],
            default => [],
        };
    }
}
