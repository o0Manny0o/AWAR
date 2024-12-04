<?php

namespace App\Http\Controllers\Animals;

use App\Events\Animals\AnimalCreated;
use App\Models\Animal\Animal;
use App\Models\Animal\Dog;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
     */
    public function store(Request $request)
    {
        $this->authorize('create', Animal::class);

        $dog = Dog::create(['breed' => 'Pug']);

        $animal = $dog->animal()->create([
            'name' => 'Toby',
            'date_of_birth' => now(),
            'organisation_id' => tenant()->id,
        ]);

        AnimalCreated::dispatch($animal, Auth::user());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Animal::class);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
