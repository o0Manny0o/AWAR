<?php

namespace App\Authorisation\Enum;

enum CentralRole: string
{
    case ADMIN = 'central_admin';
    case SUPER_ADMIN = 'super_admin';
}
