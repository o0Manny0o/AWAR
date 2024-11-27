<?php

namespace App\Enum;

enum TenantPermission: string
{
    case EDIT_ANIMALS = 'edit animals';
    case EDIT_OWN_ANIMALS = 'edit own animals';
    case DELETE_ANIMALS = 'delete animals';
    case DELETE_OWN_ANIMALS = 'delete own animals';
    case PUBLISH_ANIMALS = 'publish animals';
    case UNPUBLISH_ANIMALS = 'unpublish animals';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
