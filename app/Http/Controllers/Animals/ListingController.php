<?php

namespace App\Http\Controllers\Animals;

use App\Events\Animals\ListingCreated;
use App\Events\Animals\ListingDeleted;
use App\Http\AppInertia;
use App\Http\Requests\Animals\CreateListingRequest;
use App\Http\Requests\Animals\RequestWithAnimalType;
use App\Http\Requests\Animals\UpdateListingRequest;
use App\Models\Animal\Animal;
use App\Models\Animal\Listing\Listing;
use App\Models\Scopes\WithAnimalableScope;
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
        static::$baseRouteName = static::$baseRouteName . '.listings';
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
     * Store a newly created resource in storage.
     * @throws AuthorizationException
     */
    public function store(CreateListingRequest $request)
    {
        $this->authorize('create', Animal::class);

        $validated = $request->validated();

        /** @var Listing $listing */
        $listing = Listing::create($validated);

        $listing->animals()->sync($validated['animals']);

        $animals = $listing
            ->animals()
            ->withoutGlobalScope(WithAnimalableScope::class)
            ->setEagerLoads([]);

        /* @var array $images */
        $images = $request->validated('images');

        $animalsWithImages = $animals
            ->whereHas('medially', function (Builder $query) use ($images) {
                $query->whereIn('id', $images);
            })
            ->get();

        foreach ($animalsWithImages as $animal) {
            $img = array_filter($images, function ($image) use ($animal) {
                return array_filter($animal->media->all(), function (
                    $media,
                ) use ($image) {
                    return $media['id'] === $image;
                });
            });
            $animal->pivot->media()->syncWithoutDetaching($img);
        }

        foreach ($animals->get() as $animal) {
            ListingCreated::dispatch($animal, $request->user(), $listing);
        }

        return $this->redirect($request, $this->getShowRouteName(), [
            'listing' => $listing,
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
            ->get()
            ->append('media');

        return AppInertia::render($this->getCreateView(), [
            'animal' => $animal,
            'animals' => $animals,
            'type' => self::getAnimalModel()::$type,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Listing $listing)
    {
        $this->authorize('view', $listing);

        $listing->setPermissions($request->user());

        $listing->load([
            'listingAnimals.animal',
            'listingAnimals.media:file_url',
        ]);

        return AppInertia::render($this->getShowView(), [
            'listing' => $listing,
            'type' => self::getAnimalModel()::$type,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Listing $listing)
    {
        $this->authorize('update', $listing);

        $listing->load(['animals', 'listingAnimals.media:id']);

        $listing->animals->append('media');
        $listing->append('media');

        $animals = Animal::subtype(self::$animal_model)
            ->select(['id', 'name', 'animal_family_id'])
            ->with('family:id,name')
            ->get()
            ->append('media');

        return AppInertia::render($this->getEditView(), [
            'listing' => $listing,
            'animals' => $animals,
            'type' => self::getAnimalModel()::$type,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateListingRequest $request, Listing $listing)
    {
        $this->authorize('update', $listing);

        $listing->update($request->safe()->only(['excerpt', 'description']));

        $listing->animals()->sync($request->validated('animals'));

        $animals = $listing
            ->animals()
            ->withoutGlobalScope(WithAnimalableScope::class)
            ->setEagerLoads([])
            ->withPivot('id');

        foreach ($animals->get() as $animal) {
            $media = $animal->pivot->media()->get();

            foreach ($media as $m) {
                if (!in_array($m->id, $request->validated('images'))) {
                    $animal->pivot->media()->detach($m->id);
                }
            }
        }

        /* @var array $images */
        $images = $request->validated('images');

        $animalsWithImages = $animals
            ->whereHas('medially', function (Builder $query) use ($images) {
                $query->whereIn('id', $images);
            })
            ->get();

        foreach ($animalsWithImages as $animal) {
            $img = array_filter($images, function ($image) use ($animal) {
                return array_filter($animal->media->all(), function (
                    $media,
                ) use ($image) {
                    return $media['id'] === $image;
                });
            });
            $animal->pivot->media()->syncWithoutDetaching($img);
        }

        return $this->redirect($request, $this->getShowRouteName(), [
            'listing' => $listing,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Listing $listing)
    {
        $this->authorize('delete', $listing);

        $animals = $listing->animals()->get();

        foreach ($animals as $animal) {
            ListingDeleted::dispatch($animal, $request->user(), $listing);
        }

        $listing->delete();

        return redirect()->route($this->getIndexRouteName());
    }
}
