<?php

namespace App\Http\Controllers\Tenant;

use App\Http\AppInertia;
use App\Http\Controllers\Controller;
use App\Models\Animal\Animal;
use App\Models\Animal\Dog;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

class DogController extends Controller
{
    protected string $baseRouteName = 'animals.dogs';
    protected string $baseViewPath = 'Tenant/Animals/Dogs';

    /**
     * Display a listing of the resource.
     * @throws AuthorizationException
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Animal::class);

        $animals = Animal::dogs()->get();

        return AppInertia::render($this->getIndexView(), [
            'dogs' => $animals,
            'permissions' => $this->permissions($request),
        ]);
    }

    private function permissions(Request $request, Animal $animal = null): array
    {
        $animal?->setPermissions($request->user());

        return [
            'animals' => [
                'create' => $request->user()->can('create', Animal::class),
                'view' => $request->user()->can('view', $animal),
                'delete' => $request->user()->can('delete', $animal),
            ],
        ];
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Animal::class);

        $dog = Dog::create(['breed' => 'Pug']);

        $dog->animal()->create([
            'name' => 'Toby',
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
