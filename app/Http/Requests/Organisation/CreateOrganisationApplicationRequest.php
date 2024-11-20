<?php

namespace App\Http\Requests\Organisation;

use App\Models\OrganisationApplication;
use Illuminate\Foundation\Http\FormRequest;

class CreateOrganisationApplicationRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'step' => 'required|numeric|min:1|max:3',
            'name' => [
                'exclude_unless:step,1', 'required', 'string', 'max:255', 'unique:App\Models\Organisation,name'
            ],
            'type' => [
                'exclude_unless:step,1', 'required', 'string', 'max:255'
            ],
            'user_role' => [
                'exclude_unless:step,1', 'required', 'string', 'max:255'
            ],
            'registered' => [
                'exclude_unless:step,1', 'required', 'boolean'
            ],
            'street' => [
                'exclude_unless:step,2', 'required', 'string', 'max:60'
            ],
            'post_code' => [
                'exclude_unless:step,2', 'required', 'string', 'max:10'
            ],
            'city' => [
                'exclude_unless:step,2', 'required', 'string', 'max:60'
            ],
            'country' => [
                'exclude_unless:step,2', 'required', 'string', 'max:60'
            ],
            'subdomain' => ['exclude_unless:step,3', 'required', 'string', 'max:60', 'regex:/^[A-Za-z0-9-]+$/', 'unique:App\Models\Domain,subdomain'],
        ];
    }
}
