<?php

namespace App\Services;

use App\Models\Address;
use App\Models\Country;
use App\Models\Organisation;
use App\Models\Tenant\OrganisationLocation;
use Exception;
use Illuminate\Support\Facades\DB;
use Throwable;

class OrganisationLocationService
{
    /**
     * @throws Exception|Throwable
     */
    public function createLocation(
        Organisation $organisation,
        $validated,
    ): OrganisationLocation {
        return tenancy()->central(function () use ($organisation, $validated) {
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
    }

    /**
     * @throws Exception|Throwable
     */
    public function updateLocation(
        OrganisationLocation $location,
        $validated,
    ): OrganisationLocation {
        return tenancy()->central(function () use ($location, $validated) {
            return DB::transaction(function () use ($validated, $location) {
                $location->update($validated);

                $country = Country::where(
                    'alpha',
                    $validated['country'],
                )->first();

                Address::find($location->address->id)->update([
                    'street_address' => $validated['street_address'],
                    'locality' => $validated['locality'],
                    'region' => $validated['region'],
                    'postal_code' => $validated['postal_code'],
                    'country_id' => $country->code,
                ]);

                return $location;
            }, 3);
        });
    }
}
