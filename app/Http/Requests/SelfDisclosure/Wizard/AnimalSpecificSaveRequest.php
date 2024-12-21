<?php

namespace App\Http\Requests\SelfDisclosure\Wizard;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AnimalSpecificSaveRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return array_merge(
            [
                'cats' => ['required', 'boolean'],
                'dogs' => ['required', 'boolean'],
            ],
            AnimalSpecificRules::dogRules(),
            AnimalSpecificRules::catRules($this),
        );
    }
}
