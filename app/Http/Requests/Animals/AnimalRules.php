<?php

namespace App\Http\Requests\Animals;

use App\Models\Animal\Animal;
use App\Models\Animal\AnimalFamily;
use App\Rules\ImageOrDatabaseEntry;
use App\Rules\ModelUuidOrNew;
use Illuminate\Validation\Rule;

class AnimalRules
{
    public static function nameRules(): array
    {
        return ['required', 'string', 'max:255', 'not_regex:/^(\d*)$/'];
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
        return ['nullable', 'uuid', Rule::exists(Animal::class, 'id')];
    }

    public static function fatherRules(): array
    {
        return [
            'nullable',
            'exclude_without:family',
            'different:mother',
            new ModelUuidOrNew(
                table: Animal::class,
                newRules: ['regex:/^0$/'],
                column: 'id',
            ),
        ];
    }
    public static function motherRules(): array
    {
        return [
            'nullable',
            'exclude_without:family',
            'different:father',
            new ModelUuidOrNew(
                table: Animal::class,
                newRules: ['regex:/^0$/'],
                column: 'id',
            ),
        ];
    }

    public static function familyRules(): array
    {
        return [
            'sometimes',
            'nullable',
            new ModelUuidOrNew(
                table: AnimalFamily::class,
                newRules: ['required', 'string', 'max:255'],
                column: 'id',
            ),
        ];
    }
}
