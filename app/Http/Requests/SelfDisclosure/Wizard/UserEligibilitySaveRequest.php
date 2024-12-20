<?php

namespace App\Http\Requests\SelfDisclosure\Wizard;

use Illuminate\Foundation\Http\FormRequest;

class UserEligibilitySaveRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'animal_protection_experience' => ['required', 'boolean'],
            'can_cover_expenses' => ['required', 'boolean'],
            'can_cover_emergencies' => ['required', 'boolean'],
            'can_afford_insurance' => ['required', 'boolean'],
            'can_afford_castration' => ['required', 'boolean'],
            'substitute' => ['required', 'string', 'max:255'],
            'time_alone_daily' => ['nullable', 'integer', 'min:0', 'max:24'],
        ];
    }
}
