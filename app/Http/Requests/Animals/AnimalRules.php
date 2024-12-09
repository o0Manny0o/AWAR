<?php

namespace App\Http\Requests\Animals;

use App\Rules\ImageOrDatabaseEntry;

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

    public static function bioRules(): array
    {
        return ['nullable', 'string', 'max:1000'];
    }

    public static function abstractRules(): array
    {
        return ['nullable', 'string', 'max:255'];
    }

    public static function imagesRules(): array
    {
        return ['required', 'array', 'min:1'];
    }

    public static function imageRules(): array
    {
        return [new ImageOrDatabaseEntry('media')];
    }
}
