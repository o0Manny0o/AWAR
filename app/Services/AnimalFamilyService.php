<?php

namespace App\Services;

use App\Models\Animal\Animal;
use App\Models\Animal\AnimalFamily;
use App\Models\Organisation;
use Illuminate\Support\Str;

class AnimalFamilyService
{
    public function createOrUpdateFamily(
        array $validated,
        Animal $animal,
        Organisation $organisation,
    ): array {
        // Family removed from animal (only removes if animal was child)
        // TODO: Add better support for managing parental families with separate form field
        if (!isset($validated['family'])) {
            $animal->family()->dissociate();
            return [];
        }

        /** $validated['mother'] & $validated['father']
         *
         * - '0' = newly created $animal is mother / father
         * - null = no mother / father
         * - string = id of mother / father
         */

        $mother =
            $validated['mother'] === '0' || $validated['mother'] === $animal->id
                ? $animal->id
                : $validated['mother'];

        $father =
            $validated['father'] === '0' || $validated['father'] === $animal->id
                ? $animal->id
                : $validated['father'];

        $isParent = $mother === $animal->id || $father === $animal->id;

        if (Str::isUuid($validated['family'])) {
            $family = $this->updateFamily(
                id: $validated['family'],
                mother: $mother,
                father: $father,
            );
            $changes = $family->getDirty();
            $prev = $family->getOriginal();
            $animalChanges = [];

            if (isset($changes['father_id'])) {
                if (isset($prev['father_id'])) {
                    $animalChanges[$prev['father_id']] = [
                        'father_removed' => $family->id,
                    ];
                }
                if ($changes['father_id']) {
                    $animalChanges[$changes['father_id']] = [
                        'father_added' => $family->id,
                    ];
                }
            }

            if (isset($changes['mother_id'])) {
                if (isset($prev['mother_id'])) {
                    $animalChanges[$prev['mother_id']] = [
                        'mother_removed' => $family->id,
                    ];
                }
                if ($changes['mother_id']) {
                    $animalChanges[$changes['mother_id']] = [
                        'mother_added' => $family->id,
                    ];
                }
            }
            $family->save();
        } else {
            $family = $this->createFamily(
                name: $validated['family'],
                mother: $mother,
                father: $father,
                organisation: $organisation,
                type: $animal->animalable_type,
            );
            $animalChanges = array_merge(
                [
                    $animal->id => [
                        'father_added' =>
                            $father === $animal->id ? $family->id : null,
                        'mother_added' =>
                            $mother === $animal->id ? $family->id : null,
                    ],
                ],
                $father && $father !== $animal->id
                    ? [$father => ['father_added' => true]]
                    : [],
                $father && $mother !== $animal->id
                    ? [$mother => ['mother_added' => true]]
                    : [],
            );
        }

        if (!$isParent) {
            $animal->family()->associate($family);
        } else {
            $animal->family()->dissociate();
        }
        $animal->save();

        return $animalChanges;
    }

    public function updateFamily($id, $mother, $father): AnimalFamily
    {
        /** @var AnimalFamily $family */
        $family = AnimalFamily::find($id);

        $family->mother()->associate($mother);
        $family->father()->associate($father);
        //        $family->save();

        return $family;
    }

    public function createFamily(
        $name,
        $mother,
        $father,
        $organisation,
        $type,
    ): AnimalFamily {
        $values = [
            'name' => $name,
            'organisation_id' => $organisation->id,
            'family_type' => $type,
            'mother_id' => $mother,
            'father_id' => $father,
        ];
        /** @var AnimalFamily $family */
        $family = AnimalFamily::create($values);
        return $family;
    }
}
