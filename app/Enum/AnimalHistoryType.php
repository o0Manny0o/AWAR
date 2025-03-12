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
    case LISTING_CREATED = 'listing_created';
    case LISTING_DELETED = 'listing_deleted';
    case HANDLER_ASSIGN = 'handler_assign';
    case FOSTER_HOME_ASSIGN = 'foster_home_assign';
    case LOCATION_ASSIGN = 'location_assign';
    case HANDLER_UNASSIGN = 'handler_unassign';
    case FOSTER_HOME_UNASSIGN = 'foster_home_unassign';
    case LOCATION_UNASSIGN = 'location_unassign';
}
