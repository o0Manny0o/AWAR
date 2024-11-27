<?php

namespace App\Enum;

enum CentralUserRole: string
{
    /** Grants all permissions in central context */
    case ADMIN = 'admin';
    /** Grants all permissions in central context and tenant context */
    case SUPER_ADMIN = 'super-admin';
}
