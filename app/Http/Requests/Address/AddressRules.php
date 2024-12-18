<?php

namespace App\Http\Requests\Address;

use App\Models\Country;
use Illuminate\Validation\Rule;

class AddressRules
{
    public static function streetAddressRules(): array
    {
        return ['required', 'string', 'max:255'];
    }

    public static function localityRules(): array
    {
        return ['required', 'string', 'max:255'];
    }

    public static function regionRules(): array
    {
        return ['nullable', 'sometimes', 'string', 'max:255'];
    }

    public static function postal_code(): array
    {
        return ['required', 'postal_code_with:country'];
    }

    public static function countryRules(): array
    {
        return [
            'required',
            'string',
            'max:2',
            Rule::exists(Country::class, 'alpha'),
        ];
    }
}
