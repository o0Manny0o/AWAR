<?php

namespace App\Http\Requests\Animals;

use App\Rules\ImageOrDatabaseEntry;
use Illuminate\Validation\Rule;

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

    public static function sexRules(): array
    {
        return ['nullable', Rule::in(['male', 'female'])];
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
        return [
            new ImageOrDatabaseEntry(table: 'media', idParameter: 'animal'),
        ];
    }

    public static function parentRules(): array
    {
        return [
            'nullable',
            Rule::exists('animals', 'id')->whereNot(
                'id',
                request()->route('animal'),
            ),
        ];
    }

    public static function familyRules(): array
    {
        return ['nullable', 'string', 'max:255'];
    }

    public static function relationRules(): array
    {
        return [
            'exclude_without:family',
            'required',
            Rule::in('father', 'mother', 'child'),
        ];
    }
}
