<?php

namespace App\Http\Controllers\Animals;

use App\Http\Requests\Animals\CreateAnimalRequest;
use App\Http\Requests\Animals\CreateDogRequest;
use App\Models\Animal\Animal;
use App\Models\Animal\Dog;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Inertia\Response;
use Throwable;

class DogController extends AnimalController
{
    protected string $baseRouteName = 'animals.dogs';
    protected string $baseViewPath = 'Tenant/Animals/Dogs';

    /**
     * Display a listing of the resource.
     * @throws AuthorizationException
     */
    public function index(Request $request)
    {
        return parent::showIndex($request, Animal::dogs()->get());
    }

    /**
     * Store a newly created resource in storage.
     * @throws Throwable
     */
    public function store(
        CreateAnimalRequest $animalRequest,
        CreateDogRequest $dogRequest,
    ) {
        return parent::storeAnimal($animalRequest, $dogRequest, Dog::class);
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
}
