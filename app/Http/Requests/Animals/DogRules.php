<?php

namespace App\Http\Requests\Animals;

class DogRules
{
    public static function breedRules(): array
    {
        return ['required', 'string', 'max:255'];
    }
}
