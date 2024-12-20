<?php

namespace App\Http\Requests\SelfDisclosure\Wizard;

use Illuminate\Foundation\Http\FormRequest;

class UserGardenSaveRequest extends FormRequest
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
                'nullable',
                'required_if:garden,1,true',
                'integer',
                'min:1',
            ],
            'garden_secure' => [
                'nullable',
                'required_if:garden,1,true',
                'boolean',
            ],
            'garden_connected' => [
                'nullable',
                'required_if:garden,1,true',
                'boolean',
            ],
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'garden_size' => $this->garden ? $this->garden_size : null,
            'garden_secure' => $this->garden ? $this->garden_secure : null,
            'garden_connected' => $this->garden
                ? $this->garden_connected
                : null,
        ]);
    }
}
