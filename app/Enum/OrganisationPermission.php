<?php

namespace App\Enum;

use App\Traits\HasValues;

enum OrganisationPermission: string
{
    use HasValues;

    case EDIT_ALL_ANIMALS = 'edit animals';
    case EDIT_ASSIGNED_ANIMALS = 'edit assigned animals';
    case DELETE_ANIMALS = 'delete animals';
    case PUBLISH_ANIMALS = 'publish animals';
    case UNPUBLISH_ANIMALS = 'unpublish animals';
    case SEE_ALL_ANIMALS = 'see all animals';
    case SEE_ASSIGNED_ANIMALS = 'see assigned animals';
    case SEE_FOSTERED_ANIMALS = 'see fostered animals';
}
