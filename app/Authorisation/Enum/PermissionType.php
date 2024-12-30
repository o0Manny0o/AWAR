<?php

namespace App\Authorisation\Enum;

enum PermissionType: string
{
    case CREATE = 'create';
    case READ = 'read';
    case UPDATE = 'update';
    case DELETE = 'delete';
    case ASSIGN = 'assign';
    case FORCE_DELETE = 'force_delete';

    case RESTORE = 'restore';

    case FOSTER = 'foster';

    public function for(string $module): string
    {
        return $this->value . '-' . $module;
    }
}
