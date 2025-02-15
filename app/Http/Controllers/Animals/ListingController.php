<?php

namespace App\Http\Controllers\Animals;

use App\Http\AppInertia;
use App\Http\Requests\Animals\RequestWithAnimalType;
use App\Http\Requests\Animals\StoreListingRequest;
use App\Http\Requests\Animals\UpdateListingRequest;
use App\Models\Animal\Animal;
use App\Models\Animal\Listing\Listing;
use App\Services\AnimalService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ListingController extends AnimalTypedController
{
    public function __construct(
        RequestWithAnimalType $requestWithAnimalType,
        protected readonly AnimalService $animalService,
    ) {
        parent::__construct($requestWithAnimalType);
        static::$baseRouteName = static::$baseRouteName . '.listing';
        static::$baseViewPath = 'Tenant/Animals/Listings';
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Listing::class);

        $listings = Listing::whereHas('animals', function (Builder $query) {
            $query->whereHasMorph('animalable', [self::$animal_model]);
        })
            ->with('animals')
            ->get();

        $listings->each(
            fn(Listing $listing) => $listing->setPermissions($request->user()),
        );

        return AppInertia::render($this->getIndexView(), [
            'listings' => $listings,
            'type' => self::getAnimalModel()::$type,
            'canCreate' => $request->user()->can('create', Listing::class),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @throws AuthorizationException
     */
    public function create(Request $request, Animal $animal = null)
    {
        $this->authorize('create', Listing::class);

        $animals = Animal::subtype(self::$animal_model)
            ->select(['id', 'name', 'animal_family_id'])
            ->with('family:id,name')
            ->get();

        return AppInertia::render($this->getCreateView(), [
            'animal' => $animal,
            'animals' => $animals,
            'type' => self::getAnimalModel()::$type,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @throws AuthorizationException
     */
    public function store(StoreListingRequest $request)
    {
        $this->authorize('create', Animal::class);

        $validated = $request->validated();

        $listing = Listing::create($validated);

        $listing->animals()->sync($validated['animals']);

        return $this->redirect($request, $this->getShowRouteName(), [
            'listing' => $listing,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Listing $listing)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Listing $listing)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateListingRequest $request, Listing $listing)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Listing $listing)
    {
        //
    }
}
