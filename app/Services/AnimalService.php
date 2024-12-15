<?php

namespace App\Services;

use App\Enum\DefaultTenantUserRole;
use App\Events\Animals\AnimalCreated;
use App\Events\Animals\AnimalFosterHomeUpdated;
use App\Events\Animals\AnimalHandlerUpdated;
use App\Events\Animals\AnimalPublished;
use App\Events\Animals\AnimalUpdated;
use App\Http\Requests\Animals\UpdateAnimalRequest;
use App\Models\Animal\Animal;
use App\Models\Tenant\Member;
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
    ) {
    }

    /**
     * @throws Exception|\Throwable
     */
    public function createAnimal(array $validated, $class, User $user)
    {
        $organisation = tenant();
        $isHandler = $user->member?->hasAnyRole([
            DefaultTenantUserRole::ADOPTION_HANDLER,
            DefaultTenantUserRole::ADOPTION_LEAD,
        ]);

        return tenancy()->central(function () use (
            $isHandler,
            $user,
            $organisation,
            $class,
            $validated,
        ) {
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
                        'organisation_id' => $organisation->id,
                        'handler_id' => $isHandler ? $user->global_id : null,
                    ]),
                );

                if (isset($validated['family'])) {
                    $changes = $this->animalFamilyService->createOrUpdateFamily(
                        $validated,
                        $animal,
                        $organisation,
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
                        $this->attachMedia(
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
        });
    }

    /**
     * @throws Exception
     */
    private function attachMedia(
        Animal $animal,
        array $media,
        $organisation,
    ): void {
        foreach ($media as $image) {
            $animal->attachMedia($image, [
                'asset_folder' => $organisation->id . '/animals/' . $animal->id,
                'public_id_prefix' =>
                    $organisation->id . '/animals/' . $animal->id,
                'width' => 2000,
                'crop' => 'limit',
                'format' => 'webp',
            ]);
        }
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

        $animal = tenancy()->central(function () use (
            $organisation,
            $animalRequest,
            $animal,
            &$changedMedia,
        ) {
            return DB::transaction(function () use (
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

                    array_map(function ($image) use (
                        &$mediaToKeep,
                        &$newMedia,
                    ) {
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
                        $this->attachMedia($animal, $newMedia, $organisation);
                    }
                }

                $changes = $this->animalFamilyService->createOrUpdateFamily(
                    $validated,
                    $animal,
                    $organisation,
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
        });

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
        mixed $validated,
        User $user,
    ): void {
        /** @var Member $assignee */
        $assignee = Member::firstWhere('global_id', $validated['id']);

        if (
            $assignee &&
            !$assignee->hasAnyRole(
                DefaultTenantUserRole::ADOPTION_LEAD,
                DefaultTenantUserRole::ADOPTION_HANDLER,
            )
        ) {
            throw new BadRequestException();
        }

        $animal->update(['handler_id' => $validated['id']]);

        if (count($animal->getChanges()) > 0) {
            AnimalHandlerUpdated::dispatch($animal, $user);
        }
    }

    public function assignFosterHome(
        Animal $animal,
        mixed $validated,
        User $user,
    ): void {
        /** @var Member $assignee */
        $assignee = Member::firstWhere('global_id', $validated['id']);

        if (
            $assignee &&
            !$assignee->hasRole(DefaultTenantUserRole::FOSTER_HOME)
        ) {
            throw new BadRequestException();
        }

        $animal->update(['foster_home_id' => $validated['id']]);

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
            /** @var Member $foster_home */
            $foster_home = Member::firstWhere('global_id', $validated['other']);

            if (
                $foster_home &&
                !$foster_home->hasRole(DefaultTenantUserRole::FOSTER_HOME)
            ) {
                throw new BadRequestException();
            }

            $animal->update([
                'locationable_id' => $foster_home->global_id,
                'locationable_type' => Member::class,
            ]);
        } elseif (!$validated['id']) {
            $animal->locationable()->dissociate();
        } else {
            $location = OrganisationLocation::find($validated['id']);
            $animal->locationable()->associate($location);
        }

        $animal->save();

        //        if (count($animal->getChanges()) > 0) {
        //            AnimalFosterHomeUpdated::dispatch($animal, $user);
        //        }
    }
}
