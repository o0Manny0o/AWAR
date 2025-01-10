<?php

namespace App\Http\Controllers\Animals;

use App\Http\Controllers\Controller;
use App\Http\Requests\Animals\RequestWithAnimalType;
use App\Http\Requests\Animals\StoreAnimalListingRequest;
use App\Http\Requests\Animals\UpdateAnimalListingRequest;
use App\Models\Animal\AnimalListing;
use Illuminate\Database\Eloquent\Builder;

class AnimalListingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(RequestWithAnimalType $request)
    {
        $this->authorize('viewAny', AnimalListing::class);

        $listings = AnimalListing::whereHas('animals', function (
            Builder $query,
        ) use ($request) {
            $query->whereHasMorph('animalable', [
                $request->input('animal_type'),
            ]);
        })->get();

        dd($listings);
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
    public function store(StoreAnimalListingRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(AnimalListing $animalListing)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AnimalListing $animalListing)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        UpdateAnimalListingRequest $request,
        AnimalListing $animalListing,
    ) {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AnimalListing $animalListing)
    {
        //
    }
}
