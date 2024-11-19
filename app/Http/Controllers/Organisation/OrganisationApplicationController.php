<?php

namespace App\Http\Controllers\Organisation;

use App\Http\Controllers\Controller;
use App\Http\Requests\Organisation\CreateOrganisationRequest;
use App\Models\OrganisationApplication;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class OrganisationApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $applications = OrganisationApplication::where('user_id', $request->user()->id)->get();
        return Inertia::render('Organisation/Application/Index', [
            'applications' => $applications
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): Response
    {
        $domain = config("tenancy.central_domains")[0];
        return Inertia::render('Organisation/Application/Create', [
            'domain' => $domain
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @throws ValidationException
     */
    public function store(CreateOrganisationRequest $request): void
    {
        //
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
