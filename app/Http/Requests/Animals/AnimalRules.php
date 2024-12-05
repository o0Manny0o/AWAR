<?php

namespace App\Http\Requests\Animals;

class AnimalRules
{
    public static function nameRules(): array
    {
        return ['required', 'string', 'max:255'];
    }

    public static function dateOfBirthRules(): array
    {
        return ['required', 'date', 'before:today'];
    }
}
