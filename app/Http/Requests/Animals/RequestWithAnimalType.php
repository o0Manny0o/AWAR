<?php

namespace App\Http\Requests\Animals;

use App\Models\Animal\Cat;
use App\Models\Animal\Dog;
use Illuminate\Foundation\Http\FormRequest;

class RequestWithAnimalType extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'animal_model' => [
                'required',
                'in:' . implode(',', [Dog::class, Cat::class]),
            ],
        ];
    }
}
