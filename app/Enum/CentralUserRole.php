<?php

namespace App\Enum;

enum CentralUserRole: string
{
    case ADMIN = 'admin';
    case SUPER_ADMIN = 'super-admin';
}
