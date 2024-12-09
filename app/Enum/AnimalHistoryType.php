<?php

namespace App\Enum;

use App\Traits\HasValues;

enum AnimalHistoryType: string
{
    use HasValues;

    case INITIAL = 'initial';
    case UPDATE = 'update';
    case DELETE = 'delete';
    case RESTORE = 'restore';
    case PUBLISH = 'publish';
    case UNPUBLISH = 'unpublish';
}
