<?php

namespace App\Http\Requests\Animals;

use App\Models\Address;
use App\Models\Tenant\Member;
use App\Models\Tenant\OrganisationLocation;
use App\Rules\IsTenantLocation;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AssignLocationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'id' => [
                'sometimes',
                'nullable',
                'uuid',
                Rule::exists(OrganisationLocation::class, 'id'),
            ],
            'other' => [
                'exclude_with:id',
                'required',
                'uuid',
                Rule::exists(Member::class, 'global_id'),
            ],
        ];
    }
}
