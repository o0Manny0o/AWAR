<?php

namespace App\Http\Controllers\Animals;

use App\Events\Animals\AnimalCreated;
use App\Http\AppInertia;
use App\Http\Controllers\Controller;
use App\Http\Requests\Animals\CreateAnimalRequest;
use App\Models\Animal\Animal;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Response;
use Throwable;

class AnimalController extends Controller
{
    /**
     * Display the specified resource.
     * @throws AuthorizationException
     */
    public function show(string $id): RedirectResponse|Response
    {
        $animal = Animal::find($id);
        if (!$animal) {
            return redirect()->route($this->getIndexRouteName());
        }

        $this->authorize('view', $animal);

        return AppInertia::render($this->getShowView(), [
            'animal' => $animal,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        /** @var Animal|null $animal */
        $animal = Animal::find($id);
        if (!$animal) {
            return redirect()->route($this->getIndexRouteName());
        }

        $this->authorize('delete', $animal);

        $animal->delete();

        return redirect()->route($this->getIndexRouteName());
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

        foreach ($animals as $animal) {
            $animal->setPermissions($request->user());
        }

        return AppInertia::render($this->getIndexView(), [
            'animals' => $animals,
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
     * Store the animal for an animalable resource.
     *
     * @throws Throwable
     */
    protected function storeAnimal(
        CreateAnimalRequest $animalRequest,
        FormRequest $animalableRequest,
        $class,
    ): RedirectResponse {
        $this->authorize('create', Animal::class);

        $organisation = tenant();

        $animal = tenancy()->central(function () use (
            $organisation,
            $class,
            $animalableRequest,
            $animalRequest,
        ) {
            return DB::transaction(function () use (
                $organisation,
                $class,
                $animalableRequest,
                $animalRequest,
            ) {
                $animalableValidated = $animalableRequest->validated();

                $animalable = $class::create($animalableValidated);

                $validated = $animalRequest->validated();

                $animal = $animalable->animal()->create(
                    array_merge($validated, [
                        'organisation_id' => $organisation->id,
                    ]),
                );

                AnimalCreated::dispatch($animal, Auth::user());

                return $animal;
            }, 5);
        });

        return $this->redirect($animalRequest, $this->getShowRouteName(), [
            'animal' => $animal,
        ]);
    }

    /**
     * Show the form for creating a new animal.
     * @throws AuthorizationException
     */
    public function create(): Response
    {
        $this->authorize('create', Animal::class);

        return AppInertia::render($this->getCreateView());
    }
}
