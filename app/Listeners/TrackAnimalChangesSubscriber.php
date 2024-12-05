<?php

namespace App\Listeners;

use App\Events\Animals\AnimalCreated;
use App\Events\Animals\AnimalDeleted;
use App\Events\Animals\AnimalUpdated;
use App\Models\Animal\AnimalHistory;
use Illuminate\Events\Dispatcher;

class TrackAnimalChangesSubscriber
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the AnimalCreated event.
     */
    public function handleAnimalCreated(AnimalCreated $event): void
    {
        AnimalHistory::createInitialEntry($event);
    }

    /**
     * Handle the AnimalUpdated event.
     */
    public function handleAnimalUpdated(AnimalUpdated $event): void
    {
        AnimalHistory::createUpdateEntry($event);
    }

    /**
     * Handle the AnimalDeleted event.
     */
    public function handleAnimalDeleted(AnimalDeleted $event): void
    {
    }

    /**
     * Register the listeners for the subscriber.
     */
    public function subscribe(Dispatcher $events): void
    {
        $events->listen(AnimalCreated::class, [
            TrackAnimalChangesSubscriber::class,
            'handleAnimalCreated',
        ]);

        $events->listen(AnimalUpdated::class, [
            TrackAnimalChangesSubscriber::class,
            'handleAnimalUpdated',
        ]);

        $events->listen(AnimalDeleted::class, [
            TrackAnimalChangesSubscriber::class,
            'handleAnimalDeleted',
        ]);
    }
}
