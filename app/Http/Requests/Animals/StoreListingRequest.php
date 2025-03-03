<?php

namespace App\Http\Requests\Animals;

use App\Http\Requests\Animals\Rules\ListingRules;
use Illuminate\Foundation\Http\FormRequest;

class StoreListingRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'excerpt' => ListingRules::excerptRules(),
            'description' => ListingRules::descriptionRules(),
            'animals' => ListingRules::animalsRules(),
            'animals.*' => ListingRules::animalRules(),
            'images' => ListingRules::imagesRules(),
            'images.*' => ListingRules::imageRules(),
        ];
    }
}
