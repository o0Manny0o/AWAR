<?php

namespace App\Http\Requests\Animals;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAnimalRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => AnimalRules::nameRules(),
            'date_of_birth' => AnimalRules::dateOfBirthRules(),
        ];
    }
}
