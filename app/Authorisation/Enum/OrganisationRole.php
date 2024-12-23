<?php

namespace App\Authorisation\Enum;

use App\Enum\OrganisationPermission;
use App\Traits\HasValues;

enum OrganisationRole: string
{
    use HasValues;
    case MEMBER = 'member';
    case ADMIN = 'admin';
    case ANIMAL_LEAD = 'animal_lead';
    case ANIMAL_HANDLER = 'animal_handler';
    case FOSTER_HOME_LEAD = 'foster_home_lead';
    case FOSTER_HOME_HANDLER = 'foster_home_handler';
    case FOSTER_HOME = 'foster_home';

    function permissions(): array
    {
        return match ($this) {
            self::ADMIN => OrganisationPermission::values(),
            self::ANIMAL_LEAD => [
                OrganisationPermission::SEE_ALL_ANIMALS->value,
                OrganisationPermission::EDIT_ALL_ANIMALS->value,
                OrganisationPermission::DELETE_ANIMALS->value,
                OrganisationPermission::PUBLISH_ANIMALS->value,
                OrganisationPermission::UNPUBLISH_ANIMALS->value,
            ],
            self::ANIMAL_HANDLER => [
                OrganisationPermission::SEE_ASSIGNED_ANIMALS->value,
                OrganisationPermission::EDIT_ASSIGNED_ANIMALS->value,
            ],
            self::FOSTER_HOME => [
                OrganisationPermission::SEE_FOSTERED_ANIMALS->value,
            ],
            default => [],
        };
    }
}
