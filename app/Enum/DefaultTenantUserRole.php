<?php

namespace App\Enum;

enum DefaultTenantUserRole: string
{
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
            self::ADMIN => array_column(TenantPermission::cases(), 'value'),
            self::ADOPTION_LEAD => [
                TenantPermission::EDIT_ANIMALS->value,
                TenantPermission::DELETE_ANIMALS->value,
                TenantPermission::DELETE_ANIMALS->value,
                TenantPermission::DELETE_ANIMALS->value,
            ],
            self::ADOPTION_HANDLER => [
                TenantPermission::EDIT_OWN_ANIMALS->value,
                TenantPermission::DELETE_OWN_ANIMALS->value
            ],
            default => [],
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
