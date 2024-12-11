<?php

namespace App\Services;

use App\Events\Animals\AnimalCreated;
use App\Http\Requests\Animals\CreateAnimalRequest;
use App\Models\Animal\Animal;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AnimalService
{
    public function __construct(
        private readonly AnimalFamilyService $animalFamilyService,
    ) {
    }

    /**
     * @throws Exception|\Throwable
     */
    public function createAnimal(CreateAnimalRequest $animalRequest, $class)
    {
        $organisation = tenant();

        return tenancy()->central(function () use (
            $organisation,
            $class,
            $animalRequest,
        ) {
            return DB::transaction(function () use (
                $organisation,
                $class,
                $animalRequest,
            ) {
                $validated = $animalRequest->validated();

                $animalable = $class::create($validated);

                /** @var Animal $animal */
                $animal = $animalable->animal()->create(
                    array_merge($validated, [
                        'organisation_id' => $organisation->id,
                    ]),
                );

                if (isset($validated['family'])) {
                    $this->animalFamilyService->createOrUpdateFamily(
                        $animalRequest,
                        $animal,
                        $organisation,
                        $class,
                    );
                }

                try {
                    $this->attachMedia(
                        $animal,
                        $validated['images'],
                        $organisation,
                    );
                } catch (Exception $e) {
                    throw new \Exception('Image upload failed');
                }

                AnimalCreated::dispatch($animal, Auth::user());

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

    public function loadAnimalsWithPermissions(string $type, User $user)
    {
        $animals = Animal::subtype($type)->get();

        foreach ($animals as $animal) {
            $animal->setPermissions($user);
        }

        return $animals;
    }
}
