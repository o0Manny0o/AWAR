<?php

namespace App\Http\Requests\SelfDisclosure\Wizard;

use Illuminate\Foundation\Http\FormRequest;

class PersonalUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'year' => [
                'required',
                'integer',
                'min:1900',
                'digits:4',
                'max:' . (date('Y') + 1),
            ],
            'profession' => ['nullable', 'string', 'max:255'],
            'knows_animals' => ['required', 'boolean'],
        ];
    }
}
