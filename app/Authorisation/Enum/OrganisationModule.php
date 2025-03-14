<?php

namespace App\Authorisation\Enum;

enum OrganisationModule: string
{
    case ANIMALS = 'animals';
    case ASSIGNED_ANIMALS = 'assigned_animals';
    case FOSTERED_ANIMALS = 'fostered_animals';
    case MEMBERS = 'members';
    case INVITATIONS = 'invitations';
    case LOCATIONS = 'locations';
    case PUBLIC_SETTINGS = 'public_settings';
    case LISTINGS = 'listings';
}
