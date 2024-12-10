<?php

namespace App\Http\Controllers\Animals;

use App\Http\Requests\Animals\CreateDogRequest;
use App\Http\Requests\Animals\UpdateDogRequest;
use App\Models\Animal\Animal;
use App\Models\Animal\Dog;
use App\Services\AnimalService;
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
        AnimalService $animalService,
        CreateDogRequest $dogRequest,
    ): RedirectResponse {
        return parent::storeAnimal($animalService, $dogRequest, Dog::class);
    }

    /**
     * Update the specified dog in storage.
     * @throws AuthorizationException|Throwable
     */
    public function update(
        UpdateDogRequest $dogRequest,
        string $id,
    ): RedirectResponse {
        return parent::updateAnimal($dogRequest, $id);
    }

    /**
     * Show the form for creating a new dog.
     * @throws AuthorizationException
     */
    public function create(): Response
    {
        return parent::createAnimal(Dog::class);
    }
}
