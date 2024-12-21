<?php

namespace App\Http\Requests\SelfDisclosure\Wizard;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FamilyMemberSaveRequest extends FormRequest
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
            'animal' => ['required', 'boolean'],
            'profession' => [
                'exclude_unless:animal,0,false',
                Rule::excludeIf(function () {
                    return $this->input('year') > date('Y') - 18;
                }),
                'nullable',
                'string',
                'max:255',
            ],
            'knows_animals' => [
                'exclude_unless:animal,0,false',
                'required',
                'boolean',
            ],
            'good_with_animals' => [
                'exclude_unless:animal,1,true',
                'required',
                'boolean',
            ],
            'castrated' => [
                'exclude_unless:animal,1,true',
                'required',
                'boolean',
            ],
            'type' => [
                'exclude_unless:animal,1,true',
                'required',
                'string',
                'in:cat,dog,other',
            ],
        ];
    }
}
