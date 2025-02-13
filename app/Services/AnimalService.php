<?php

namespace App\Services;

use App\Authorisation\Enum\OrganisationModule;
use App\Authorisation\Enum\PermissionType;
use App\Authorisation\PermissionContext;
use App\Events\Animals\AnimalCreated;
use App\Events\Animals\AnimalFosterHomeUpdated;
use App\Events\Animals\AnimalHandlerUpdated;
use App\Events\Animals\AnimalLocationUpdated;
use App\Events\Animals\AnimalPublished;
use App\Events\Animals\AnimalUpdated;
use App\Http\Requests\Animals\UpdateAnimalRequest;
use App\Models\Animal\Animal;
use App\Models\Tenant\OrganisationLocation;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class AnimalService
{
    public function __construct(
        private readonly AnimalFamilyService $animalFamilyService,
        private readonly MediaService $mediaService,
    ) {
    }

    /**
     * @throws Exception|\Throwable
     */
    public function createAnimal(array $validated, $class, User $user)
    {
        $organisation = tenant();
        $isHandler = $user->hasAnyPermission(
            PermissionType::CREATE->for(OrganisationModule::ANIMALS->value),
            PermissionType::CREATE->for(
                OrganisationModule::ASSIGNED_ANIMALS->value,
            ),
        );
        return DB::transaction(function () use (
            $isHandler,
            $user,
            $organisation,
            $class,
            $validated,
        ) {
            $animalable = $class::create($validated);

            $changes = [];

            /** @var Animal $animal */
            $animal = $animalable->animal()->create(
                array_merge($validated, [
                    'handler_id' => $isHandler ? $user->id : null,
                ]),
            );

            if (isset($validated['family'])) {
                $changes = $this->animalFamilyService->createOrUpdateFamily(
                    $validated,
                    $animal,
                );

                $changedAnimals = array_diff_key(
                    $changes,
                    array_flip([$animal->id]),
                );

                foreach ($changedAnimals as $id => $change) {
                    $a = Animal::find($id);
                    if ($a) {
                        AnimalUpdated::dispatch($a, $change, Auth::user());
                    }
                }
            }

            if (isset($validated['images'])) {
                try {
                    $this->mediaService->attachMedia(
                        $animal,
                        $validated['images'],
                        $organisation,
                    );
                } catch (Exception $e) {
                    throw new \Exception('Image upload failed');
                }
            }

            AnimalCreated::dispatch(
                $animal,
                array_key_exists($animal->id, $changes)
                    ? $changes[$animal->id]
                    : [],
                $user,
            );

            return $animal;
        }, 5);
    }

    /**
     * @throws Exception|\Throwable
     */
    public function updateAnimal(
        UpdateAnimalRequest $animalRequest,
        Animal $animal,
        User $user,
    ): void {
        $organisation = tenant();

        $changedMedia = ['removed_media' => false, 'added_media' => false];

        $animal = DB::transaction(function () use (
            $organisation,
            $animalRequest,
            $animal,
            &$changedMedia,
        ) {
            $validated = $animalRequest->validated();

            $animal->animalable->update($validated);

            if ($validated['images']) {
                $allMedia = $animal->fetchAllMedia();

                $mediaToKeep = [];
                $newMedia = [];

                array_map(function ($image) use (&$mediaToKeep, &$newMedia) {
                    if (is_numeric($image)) {
                        $mediaToKeep[] = $image;
                    } else {
                        $newMedia[] = $image;
                    }
                }, $validated['images']);

                // Delete removed media
                foreach ($allMedia as $media) {
                    if (!in_array($media->id, $mediaToKeep)) {
                        $animal->detachMedia($media);
                        $changedMedia['removed_media'] = true;
                    }
                }

                // Add new media
                if (!empty($newMedia)) {
                    $changedMedia['added_media'] = true;
                    $this->mediaService->attachMedia(
                        $animal,
                        $newMedia,
                        $organisation,
                    );
                }

                MediaService::setMediaOrder($validated['images']);
            }

            $changes = $this->animalFamilyService->createOrUpdateFamily(
                $validated,
                $animal,
            );

            $changedAnimals = array_diff_key(
                $changes,
                array_flip([$animal->id]),
            );

            foreach ($changedAnimals as $id => $change) {
                $a = Animal::find($id);
                if ($a) {
                    AnimalUpdated::dispatch($a, $change, Auth::user());
                }
            }

            $animal->update($validated);

            return $animal;
        }, 5);

        $changes = array_diff_key(
            array_merge(
                $animal->getChanges(),
                $animal->animalable->getChanges(),
                array_filter($changedMedia, fn($val) => $val),
            ),
            array_flip(['updated_at']),
        );

        AnimalUpdated::dispatch($animal, $changes, $user);
    }

    public function loadAnimalsWithPermissions(string $type, User $user)
    {
        $animals = Animal::subtype($type)->get();

        foreach ($animals as $animal) {
            $animal->setPermissions($user);
        }

        return $animals;
    }

    public function publishAnimal(Animal $animal, User $user): void
    {
        $animal->update(['published_at' => now()]);

        AnimalPublished::dispatch($animal, $user);
    }

    public function assignHandler(
        Animal $animal,
        string|null $id,
        User $user,
    ): void {
        /** @var User $assignee */
        $assignee = User::find($id);

        if ($assignee) {
            if (
                !PermissionContext::tenant($assignee, function ($user) {
                    return $user->hasAnyPermission(
                        PermissionType::UPDATE->for(
                            OrganisationModule::ANIMALS->value,
                        ),
                        PermissionType::UPDATE->for(
                            OrganisationModule::ASSIGNED_ANIMALS->value,
                        ),
                    );
                })
            ) {
                throw new BadRequestException();
            }
        }

        $animal->update(['handler_id' => $id]);

        if (count($animal->getChanges()) > 0) {
            AnimalHandlerUpdated::dispatch($animal, $user);
        }
    }

    public function assignFosterHome(
        Animal $animal,
        string|null $id,
        User $user,
    ): void {
        /** @var User $foster_home */
        $foster_home = User::find($id);

        if (
            $foster_home &&
            !$foster_home->hasPermissionTo(
                PermissionType::FOSTER->for(OrganisationModule::ANIMALS->value),
            )
        ) {
            throw new BadRequestException();
        }

        $animal->update(['foster_home_id' => $id]);

        if (count($animal->getChanges()) > 0) {
            AnimalFosterHomeUpdated::dispatch($animal, $user);
        }
    }

    public function assignLocation(
        Animal $animal,
        mixed $validated,
        User $user,
    ): void {
        if (isset($validated['other'])) {
            // Location is a foster home

            /** @var User $foster_home */
            $foster_home = User::find($validated['other']);

            if (
                $foster_home &&
                !$foster_home->hasPermissionTo(
                    PermissionType::FOSTER->for(
                        OrganisationModule::ANIMALS->value,
                    ),
                )
            ) {
                throw new BadRequestException();
            }

            $animal->update([
                'locationable_id' => $foster_home->id,
                'locationable_type' => User::class,
            ]);
        } elseif (!$validated['id']) {
            // Location was unset
            $animal->locationable()->dissociate();
        } else {
            // Location is an organisation location
            $location = OrganisationLocation::find($validated['id']);
            $animal->locationable()->associate($location);
        }

        $animal->save();

        if (count($animal->getChanges()) > 0) {
            AnimalLocationUpdated::dispatch($animal, $user);
        }
    }
}
