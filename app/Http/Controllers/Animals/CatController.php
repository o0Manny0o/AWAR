<?php

namespace App\Http\Controllers\Animals;

use App\Http\Requests\Animals\CreateCatRequest;
use App\Http\Requests\Animals\UpdateCatRequest;
use App\Models\Animal\Animal;
use App\Models\Animal\Cat;
use App\Services\AnimalService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Throwable;

class CatController extends AnimalController
{
    protected string $baseRouteName = 'animals.cats';
    protected string $baseViewPath = 'Tenant/Animals/Cats';

    /**
     * Display a listing of cats.
     * @throws AuthorizationException
     */
    public function index(Request $request): Response
    {
        return parent::showIndex($request, Animal::cats()->get());
    }

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
        string $id,
    ): RedirectResponse {
        return parent::updateAnimal($catRequest, $id);
    }

    /**
     * Show the form for creating a new cat.
     * @throws AuthorizationException
     */
    public function create(): Response
    {
        return parent::createAnimal(Cat::class);
    }
}
