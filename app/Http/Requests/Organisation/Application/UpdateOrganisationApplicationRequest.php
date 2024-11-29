<?php

namespace App\Http\Requests\Organisation\Application;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrganisationApplicationRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => OrganisationApplicationRules::nameRules(),
            'type' => OrganisationApplicationRules::typeRules(),
            'user_role' => OrganisationApplicationRules::userRoleRules(),
            'registered' => OrganisationApplicationRules::registeredRules(),
            'street' => OrganisationApplicationRules::streetRules(),
            'post_code' => OrganisationApplicationRules::postCodeRules(),
            'city' => OrganisationApplicationRules::cityRules(),
            'country' => OrganisationApplicationRules::countryRules(),
            'subdomain' => OrganisationApplicationRules::subdomainRules()
        ];

    }
}
