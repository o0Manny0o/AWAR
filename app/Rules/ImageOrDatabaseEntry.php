<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Translation\PotentiallyTranslatedString;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\DatabaseRule;

class ImageOrDatabaseEntry implements ValidationRule
{
    use DatabaseRule {
        __construct as public __construct;
    }

    public function __construct(
        $table,
        $column = 'id',
        private $idParameter = 'id',
    ) {
        $this->column = $column;

        $this->table = $this->resolveTableName($table);
    }

    /**
     * Run the validation rule.
     *
     * @param \Closure(string, ?string=): PotentiallyTranslatedString $fail
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
                    str_replace('.', '\.', $attribute) => [
                        Rule::exists($this->table, $this->column)->where(
                            'medially_id',
                            request()->route($this->idParameter),
                        ),
                    ],
                ],
            );
        } else {
            $validator = Validator::make(
                [$attribute => $value],
                [
                    str_replace('.', '\.', $attribute) => [
                        'image',
                        'mimes:jpeg,jpg,png,webp',
                    ],
                ],
                attributes: [
                    $attribute => 'file',
                ],
            );
        }
        if ($validator->fails()) {
            $fail($validator->errors()->first());
        }
    }
}
