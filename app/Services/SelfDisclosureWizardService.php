<?php

namespace App\Services;

use App\Enum\SelfDisclosure\SelfDisclosureStep;
use App\Models\SelfDisclosure\UserAnimalSpecificDisclosure;
use App\Models\SelfDisclosure\UserCatSpecificDisclosure;
use App\Models\SelfDisclosure\UserDogSpecificDisclosure;
use App\Models\SelfDisclosure\UserExperience;
use App\Models\SelfDisclosure\UserFamilyAnimal;
use App\Models\SelfDisclosure\UserFamilyHuman;
use App\Models\SelfDisclosure\UserFamilyMember;
use App\Models\SelfDisclosure\UserHome;
use Illuminate\Database\Eloquent\Builder;

class SelfDisclosureWizardService
{
    public function __construct(private readonly SelfDisclosureService $service)
    {
    }

    public function getCurrentStep(): SelfDisclosureStep
    {
        return SelfDisclosureStep::from(
            $this->service->getDisclosure()->furthest_step ??
                SelfDisclosureStep::PERSONAL->value,
        );
    }

    public function updateConfirmations($validated): void
    {
        $disclosure = $this->service->getDisclosure();

        $disclosure->update($validated);
    }

    public function updateFurthestStep(SelfDisclosureStep $step): void
    {
        $disclosure = $this->service->getDisclosure();
        if (!$disclosure->furthest_step) {
            return;
        }
        $savedStep = SelfDisclosureStep::from($disclosure->furthest_step);
        if ($step->index() <= $savedStep->index()) {
            return;
        }
        $disclosure->furthest_step = $step->value;
        $disclosure->save();
    }

    public function getPrimaryFamilyMember()
    {
        return UserFamilyMember::primary()->first();
    }

    public function hasAnimalFamilyMember(): bool
    {
        $disclosure = $this->service->getDisclosure();

        return $disclosure
            ->whereHas('userFamilyMembers', function (Builder $query) {
                $query->where('familyable_type', UserFamilyAnimal::class);
            })
            ->exists();
    }

    public function updatePrimaryFamilyMember($validated): void
    {
        $member = UserFamilyMember::primary()->first();

        $member->update([
            'name' => $validated['name'],
            'year' => $validated['year'],
        ]);

        $member->familyable->update([
            'profession' => $validated['profession'],
            'knows_animals' => $validated['knows_animals'],
        ]);
    }

    public function updateUserHome($validated): void
    {
        $disclosure = $this->service->getDisclosure();

        $home = UserHome::first();

        if (!$home) {
            $disclosure
                ->userHome()
                ->create(array_merge(['garden' => false], $validated));
        } else {
            $home->update($validated);
        }
    }

    public function updateUserEligibility($validated): void
    {
        $disclosure = $this->service->getDisclosure();

        $eligibility = $disclosure->userCareEligibility()->first();

        if (!$eligibility) {
            $disclosure->userCareEligibility()->create($validated);
        } else {
            $eligibility->update($validated);
        }
    }

    public function storeExperience($validated): void
    {
        $disclosure = $this->service->getDisclosure();
        $disclosure->userExperiences()->create($validated);
    }

    public function updateExperience(
        UserExperience $userExperience,
        $validated,
    ): void {
        $userExperience->update([
            'type' => $validated['type'],
            'animal_type' => $validated['animal_type'],
            'years' => $validated['years'] ?? null,
            'since' => $validated['since'] ?? null,
        ]);
    }

    public function storeFamilyMember($validated): void
    {
        $disclosure = $this->service->getDisclosure();

        if ($validated['animal']) {
            /** @var UserFamilyAnimal $humanMember */
            $familyable = UserFamilyAnimal::create($validated);
        } else {
            /** @var UserFamilyHuman $humanMember */
            $familyable = UserFamilyHuman::create($validated);
        }

        $familyMember = new UserFamilyMember([
            'name' => $validated['name'],
            'year' => $validated['year'],
        ]);

        $familyMember->familyable()->associate($familyable);

        $disclosure->userFamilyMembers()->save($familyMember);
    }

    public function updateFamilyMember(
        UserFamilyMember $userFamilyMember,
        $validated,
    ): void {
        $userFamilyMember->update([
            'name' => $validated['name'],
            'year' => $validated['year'],
        ]);

        if ($validated['animal']) {
            if ($userFamilyMember->familyable instanceof UserFamilyAnimal) {
                $userFamilyMember->familyable()->update([
                    'type' => $validated['type'],
                    'good_with_animals' => $validated['good_with_animals'],
                    'castrated' => $validated['castrated'],
                ]);
            } else {
                $userFamilyMember->familyable()->delete();
                /** @var UserFamilyAnimal $animalMember */
                $animalMember = UserFamilyAnimal::create($validated);
                $userFamilyMember->familyable()->associate($animalMember);
            }
        } else {
            if ($userFamilyMember->familyable instanceof UserFamilyHuman) {
                $userFamilyMember->familyable()->update([
                    'profession' => $validated['profession'] ?? null,
                    'knows_animals' => $validated['knows_animals'],
                ]);
            } else {
                $userFamilyMember->familyable()->delete();
                /** @var UserFamilyHuman $humanMember */
                $humanMember = UserFamilyHuman::create($validated);
                $userFamilyMember->familyable()->associate($humanMember);
            }
        }

        $userFamilyMember->save();
    }

    public function updateAnimalSpecificDisclosure($validated): void
    {
        $disclosure = $this->service->getDisclosure();

        $dogSpecific = UserAnimalSpecificDisclosure::dog()->first();

        $catSpecific = UserAnimalSpecificDisclosure::cat()->first();

        if (!$validated['dogs']) {
            $dogSpecific?->specifiable()->delete();
            $dogSpecific?->delete();
        } else {
            if (!$dogSpecific) {
                /** @var UserDogSpecificDisclosure $dogSpecific */
                $dogSpecific = UserDogSpecificDisclosure::create([
                    'habitat' => $validated['dog_habitat'],
                    'dog_school' => $validated['dog_school'],
                    'time_to_occupy' => $validated['dog_time_to_occupy'],
                    'purpose' => $validated['dog_purpose'],
                ]);

                $dogSpecific->animalDisclosure()->create([
                    'self_disclosure_id' => $disclosure->id,
                ]);
            } else {
                $dogSpecific->specifiable()->update([
                    'habitat' => $validated['dog_habitat'],
                    'dog_school' => $validated['dog_school'],
                    'time_to_occupy' => $validated['dog_time_to_occupy'],
                    'purpose' => $validated['dog_purpose'],
                ]);
            }
        }

        if (!$validated['cats']) {
            $catSpecific?->specifiable()->delete();
            $catSpecific?->delete();
        } else {
            if (!$catSpecific) {
                /** @var UserCatSpecificDisclosure $catSpecific */
                $catSpecific = UserCatSpecificDisclosure::create([
                    'habitat' => $validated['cat_habitat'],
                    'house_secure' => $validated['cat_house_secure'] ?? null,
                    'sleeping_place' =>
                        $validated['cat_sleeping_place'] ?? null,
                    'streets_safe' => $validated['cat_streets_safe'] ?? null,
                    'cat_flap_available' =>
                        $validated['cat_cat_flap_available'] ?? null,
                ]);

                $catSpecific->animalDisclosure()->create([
                    'self_disclosure_id' => $disclosure->id,
                ]);
            } else {
                $catSpecific->specifiable()->update([
                    'habitat' => $validated['cat_habitat'],
                    'house_secure' => $validated['cat_house_secure'] ?? null,
                    'sleeping_place' =>
                        $validated['cat_sleeping_place'] ?? null,
                    'streets_safe' => $validated['cat_streets_safe'] ?? null,
                    'cat_flap_available' =>
                        $validated['cat_flap_available'] ?? null,
                ]);
            }
        }
    }
}
