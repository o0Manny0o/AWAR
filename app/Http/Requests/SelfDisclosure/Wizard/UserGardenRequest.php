<?php

namespace App\Http\Requests\SelfDisclosure\Wizard;

use Illuminate\Foundation\Http\FormRequest;

class UserGardenRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'garden' => ['required', 'boolean'],
            'garden_size' => [
                'exclude_unless:garden,1,true',
                'required',
                'integer',
                'min:1',
            ],
            'garden_secure' => [
                'exclude_unless:garden,1,true',
                'required',
                'boolean',
            ],
            'garden_connected' => [
                'exclude_unless:garden,1,true',
                'required',
                'boolean',
            ],
        ];
    }
}
