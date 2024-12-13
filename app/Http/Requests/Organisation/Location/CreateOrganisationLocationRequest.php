<?php

namespace App\Http\Requests\Organisation\Location;

use App\Http\Requests\Address\AddressRequest;
use Illuminate\Contracts\Validation\ValidationRule;

class CreateOrganisationLocationRequest extends AddressRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            'name' => OrganisationLocationRules::name(),
            'public' => OrganisationLocationRules::publicRules(),
        ]);
    }
}
