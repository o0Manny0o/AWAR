<?php

namespace App\Http\Requests\Address;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'street_address' => AddressRules::streetAddressRules(),
            'locality' => AddressRules::localityRules(),
            'region' => AddressRules::regionRules(),
            'postal_code' => AddressRules::postal_code(),
            'country' => AddressRules::countryRules(),
        ];
    }
}
