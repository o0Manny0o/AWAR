<?php

namespace App\Http\Requests\Organisation\Application;

class OrganisationApplicationRules
{
    public static function nameRules(): array
    {
        return [
            'required',
            'string',
            'max:255',
            'unique:App\Models\Organisation,name',
        ];
    }

    public static function typeRules(): array
    {
        return ['required', 'string', 'max:255'];
    }

    public static function userRoleRules(): array
    {
        return ['required', 'string', 'max:255'];
    }

    public static function registeredRules(): array
    {
        return ['required', 'boolean'];
    }

    public static function streetRules(): array
    {
        return ['required', 'string', 'max:60'];
    }

    public static function postCodeRules(): array
    {
        return ['required', 'numeric', 'min_digits:5', 'max_digits:10'];
    }

    public static function cityRules(): array
    {
        return ['required', 'string', 'max:60'];
    }

    public static function countryRules(): array
    {
        return ['required', 'string', 'max:60'];
    }

    public static function subdomainRules(): array
    {
        return [
            'required',
            'string',
            'max:60',
            'regex:/^[A-Za-z0-9-]+$/',
            'unique:App\Models\Domain,subdomain',
        ];
    }
}
