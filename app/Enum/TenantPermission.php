<?php

namespace App\Enum;

use App\Traits\HasValues;

enum TenantPermission: string
{
    use HasValues;

    case EDIT_ANIMALS = 'edit animals';
    case EDIT_OWN_ANIMALS = 'edit own animals';
    case DELETE_ANIMALS = 'delete animals';
    case DELETE_OWN_ANIMALS = 'delete own animals';
    case PUBLISH_ANIMALS = 'publish animals';
    case UNPUBLISH_ANIMALS = 'unpublish animals';
}
