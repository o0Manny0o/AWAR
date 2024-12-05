<?php

namespace App\Http\Controllers\Animals;

use App\Http\Requests\Animals\CreateAnimalRequest;
use App\Http\Requests\Animals\CreateCatRequest;
use App\Models\Animal\Animal;
use App\Models\Animal\Cat;
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
     * Display a listing of the resource.
     * @throws AuthorizationException
     */
    public function index(Request $request): Response
    {
        return parent::showIndex($request, Animal::cats()->get());
    }

    /**
     * Store a newly created resource in storage.
     * @throws AuthorizationException|Throwable
     */
    public function store(
        CreateAnimalRequest $animalRequest,
        CreateCatRequest $catRequest,
    ): RedirectResponse {
        return parent::storeAnimal($animalRequest, $catRequest, Cat::class);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
