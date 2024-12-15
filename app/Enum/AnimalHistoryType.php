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
    case HANDLER_ASSIGN = 'handler_assign';
    case FOSTER_HOME_ASSIGN = 'foster_home_assign';
}
