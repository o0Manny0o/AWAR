<?php

namespace App\Http\Requests\Animals;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AssignHandlerRequest extends FormRequest
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
                'nullable',
                'uuid',
                Rule::exists('organisation_users', 'user_id')->where(function (
                    $query,
                ) {
                    $query->where('tenant_id', tenant('id'));
                }),
            ],
        ];
    }
}
