<?php

namespace App\Authorisation\Enum;

enum OrganisationModule: string
{
    case ANIMALS = 'animals';
    case MEMBERS = 'members';
    case INVITATIONS = 'invitations';
    case LOCATIONS = 'locations';
    case PUBLIC_SETTINGS = 'public_settings';
}
