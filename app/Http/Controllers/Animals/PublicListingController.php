<?php

namespace App\Http\Controllers\Animals;

use App\Http\AppInertia;
use App\Http\Controllers\Controller;
use App\Models\Animal\AnimalHistory;
use App\Models\Animal\Listing\Listing;

class PublicListingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $listings = Listing::with('animals')->get();

        foreach ($listings as $listing) {
            $listing->append('breed');
        }

        return AppInertia::render('Animals/Browse', [
            'listings' => $listings,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Listing $listing)
    {
        $listing->load('animals');

        $histories = array_map(function ($animal) {
            return AnimalHistory::publicHistory($animal);
        }, $listing->animals()->get()->all());

        return AppInertia::render('Animals/Show', [
            'listing' => $listing,
            'histories' => $histories,
        ]);
    }
}
