<?php

namespace App\Listeners;

use App\Events\AddressSaved;
use Clickbar\Magellan\Data\Geometries\Point;
use Geocoder\Model\Address;

class UpdateGeoLocation
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(AddressSaved $event): void
    {
        /** @var Address $geo */
        $geo = app('geocoder')
            ->geocode($event->address->address_string)
            ->get()
            ->first();

        $point = Point::makeGeodetic(
            $geo->getCoordinates()->getLongitude(),
            $geo->getCoordinates()->getLatitude(),
        );

        $event->address->updateQuietly([
            'location' => $point,
        ]);
    }
}
