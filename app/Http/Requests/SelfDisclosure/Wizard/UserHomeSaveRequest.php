<?php

namespace App\Http\Requests\SelfDisclosure\Wizard;

use Illuminate\Foundation\Http\FormRequest;

class UserHomeSaveRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'type' => ['required', 'string', 'in:apartment,house,other'],
            'own' => ['required', 'boolean'],
            'pets_allowed' => ['required_if:animal,0,false', 'boolean'],
            'move_in_date' => ['required', 'date', 'before_or_equal:today'],
            'size' => ['required', 'numeric', 'min:1'],
            'level' => ['required', 'numeric', 'min:1'],
            'location' => ['required', 'string', 'in:city,suburb,rural'],
        ];
    }
}
