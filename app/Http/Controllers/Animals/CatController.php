<?php

namespace App\Http\Controllers\Animals;

use App\Http\AppInertia;
use App\Http\Controllers\Controller;
use App\Models\Animal\Animal;
use App\Models\Animal\Cat;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Inertia\Response;

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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Animal::class);

        $cat = Cat::create(['breed' => 'British Short Hair']);

        $cat->animal()->create([
            'name' => 'Cica',
            'date_of_birth' => now(),
            'organisation_id' => tenant()->id,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
