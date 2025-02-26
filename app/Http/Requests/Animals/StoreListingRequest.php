<?php

namespace App\Http\Requests\Animals;

use Illuminate\Foundation\Http\FormRequest;

class StoreListingRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'excerpt' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:10000'],
            'animals' => ['required', 'array', 'min:1'],
            'animals.*' => ['uuid', 'distinct', 'exists:animals,id'],
            'images' => ['array'],
            'images.*' => ['numeric', 'distinct', 'exists:media,id'],
        ];
    }
}
