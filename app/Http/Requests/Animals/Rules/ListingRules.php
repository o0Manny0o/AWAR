<?php

namespace App\Http\Requests\Animals\Rules;

class ListingRules
{
    public static function excerptRules(): array
    {
        return ['required', 'string', 'max:255'];
    }
    public static function descriptionRules(): array
    {
        return ['required', 'string', 'max:10000'];
    }
    public static function animalsRules(): array
    {
        return ['required', 'array', 'min:1'];
    }
    public static function animalRules(): array
    {
        return ['uuid', 'distinct', 'exists:animals,id'];
    }
    public static function imagesRules(): array
    {
        return ['array', 'min:1'];
    }
    public static function imageRules(): array
    {
        return ['numeric', 'distinct', 'exists:media,id'];
    }
}
