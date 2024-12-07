<?php

namespace App\Http\Controllers\Animals;

use App\Events\Animals\AnimalCreated;
use App\Events\Animals\AnimalDeleted;
use App\Events\Animals\AnimalUpdated;
use App\Http\AppInertia;
use App\Http\Controllers\Controller;
use App\Http\Requests\Animals\CreateAnimalRequest;
use App\Http\Requests\Animals\UpdateAnimalRequest;
use App\Models\Animal\Animal;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Response;
use Intervention\Image\Laravel\Facades\Image;
use Throwable;

class AnimalController extends Controller
{
    /**
     * Display the specified resource.
     * @throws AuthorizationException
     */
    public function show(string $id): RedirectResponse|Response
    {
        /** @var Animal|null $animal */
        $animal = Animal::find($id);
        if (!$animal) {
            return redirect()->route($this->getIndexRouteName());
        }

        $this->authorize('view', $animal);

        return AppInertia::render($this->getShowView(), [
            'animal' => $animal,
            'permissions' => $this->permissions(request(), $animal),
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

        AnimalDeleted::dispatch($animal, Auth::user());

        return redirect()->route($this->getIndexRouteName());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, string $id)
    {
        /** @var Animal|null $animal */
        $animal = Animal::find($id);
        if (!$animal) {
            return redirect()->route($this->getIndexRouteName());
        }

        $this->authorize('update', $animal);

        return AppInertia::render($this->getEditView(), [
            'animal' => $animal,
            'permissions' => $this->permissions($request, $animal),
        ]);
    }

    /**
     * Update the specified animal in storage.
     * @throws AuthorizationException
     * @throws Throwable
     */
    public function updateAnimal(
        UpdateAnimalRequest $animalRequest,
        FormRequest $animalableRequest,
        string $id,
    ): RedirectResponse {
        /** @var Animal|null $animal */
        $animal = Animal::find($id);
        if (!$animal) {
            return redirect()->route($this->getIndexRouteName());
        }

        $this->authorize('update', $animal);

        $animal = tenancy()->central(function () use (
            $animalableRequest,
            $animalRequest,
            $animal,
        ) {
            return DB::transaction(function () use (
                $animalableRequest,
                $animalRequest,
                $animal,
            ) {
                $animalableValidated = $animalableRequest->validated();

                $animal->animalable->update($animalableValidated);

                $validated = $animalRequest->validated();

                $animal->update($validated);

                return $animal;
            }, 5);
        });

        $changes = array_diff_key(
            array_merge(
                $animal->getChanges(),
                $animal->animalable->getChanges(),
            ),
            array_flip(['updated_at']),
        );

        AnimalUpdated::dispatch($animal, $changes, Auth::user());

        return $this->redirect($animalRequest, $this->getShowRouteName(), [
            'animal' => $animal,
        ]);
    }

    /**
     * Publish an animal.
     * @throws AuthorizationException
     */
    public function publish(Request $request, string $id): RedirectResponse
    {
        /** @var Animal|null $animal */
        $animal = Animal::find($id);
        if (!$animal) {
            return redirect()->route($this->getIndexRouteName());
        }

        $this->authorize('publish', $animal);

        $animal->update(['published_at' => now()]);

        return $this->redirect($request, $this->getShowRouteName(), [
            'animal' => $animal,
        ]);
    }

    /**
     * Browse all animals.
     */
    public function browse(): Response
    {
        $animals = Animal::whereNotNull('published_at')
            ->when(
                tenant(),
                function (Builder $query) {
                    return $query->where('organisation_id', tenant()->id);
                },
                function (Builder $query) {
                    return $query->with(['organisation']);
                },
            )
            ->get();

        return AppInertia::render('Animals/Browse', [
            'animals' => $animals,
        ]);
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

    /**
     * Store the animal for an animalable resource.
     *
     * @throws AuthorizationException
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

                // TODO: Optimise and queue
                foreach ($validated['images'] as $image) {
                    $img = Image::read($image);
                    $img->scaleDown(width: 1200);
                    $img->core()->native()->stripImage();

                    $quality = 90;
                    $encoded = $img->toWebp($quality);

                    while ($encoded->size() > 200000) {
                        $quality -= 5;
                        $encoded = $img->toWebp($quality);
                    }
                }

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
