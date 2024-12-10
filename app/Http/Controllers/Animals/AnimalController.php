<?php

namespace App\Http\Controllers\Animals;

use App\Events\Animals\AnimalDeleted;
use App\Events\Animals\AnimalPublished;
use App\Events\Animals\AnimalUpdated;
use App\Http\AppInertia;
use App\Http\Controllers\Controller;
use App\Http\Requests\Animals\CreateAnimalRequest;
use App\Models\Animal\Animal;
use App\Models\Animal\AnimalFamily;
use App\Models\Animal\AnimalHistory;
use App\Services\AnimalService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Builder;
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
        /** @var Animal|null $animal */
        $animal = Animal::find($id);
        if (!$animal) {
            return redirect()->route($this->getIndexRouteName());
        }

        $this->authorize('view', $animal);

        $history = AnimalHistory::internalHistory($animal);

        return AppInertia::render($this->getShowView(), [
            'animal' => $animal,
            'history' => $history,
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
     * Display the public version of the specified resource.
     * @throws AuthorizationException
     */
    public function showPublic(string $id): RedirectResponse|Response
    {
        /** @var Animal|null $animal */
        $animal = Animal::find($id);
        if (!$animal) {
            return redirect()->route('animals.browse');
        }

        $animal->makeHidden('abstract');

        $history = AnimalHistory::publicHistory($animal);

        return AppInertia::render('Animals/Show', [
            'animal' => $animal,
            'history' => $history,
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

        AnimalDeleted::dispatch($animal, Auth::user());

        return redirect()->route($this->getIndexRouteName());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, string $id)
    {
        /** @var Animal|null $animal */
        $animal = Animal::whereId($id)
            ->with([
                'medially' => function ($query) {
                    return $query->select(
                        'id',
                        'file_url',
                        'medially_id',
                        'medially_type',
                    );
                },
            ])
            ->get()
            ->first();
        if (!$animal) {
            return redirect()->route($this->getIndexRouteName());
        }

        $this->authorize('update', $animal);

        $families = AnimalFamily::all();

        return AppInertia::render($this->getEditView(), [
            'animal' => $animal,
            'families' => $families,
            'permissions' => $this->permissions($request, $animal),
        ]);
    }

    /**
     * Update the specified animal in storage.
     * @throws AuthorizationException
     * @throws Throwable
     */
    public function updateAnimal(
        FormRequest $animalRequest,
        string $id,
    ): RedirectResponse {
        /** @var Animal|null $animal */
        $animal = Animal::find($id);
        if (!$animal) {
            return redirect()->route($this->getIndexRouteName());
        }

        $this->authorize('update', $animal);

        $organisation = tenant();

        $changedMedia = ['removed_media' => false, 'added_media' => false];

        $animal = tenancy()->central(function () use (
            $organisation,
            $animalRequest,
            $animal,
            &$changedMedia,
        ) {
            return DB::transaction(function () use (
                $organisation,
                $animalRequest,
                $animal,
                &$changedMedia,
            ) {
                $validated = $animalRequest->validated();

                $animal->animalable->update($validated);

                if ($validated['images']) {
                    $allMedia = $animal->fetchAllMedia();

                    $mediaToKeep = [];
                    $newMedia = [];

                    array_map(function ($image) use (
                        &$mediaToKeep,
                        &$newMedia,
                    ) {
                        if (is_numeric($image)) {
                            $mediaToKeep[] = $image;
                        } else {
                            $newMedia[] = $image;
                        }
                    }, $validated['images']);

                    // Delete removed media
                    foreach ($allMedia as $media) {
                        if (!in_array($media->id, $mediaToKeep)) {
                            $animal->detachMedia($media);
                            $changedMedia['removed_media'] = true;
                        }
                    }

                    // Add new media
                    if (!empty($newMedia)) {
                        $changedMedia['added_media'] = true;
                        $this->attachMedia($animal, $newMedia, $organisation);
                    }
                }

                $animal->update($validated);

                return $animal;
            }, 5);
        });

        $changes = array_diff_key(
            array_merge(
                $animal->getChanges(),
                $animal->animalable->getChanges(),
                array_filter($changedMedia, fn($val) => $val),
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

        AnimalPublished::dispatch($animal, Auth::user());

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
        AnimalService $animalService,
        CreateAnimalRequest $animalRequest,
        $class,
    ): RedirectResponse {
        $this->authorize('create', Animal::class);

        $animal = $animalService->createAnimal($animalRequest, $class);

        return $this->redirect($animalRequest, $this->getShowRouteName(), [
            'animal' => $animal,
        ]);
    }

    /**
     * Show the form for creating a new animal.
     * @throws AuthorizationException
     */
    public function createAnimal($class): Response
    {
        $this->authorize('create', Animal::class);

        Animal::$withoutAppends = true;

        $families = AnimalFamily::subtype($class)->get();

        $animals = Animal::subtype($class)->asOption()->get();

        return AppInertia::render($this->getCreateView(), [
            'families' => $families,
            'animals' => $animals,
        ]);
    }
}
