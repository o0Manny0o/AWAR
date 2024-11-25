<?php

namespace App\Http\Requests\Organisation;

use App\Models\OrganisationApplication;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class CreateOrganisationApplicationRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $step = $this->route()->parameter('step');

        if (!$step || $step == '1') {
            return [
                'name' => OrganisationApplicationRules::nameRules(),
                'type' => OrganisationApplicationRules::typeRules(),
                'user_role' => OrganisationApplicationRules::userRoleRules(),
                'registered' => OrganisationApplicationRules::registeredRules()
            ];
        } elseif ($step == '2') {
            return [
                'street' => OrganisationApplicationRules::streetRules(),
                'post_code' => OrganisationApplicationRules::postCodeRules(),
                'city' => OrganisationApplicationRules::cityRules(),
                'country' => OrganisationApplicationRules::countryRules()
            ];
        } else {
            return [
                'subdomain' => OrganisationApplicationRules::subdomainRules()
            ];
        }
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                $exists = OrganisationApplication::where('name', $this->input('name'))
                    ->where('id', '!=', $this->route()->parameter('application'))
                    ->where('user_id', $this->user()->id)
                    ->exists();

                if ($exists) {
                    $validator->errors()->add('name', 'You already created an application with this name.');
                }
            }
        ];
    }
}
