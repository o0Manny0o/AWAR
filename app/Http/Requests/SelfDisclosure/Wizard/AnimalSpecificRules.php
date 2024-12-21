<?php

namespace App\Http\Requests\SelfDisclosure\Wizard;

use Illuminate\Validation\Rule;

class AnimalSpecificRules
{
    public static function dogRules(): array
    {
        return [
            'dog_habitat' => [
                'required_if:dogs,1,true',
                'exclude_unless:dogs,1,true',
                'string',
                'in:home,garden,other',
            ],

            'dog_purpose' => [
                'required_if:dogs,1,true',
                'exclude_unless:dogs,1,true',
                'string',
                'in:pet,work,other',
            ],

            'dog_school' => [
                'required_if:dogs,1,true',
                'exclude_unless:dogs,1,true',
                'boolean',
            ],

            'dog_time_to_occupy' => [
                'required_if:dogs,1,true',
                'exclude_unless:dogs,1,true',
                'boolean',
            ],
        ];
    }

    public static function catRules(AnimalSpecificSaveRequest $request): array
    {
        return [
            'cat_habitat' => [
                'required_if:cats,1,true',
                'exclude_unless:cats,1,true',
                'string',
                'in:indoor,outdoor,both',
            ],

            'cat_house_secure' => [
                Rule::requiredIf(function () use ($request) {
                    return $request->input('cats') &&
                        $request->input('cat_habitat') !== 'outdoor';
                }),
                Rule::excludeIf(function () use ($request) {
                    return !$request->input('cats') ||
                        $request->input('cat_habitat') === 'outdoor';
                }),
                'boolean',
            ],

            'cat_sleeping_place' => [
                Rule::requiredIf(function () use ($request) {
                    return $request->input('cats') &&
                        $request->input('cat_habitat') !== 'indoor';
                }),
                Rule::excludeIf(function () use ($request) {
                    return !$request->input('cats') ||
                        $request->input('cat_habitat') === 'indoor';
                }),
                'string',
                'max:255',
            ],

            'cat_streets_safe' => [
                Rule::requiredIf(function () use ($request) {
                    return $request->input('cats') &&
                        $request->input('cat_habitat') !== 'indoor';
                }),
                Rule::excludeIf(function () use ($request) {
                    return !$request->input('cats') ||
                        $request->input('cat_habitat') === 'indoor';
                }),
                'boolean',
            ],

            'cat_flap_available' => [
                Rule::requiredIf(function () use ($request) {
                    return $request->input('cats') &&
                        $request->input('cat_habitat') !== 'indoor';
                }),
                Rule::excludeIf(function () use ($request) {
                    return !$request->input('cats') ||
                        $request->input('cat_habitat') === 'indoor';
                }),
                'boolean',
            ],
        ];
    }
}
