<?php

namespace App\Enum;

use App\Traits\HasValues;

enum ResourcePermission: string
{
    use HasValues;

    case DELETE = 'can_be_deleted';
    case RESTORE = 'can_be_restored';
    case UPDATE = 'can_be_updated';
    case VIEW = 'can_be_viewed';
    case SUBMIT = 'can_be_submitted';
    case RESEND = 'can_be_resend';
    case PUBLISH = 'can_be_published';
    case ASSIGN_HANDLER = 'can_assign_handler';
}
