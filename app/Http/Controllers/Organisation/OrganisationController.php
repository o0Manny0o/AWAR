<?php

namespace App\Http\Controllers\Organisation;

use App\Http\Controllers\Controller;
use App\Http\Requests\Organisation\CreateOrganisationRequest;
use App\Models\Organisation;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class OrganisationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): Response
    {
        $domain = config("tenancy.central_domains")[0];
        return Inertia::render('Organisation/Create', [
            'domain' => $domain
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateOrganisationRequest $request): void
    {
        $validated = $request->validated();

        $organisation = Organisation::create([
            'name' => $validated['name'],
        ]);

        $domain = $validated['subdomain'] . "." . config("tenancy.central_domains")[0];

        $organisation->domains()->create([
            'domain' => $domain,
        ]);
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
