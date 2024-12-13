<?php

namespace App\Http\Controllers\Tenant;

use App\Http\AppInertia;
use App\Http\Controllers\Controller;
use App\Http\Requests\Organisation\Location\CreateOrganisationLocationRequest;
use App\Models\Country;
use App\Models\Organisation;
use App\Models\Tenant\OrganisationLocation;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Inertia\Response;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

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

        $locations = OrganisationLocation::all();

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
     * @throws \Throwable
     */
    public function store(
        CreateOrganisationLocationRequest $request,
    ): RedirectResponse {
        $this->authorize('create', OrganisationLocation::class);
        $validated = $request->validated();

        /** @var Organisation|null $organisation */
        $organisation = tenant();

        if (!$organisation) {
            throw new BadRequestException();
        }

        $location = tenancy()->central(function () use (
            $organisation,
            $validated,
        ) {
            return DB::transaction(function () use ($validated, $organisation) {
                /** @var OrganisationLocation $location */
                $location = $organisation->locations()->create($validated);

                $country = Country::where(
                    'alpha',
                    $validated['country'],
                )->first();

                $location->address()->create(
                    array_merge($validated, [
                        'country_id' => $country->code,
                    ]),
                );

                return $location;
            }, 3);
        });

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
