<?php

namespace App\Http\Requests\Animals\Rules;

class DogRules
{
    public static function breedRules(): array
    {
        return ['required', 'string', 'max:255'];
    }
}
