<?php

namespace App\Http\Controllers\Animals;

use App\Events\Animals\AnimalCreated;
use App\Http\AppInertia;
use App\Http\Controllers\Controller;
use App\Models\Animal\Animal;
use App\Models\Animal\Dog;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Response;

class AnimalController extends Controller
{
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
     * Display a listing of the resource.
     * @throws AuthorizationException
     */
    protected function showIndex(
        Request $request,
        Collection $animals,
    ): Response {
        $this->authorize('viewAny', Animal::class);

        return AppInertia::render($this->getIndexView(), [
            'animals' => $animals,
            'permissions' => $this->permissions($request),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
