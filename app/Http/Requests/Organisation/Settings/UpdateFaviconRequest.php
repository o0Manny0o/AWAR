<?php

namespace App\Http\Requests\Organisation\Settings;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFaviconRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'favicon' => [
                'required',
                'image',
                'mimes:jpeg,png,jpg,gif,svg,ico',
                'max:512',
            ],
        ];
    }
}
