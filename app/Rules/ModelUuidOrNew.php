<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\DatabaseRule;

class ModelUuidOrNew implements ValidationRule
{
    use DatabaseRule {
        __construct as public __construct;
    }

    public function __construct(
        $table,
        private readonly array $newRules,
        $column = 'id',
    ) {
        $this->column = $column;

        $this->table = $this->resolveTableName($table);
    }

    /**
     * Run the validation rule.
     *
     * @param \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */
    public function validate(
        string $attribute,
        mixed $value,
        Closure $fail,
    ): void {
        if (Str::isUuid($value)) {
            $validator = Validator::make(
                [$attribute => $value],
                [
                    str_replace('.', '\.', $attribute) => [
                        Rule::exists($this->table, $this->column),
                    ],
                ],
            );
        } else {
            $validator = Validator::make(
                [$attribute => $value],
                [
                    str_replace('.', '\.', $attribute) => $this->newRules,
                ],
            );
        }
        if ($validator->fails()) {
            $fail($validator->errors()->first());
        }
    }
}
