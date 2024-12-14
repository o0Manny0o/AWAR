<?php

namespace App\Http\Requests\Organisation\Location;

class OrganisationLocationRules
{
    public static function name(): array
    {
        return ['required', 'string', 'max:255'];
    }

    public static function publicRules(): array
    {
        return ['required', 'boolean'];
    }
}
