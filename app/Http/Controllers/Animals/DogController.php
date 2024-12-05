<?php

namespace App\Http\Controllers\Animals;

use App\Http\Requests\Animals\CreateAnimalRequest;
use App\Http\Requests\Animals\CreateDogRequest;
use App\Http\Requests\Animals\UpdateAnimalRequest;
use App\Http\Requests\Animals\UpdateDogRequest;
use App\Models\Animal\Animal;
use App\Models\Animal\Dog;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Throwable;

class DogController extends AnimalController
{
    protected string $baseRouteName = 'animals.dogs';
    protected string $baseViewPath = 'Tenant/Animals/Dogs';

    /**
     * Display a listing of dogs.
     * @throws AuthorizationException
     */
    public function index(Request $request): Response
    {
        return parent::showIndex($request, Animal::dogs()->get());
    }

    /**
     * Store a newly created dog in storage.
     * @throws Throwable
     */
    public function store(
        CreateAnimalRequest $animalRequest,
        CreateDogRequest $dogRequest,
    ): RedirectResponse {
        return parent::storeAnimal($animalRequest, $dogRequest, Dog::class);
    }

    /**
     * Update the specified dog in storage.
     * @throws AuthorizationException|Throwable
     */
    public function update(
        UpdateAnimalRequest $animalRequest,
        UpdateDogRequest $dogRequest,
        string $id,
    ): RedirectResponse {
        return parent::updateAnimal(
            $animalRequest,
            $dogRequest,
            Dog::class,
            $id,
        );
    }
}
