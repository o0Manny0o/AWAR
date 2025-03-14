<?php

namespace App\Http\Requests\Animals;

use App\Http\Requests\Animals\Rules\CatRules;
use Illuminate\Contracts\Validation\ValidationRule;

class CreateCatRequest extends CreateAnimalRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            'breed' => CatRules::breedRules(),
        ]);
    }
}
