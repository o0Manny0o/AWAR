<?php

namespace App\Services;

use App\Http\Requests\Animals\CreateAnimalRequest;
use App\Models\Animal\Animal;
use App\Models\Animal\AnimalFamily;
use App\Models\Organisation;
use Illuminate\Support\Str;

class AnimalFamilyService
{
    public function createOrUpdateFamily(
        CreateAnimalRequest $request,
        Animal $animal,
        Organisation $organisation,
        $class,
    ): void {
        $validated = $request->validated();

        $mother =
            $validated['mother'] === '0' ? $animal->id : $validated['mother'];

        $father =
            $validated['father'] === '0' ? $animal->id : $validated['father'];

        $child =
            $validated['mother'] === '0' && $validated['father'] === '0'
                ? $animal
                : null;

        if (Str::isUuid($validated['family'])) {
            $this->updateFamily(
                id: $validated['family'],
                mother: $mother,
                father: $father,
                child: $child,
            );
        } else {
            $this->createFamily(
                name: $validated['family'],
                mother: $mother,
                father: $father,
                organisation: $organisation,
                type: $class,
                child: $child,
            );
        }
    }

    public function updateFamily($id, $mother, $father, $child = null): void
    {
        /** @var AnimalFamily $family */
        $family = AnimalFamily::find($id);

        $family->mother()->associate($mother);
        $family->father()->associate($father);
        $family->save();

        if ($child) {
            $child->family()->associate($family);
            $child->save();
        }
    }

    public function createFamily(
        $name,
        $mother,
        $father,
        $organisation,
        $type,
        $child = null,
    ): void {
        $values = [
            'name' => $name,
            'organisation_id' => $organisation->id,
            'family_type' => $type,
            'mother_id' => $mother,
            'father_id' => $father,
        ];

        if ($child) {
            $child->family()->create($values);
        } else {
            AnimalFamily::create($values);
        }
    }
}
