<?php

namespace App\Services;

use App\Models\Animal\Animal;
use App\Models\Animal\AnimalFamily;
use App\Models\Organisation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class AnimalFamilyService
{
    public function createOrUpdateFamily(
        FormRequest $request,
        Animal $animal,
        Organisation $organisation,
    ): void {
        $validated = $request->validated();

        // Family removed from animal
        if (!isset($validated['family'])) {
            $animal->family()->dissociate();
            return;
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
        } else {
            $family = $this->createFamily(
                name: $validated['family'],
                mother: $mother,
                father: $father,
                organisation: $organisation,
                type: $animal->animalable_type,
            );
        }

        if (!$isParent) {
            $animal->family()->associate($family);
        } else {
            $animal->family()->dissociate();
        }
        $animal->save();
    }

    public function updateFamily($id, $mother, $father): AnimalFamily
    {
        /** @var AnimalFamily $family */
        $family = AnimalFamily::find($id);

        $family->mother()->associate($mother);
        $family->father()->associate($father);
        $family->save();

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
