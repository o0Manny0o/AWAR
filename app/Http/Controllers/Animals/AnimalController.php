<?php

namespace App\Http\Controllers\Animals;

use App\Events\Animals\AnimalDeleted;
use App\Http\AppInertia;
use App\Http\Controllers\Controller;
use App\Http\Requests\Animals\AssignFosterHomeRequest;
use App\Http\Requests\Animals\AssignHandlerRequest;
use App\Http\Requests\Animals\AssignLocationRequest;
use App\Http\Requests\Animals\CreateAnimalRequest;
use App\Http\Requests\Animals\UpdateAnimalRequest;
use App\Models\Animal\Animal;
use App\Models\Animal\AnimalFamily;
use App\Models\Animal\AnimalHistory;
use App\Models\Tenant\OrganisationLocation;
use App\Models\User;
use App\Services\AnimalService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Response;
use Throwable;

class AnimalController extends Controller
{
    protected string $morphClass;

    public function __construct(protected readonly AnimalService $animalService)
    {
    }

    /**
     * Display the specified resource.
     * @throws AuthorizationException
     */
    public function show(
        Request $request,
        Animal $animal,
    ): RedirectResponse|Response {
        $this->authorize('view', $animal);

        $animal->append('handler');
        $animal->append('fosterHome');
        $animal->append('location');

        $history = AnimalHistory::internalHistory($animal);

        $handlers = $request->user()->can('assign', $animal)
            ? User::handlers()->get()
            : [];
        $fosterHomes = $request->user()->can('assignFosterHome', $animal)
            ? User::fosterHomes()->get()
            : [];
        $locations = $request->user()->can('assignLocation', $animal)
            ? OrganisationLocation::select(['id', 'name'])->get()
            : [];

        $animal?->setPermissions($request->user());

        return AppInertia::render($this->getShowView(), [
            'animal' => $animal,
            'history' => $history,
            'handlers' => $handlers,
            'fosterHomes' => $fosterHomes,
            'locations' => $locations,
            'canCreate' => $request->user()->can('create', Animal::class),
        ]);
    }

    /**
     * Display the public version of the specified resource.
     */
    public function showPublic(Animal $animal): RedirectResponse|Response
    {
        $history = AnimalHistory::publicHistory($animal);

        return AppInertia::render('Animals/Show', [
            'animal' => $animal,
            'history' => $history,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     * @throws AuthorizationException
     */
    public function destroy(Animal $animal): RedirectResponse
    {
        $this->authorize('delete', $animal);

        $animal->delete();

        AnimalDeleted::dispatch($animal, Auth::user());

        return redirect()->route($this->getIndexRouteName());
    }

    /**
     * Show the form for editing the specified resource.
     * @throws AuthorizationException
     */
    public function edit(Request $request, Animal $animal): Response
    {
        $this->authorize('update', $animal);

        $animal->load([
            'paternalFamilies:id,name,mother_id,father_id',
            'maternalFamilies:id,name,mother_id,father_id',
        ]);

        $animal->setForceAppends(['father', 'mother']);

        $families = AnimalFamily::subtype($this->morphClass)->get();

        Animal::$withoutAppends = true;

        $animals = Animal::subtype($this->morphClass)
            ->asOption()
            ->get();

        return AppInertia::render($this->getEditView(), [
            'animal' => $animal,
            'families' => $families,
            'animals' => $animals,
        ]);
    }

    /**
     * Update the specified animal in storage.
     * @throws AuthorizationException
     * @throws Throwable
     */
    public function updateAnimal(
        UpdateAnimalRequest $animalRequest,
        Animal $animal,
    ): RedirectResponse {
        $this->authorize('update', $animal);

        $this->animalService->updateAnimal(
            $animalRequest,
            $animal,
            Auth::user(),
        );

        return $this->redirect($animalRequest, $this->getShowRouteName(), [
            'animal' => $animal,
        ]);
    }

    /**
     * Publish an animal.
     * @throws AuthorizationException
     */
    public function publish(Request $request, Animal $animal): RedirectResponse
    {
        $this->authorize('publish', $animal);
        $this->animalService->publishAnimal($animal, Auth::user());

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
            ->get()
            ->makeHidden([
                'created_at',
                'updated_at',
                'published_at',
                'deleted_at',
                'animal_family_id',
                'can_be_viewed',
                'can_be_deleted',
                'can_be_updated',
                'can_be_published',
            ]);

        return AppInertia::render('Animals/Browse', [
            'animals' => $animals,
        ]);
    }

    /**
     * Display a listing of the resource.
     * @throws AuthorizationException
     */
    public function index(Request $request): Response
    {
        $this->authorize('viewAny', Animal::class);

        $animals = $this->animalService->loadAnimalsWithPermissions(
            $this->morphClass,
            $request->user(),
        );

        $animals->each(
            fn(Animal $animal) => $animal->setPermissions($request->user()),
        );

        return AppInertia::render($this->getIndexView(), [
            'animals' => $animals,
            'canCreate' => $request->user()->can('create', Animal::class),
        ]);
    }

    /**
     * Show the form for creating a new animal.
     * @throws AuthorizationException
     */
    public function create(): Response
    {
        $this->authorize('create', Animal::class);

        Animal::$withoutAppends = true;

        $families = AnimalFamily::subtype($this->morphClass)->get();

        $animals = Animal::subtype($this->morphClass)
            ->asOption()
            ->get();

        return AppInertia::render($this->getCreateView(), [
            'families' => $families,
            'animals' => $animals,
        ]);
    }

    /**
     * Assign an authorised handler to an animal.
     *
     * @throws AuthorizationException
     * @throws Throwable
     */
    public function assign(
        AnimalService $animalService,
        AssignHandlerRequest $animalRequest,
        Animal $animal,
    ): RedirectResponse {
        $this->authorize('assign', $animal);

        $validated = $animalRequest->validated();

        $animalService->assignHandler($animal, $validated['id'], Auth::user());

        return $this->redirect($animalRequest, $this->getShowRouteName(), [
            'animal' => $animal->first()->id,
        ]);
    }

    /**
     * Assign a foster home to an animal.
     *
     * @throws AuthorizationException
     * @throws Throwable
     */
    public function assignFosterHome(
        AnimalService $animalService,
        AssignFosterHomeRequest $animalRequest,
        Animal $animal,
    ): RedirectResponse {
        $this->authorize('assignFosterHome', $animal);

        $validated = $animalRequest->validated();

        $animalService->assignFosterHome(
            $animal,
            $validated['id'],
            Auth::user(),
        );

        return $this->redirect($animalRequest, $this->getShowRouteName(), [
            'animal' => $animal,
        ]);
    }

    /**
     * Assign a location to an animal.
     *
     * @throws AuthorizationException
     * @throws Throwable
     */
    public function assignLocation(
        AnimalService $animalService,
        AssignLocationRequest $animalRequest,
        Animal $animal,
    ): RedirectResponse {
        $this->authorize('assignLocation', $animal);

        $validated = $animalRequest->validated();

        $animalService->assignLocation($animal, $validated, Auth::user());

        return $this->redirect($animalRequest, $this->getShowRouteName(), [
            'animal' => $animal,
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

        $validated = $animalRequest->validated();

        $animal = $animalService->createAnimal(
            $validated,
            $class,
            Auth::user(),
        );

        return $this->redirect($animalRequest, $this->getShowRouteName(), [
            'animal' => $animal,
        ]);
    }
}
