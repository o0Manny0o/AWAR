<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Translation\PotentiallyTranslatedString;
use Illuminate\Validation\Rules\DatabaseRule;

class ImageOrDatabaseEntry implements ValidationRule
{
    use DatabaseRule;
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(
        string $attribute,
        mixed $value,
        Closure $fail,
    ): void {
        if (is_numeric($value)) {
            $validator = Validator::make(
                [$attribute => $value],
                [
                    $attribute => ["exists:{$this->table},{$this->column}"],
                ],
            );
        } else {
            $validator = Validator::make(
                [$attribute => $value],
                [
                    $attribute => [
                        'image',
                        'mimes:jpeg,jpg,png,webp',
                        'max:2048',
                    ],
                ],
            );
        }
        if ($validator->fails()) {
            $fail($validator->errors()->first());
        }
    }
}
