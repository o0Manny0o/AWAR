<?php

namespace App\Http\Requests\Animals;

class CatRules
{
    public static function breedRules(): array
    {
        return ['required', 'string', 'max:255'];
    }
}
