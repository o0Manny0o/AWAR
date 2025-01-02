<?php

namespace App\Listeners;

use App\Enum\AnimalHistoryType;
use App\Events\Animals\AnimalCreated;
use App\Events\Animals\AnimalDeleted;
use App\Events\Animals\AnimalFosterHomeUpdated;
use App\Events\Animals\AnimalHandlerUpdated;
use App\Events\Animals\AnimalLocationUpdated;
use App\Events\Animals\AnimalPublished;
use App\Events\Animals\AnimalUnpublished;
use App\Events\Animals\AnimalUpdated;
use App\Interface\Trackable;
use App\Models\Animal\AnimalHistory;
use Illuminate\Events\Dispatcher;

class TrackAnimalChangesSubscriber
{
    /**
     * Handle the AnimalCreated event.
     */
    public function handleAnimalCreated(AnimalCreated $event): void
    {
        /** @var Trackable $animalable */
        $animalable = $event->animal->animalable;
        $animal = $event->animal;

        /** @var AnimalHistory $history */
        $history = $animal->histories()->create([
            'user_id' => $event->user->id,
            'public' => true,
        ]);

        $history->changes()->createMany(
            array_merge(
                array_map(
                    fn($col) => [
                        'field' => $col,
                        'value' => $animal[$col],
                    ],
                    array_filter(
                        $animal->getTracked(),
                        fn($col) => $animal[$col],
                    ),
                ),
                array_map(
                    fn($col) => [
                        'field' => $col,
                        'value' => $animalable[$col],
                    ],
                    array_filter(
                        $animalable->getTracked(),
                        fn($col) => $animalable[$col],
                    ),
                ),
                array_map(
                    fn($col, $val) => [
                        'field' => $col,
                        'value' => $val,
                    ],
                    array_keys($event->familyChanges),
                    $event->familyChanges,
                ),
            ),
        );
    }

    /**
     * Handle the AnimalUpdated event.
     */
    public function handleAnimalUpdated(AnimalUpdated $event): void
    {
        /** @var Trackable $animalable */
        $animalable = $event->animal->animalable;
        $animal = $event->animal;

        $animalChanges = array_intersect_key(
            $event->changes,
            array_flip($animal->getTracked()),
        );
        $animalableChanges = array_intersect_key(
            $event->changes,
            array_flip($animalable->getTracked()),
        );

        if (empty($animalChanges) && empty($animalableChanges)) {
            return;
        }

        /** @var AnimalHistory $history */
        $history = $animal->histories()->create([
            'user_id' => $event->user->id,
            'type' => AnimalHistoryType::UPDATE,
        ]);

        $history->changes()->createMany(
            array_merge(
                array_map(
                    fn($col, $val) => [
                        'field' => $col,
                        'value' => $val,
                    ],
                    array_keys($animalChanges),
                    array_values($animalChanges),
                ),
                array_map(
                    fn($col, $val) => [
                        'field' => $col,
                        'value' => $val,
                    ],
                    array_keys($animalableChanges),
                    array_values($animalableChanges),
                ),
            ),
        );
    }

    /**
     * Handle the AnimalDeleted event.
     */
    public function handleAnimalDeleted(AnimalDeleted $event): void
    {
        /** @var AnimalHistory $history */
        $event->animal->histories()->create([
            'user_id' => $event->user->id,
            'type' => AnimalHistoryType::DELETE,
        ]);
    }

    /**
     * Handle the AnimalPublished event.
     */
    public function handleAnimalPublished(AnimalPublished $event): void
    {
        /** @var AnimalHistory $history */
        $event->animal->histories()->create([
            'user_id' => $event->user->id,
            'type' => AnimalHistoryType::PUBLISH,
        ]);
    }

    /**
     * Handle the AnimalUnpublished event.
     */
    public function handleAnimalUnpublished(AnimalUnpublished $event): void
    {
        /** @var AnimalHistory $history */
        $event->animal->histories()->create([
            'user_id' => $event->user->id,
            'type' => AnimalHistoryType::UNPUBLISH,
        ]);
    }

    /**
     * Handle the AnimalUnpublished event.
     */
    public function handleAnimalHandlerUpdated(
        AnimalHandlerUpdated $event,
    ): void {
        /** @var AnimalHistory $history */
        $history = $event->animal->histories()->create([
            'user_id' => $event->user->id,
            'type' => $event->animal->handler_id
                ? AnimalHistoryType::HANDLER_ASSIGN
                : AnimalHistoryType::HANDLER_UNASSIGN,
        ]);

        $history->changes()->create([
            'field' => 'handler_id',
            'value' => $event->animal->handler_id,
        ]);
    }

    /**
     * Handle the AnimalFosterHomeUpdated event.
     */
    public function handleAnimalFosterHomeUpdated(
        AnimalFosterHomeUpdated $event,
    ): void {
        /** @var AnimalHistory $history */
        $history = $event->animal->histories()->create([
            'user_id' => $event->user->id,
            'type' => $event->animal->foster_home_id
                ? AnimalHistoryType::FOSTER_HOME_ASSIGN
                : AnimalHistoryType::FOSTER_HOME_UNASSIGN,
        ]);

        $history->changes()->create([
            'field' => 'foster_home_id',
            'value' => $event->animal->foster_home_id,
        ]);
    }

    /**
     * Handle the AnimalFosterHomeUpdated event.
     */
    public function handleAnimalLocationUpdated(
        AnimalLocationUpdated $event,
    ): void {
        /** @var AnimalHistory $history */
        $history = $event->animal->histories()->create([
            'user_id' => $event->user->id,
            'type' => $event->animal->locationable_id
                ? AnimalHistoryType::LOCATION_ASSIGN
                : AnimalHistoryType::LOCATION_UNASSIGN,
        ]);

        $history->changes()->createMany([
            [
                'field' => 'locationable_id',
                'value' => $event->animal->locationable_id,
            ],
            [
                'field' => 'locationable_type',
                'value' => $event->animal->locationable_type,
            ],
        ]);
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

        $events->listen(AnimalPublished::class, [
            TrackAnimalChangesSubscriber::class,
            'handleAnimalPublished',
        ]);

        $events->listen(AnimalUnpublished::class, [
            TrackAnimalChangesSubscriber::class,
            'handleAnimalUnpublished',
        ]);

        $events->listen(AnimalHandlerUpdated::class, [
            TrackAnimalChangesSubscriber::class,
            'handleAnimalHandlerUpdated',
        ]);

        $events->listen(AnimalFosterHomeUpdated::class, [
            TrackAnimalChangesSubscriber::class,
            'handleAnimalFosterHomeUpdated',
        ]);

        $events->listen(AnimalLocationUpdated::class, [
            TrackAnimalChangesSubscriber::class,
            'handleAnimalLocationUpdated',
        ]);
    }
}
