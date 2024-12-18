<?php

namespace App\Http\Controllers\Tenant;

use App\Http\AppInertia;
use App\Http\Controllers\Controller;
use App\Http\Requests\Organisation\Location\OrganisationLocationRequest;
use App\Models\Country;
use App\Models\Organisation;
use App\Models\Tenant\OrganisationLocation;
use App\Services\OrganisationLocationService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Response;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Throwable;

class OrganisationLocationController extends Controller
{
    protected string $baseRouteName = 'settings.locations';
    protected string $baseViewPath = 'Tenant/Settings/Location';

    /**
     * Display a listing of the resource.
     * @throws AuthorizationException
     */
    public function index(Request $request): Response
    {
        $this->authorize('viewAny', OrganisationLocation::class);

        $locations = OrganisationLocation::all()->each(
            fn(OrganisationLocation $location) => $location->setPermissions(
                $request->user(),
            ),
        );

        return AppInertia::render($this->getIndexView(), [
            'locations' => $locations,
            'permissions' => $this->permissions($request),
        ]);
    }

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
     * Store a newly created resource in storage.
     * @throws AuthorizationException
     * @throws Throwable
     */
    public function store(
        OrganisationLocationRequest $request,
        OrganisationLocationService $service,
    ): RedirectResponse {
        $this->authorize('create', OrganisationLocation::class);
        $validated = $request->validated();

        /** @var Organisation|null $organisation */
        $organisation = tenant();

        if (!$organisation) {
            throw new BadRequestException();
        }

        $location = $service->createLocation($organisation, $validated);

        return $this->redirect($request, $this->getShowRouteName(), [
            'location' => $location,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @throws AuthorizationException
     */
    public function create(): Response
    {
        $this->authorize('create', OrganisationLocation::class);

        $countries = Country::all(['alpha', 'code'])->map(
            fn(Country $country) => [
                'id' => $country->alpha,
                'name' => __('countries.' . Str::lower($country->alpha)),
            ],
        );

        return AppInertia::render($this->getCreateView(), [
            'countries' => $countries,
        ]);
    }

    /**
     * Display the specified resource.
     * @throws AuthorizationException
     */
    public function show(string $id): Response|RedirectResponse
    {
        /** @var OrganisationLocation|null $location */
        $location = OrganisationLocation::find($id);
        if (!$location) {
            return redirect()->route($this->getIndexRouteName());
        }

        $this->authorize('view', $location);

        return AppInertia::render($this->getShowView(), [
            'location' => $location,
            'permissions' => $this->permissions(request(), $location),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     * @throws AuthorizationException
     */
    public function edit(string $id): Response|RedirectResponse
    {
        /** @var OrganisationLocation|null $location */
        $location = OrganisationLocation::find($id);
        if (!$location) {
            return redirect()->route($this->getIndexRouteName());
        }

        $this->authorize('update', $location);

        $countries = Country::all(['alpha', 'code'])->map(
            fn(Country $country) => [
                'id' => $country->alpha,
                'name' => __('countries.' . Str::lower($country->alpha)),
            ],
        );

        return AppInertia::render($this->getEditView(), [
            'location' => $location,
            'countries' => $countries,
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @throws AuthorizationException
     * @throws Throwable
     */
    public function update(
        OrganisationLocationRequest $request,
        OrganisationLocationService $service,
        string $id,
    ): RedirectResponse {
        /** @var OrganisationLocation|null $location */
        $location = OrganisationLocation::find($id);
        if (!$location) {
            return redirect()->route($this->getIndexRouteName());
        }

        $this->authorize('update', $location);

        /** @var Organisation|null $organisation */
        $organisation = tenant();

        if (!$organisation) {
            throw new BadRequestException();
        }

        $validated = $request->validated();

        $location = $service->updateLocation($location, $validated);

        return $this->redirect($request, $this->getShowRouteName(), [
            'location' => $location,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     * @throws AuthorizationException
     */
    public function destroy(string $id): RedirectResponse
    {
        /** @var OrganisationLocation|null $location */
        $location = OrganisationLocation::find($id);
        if (!$location) {
            return redirect()->route($this->getIndexRouteName());
        }

        $this->authorize('delete', $location);

        $location->delete();

        return redirect()->route($this->getIndexRouteName());
    }
}
