<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Translation\PotentiallyTranslatedString;
use Illuminate\Validation\Rule;

class ImageOrDatabaseEntry implements ValidationRule
{
    /**
     * The table to run the query against.
     *
     * @var string
     */
    protected $table;

    /**
     * The column to check on.
     *
     * @var string
     */
    protected $column;

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
                            request()->route($this->idParameter)->id,
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

    public function resolveTableName($table)
    {
        if (!str_contains($table, '\\') || !class_exists($table)) {
            return $table;
        }

        if (is_subclass_of($table, Model::class)) {
            $model = new $table();

            if (str_contains($model->getTable(), '.')) {
                return $table;
            }

            return implode(
                '.',
                array_map(function (string $part) {
                    return trim($part, '.');
                }, array_filter([
                    $model->getConnectionName(),
                    $model->getTable(),
                ])),
            );
        }

        return $table;
    }
}
