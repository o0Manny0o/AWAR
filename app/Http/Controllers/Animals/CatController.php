<?php

namespace App\Http\Controllers\Animals;

use App\Http\Requests\Animals\CreateCatRequest;
use App\Http\Requests\Animals\UpdateCatRequest;
use App\Models\Animal\Animal;
use App\Models\Animal\Cat;
use App\Services\AnimalService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Throwable;

class CatController extends AnimalController
{
    protected static string $baseRouteName = 'animals.cats';
    protected static string $baseViewPath = 'Tenant/Animals/Cats';
    protected string $morphClass = Cat::class;

    /**
     * Store a newly created dog in storage.
     * @throws AuthorizationException|Throwable
     */
    public function store(
        AnimalService $animalService,
        CreateCatRequest $catRequest,
    ): RedirectResponse {
        return parent::storeAnimal($animalService, $catRequest, Cat::class);
    }

    /**
     * Update the specified cat in storage.
     * @throws AuthorizationException|Throwable
     */
    public function update(
        UpdateCatRequest $catRequest,
        Animal $animal,
    ): RedirectResponse {
        return parent::updateAnimal($catRequest, $animal);
    }
}
