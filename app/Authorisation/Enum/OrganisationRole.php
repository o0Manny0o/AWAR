<?php

namespace App\Authorisation\Enum;

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
}
