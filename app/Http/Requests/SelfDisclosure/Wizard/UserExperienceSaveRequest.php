<?php

namespace App\Http\Requests\SelfDisclosure\Wizard;

use Illuminate\Foundation\Http\FormRequest;

class UserExperienceSaveRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'type' => ['required', 'string', 'in:work,pet,other'],
            'animal_type' => ['required', 'string', 'in:dog,cat,other'],
            'years' => [
                'required_without:since',
                'missing_with:since',
                'integer',
                'min:1',
            ],
            'since' => [
                'required_without:years',
                'missing_with:years',
                'date',
                'before_or_equal:today',
            ],
        ];
    }
}
