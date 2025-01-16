<?php

namespace App\Http\Controllers\Animals;

use App\Http\Controllers\Controller;
use App\Http\Requests\Animals\RequestWithAnimalType;
use App\Interface\Animalable;

class AnimalTypedController extends Controller
{
    protected static string $animal_model;

    /**
     * @return Animalable
     */
    public static function getAnimalModel(): string
    {
        /** @var Animalable $model */
        $model = self::$animal_model;

        return $model;
    }

    public function __construct(RequestWithAnimalType $requestWithAnimalType)
    {
        self::$animal_model = $requestWithAnimalType->input('animal_model');
        static::$baseViewPath = self::$animal_model::$baseViewPath;
        static::$baseRouteName = self::$animal_model::$baseRouteName;
    }
}
