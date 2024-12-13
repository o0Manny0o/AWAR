<?php

namespace App\Http\Controllers\Tenant;

use App\Http\AppInertia;
use App\Http\Controllers\Controller;
use App\Models\Tenant\OrganisationLocation;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

class OrganisationLocationController extends Controller
{
    protected string $baseRouteName = 'settings.locations';
    protected string $baseViewPath = 'Tenant/Settings/Location';

    private function permissions(
        Request $request,
        OrganisationLocation $location = null,
    ): array {
        $location?->setPermissions($request->user());

        return [
            'organisations' => [
                'locations' => [
                    'create' => $request
                        ->user()
                        ->can('create', OrganisationLocation::class),
                    'view' => $request->user()->can('view', $location),
                ],
            ],
        ];
    }

    /**
     * Display a listing of the resource.
     * @throws AuthorizationException
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', OrganisationLocation::class);

        $locations = OrganisationLocation::all();

        return AppInertia::render($this->getIndexView(), [
            'locations' => $locations,
            'permissions' => $this->permissions($request),
        ]);
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
    public function store(Request $request)
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
