<?php

namespace App\Authorisation\Enum;

enum ResourcePermission: string
{
    case CREATE = 'c';
    case READ = 'r';
    case UPDATE = 'u';
    case DELETE = 'd';
}
