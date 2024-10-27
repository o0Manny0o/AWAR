<?php

namespace App\Http\Controllers\Organisation;

use App\Http\Controllers\Controller;
use App\Http\Requests\Organisation\CreateOrganisationRequest;
use App\Models\Organisation;
use Illuminate\Http\Request;
use Inertia\Inertia;

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
    public function create(Request $request)
    {
        $domain = config("tenancy.central_domains")[0];
        return Inertia::render('Organisation/Create', [
            'domain' => $domain
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateOrganisationRequest $request)
    {
        $validated = $request->validated();

        $organisation = Organisation::create([
            'name' => $validated['name'],
        ]);

        $domain = config("tenancy.central_domains")[0] . '.' . $validated['subdomain'];

        $organisation->domains()->create([
            'subdomain' => $domain,
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
