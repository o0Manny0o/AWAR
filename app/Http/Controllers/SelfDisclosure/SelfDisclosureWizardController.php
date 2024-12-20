<?php

namespace App\Http\Controllers\SelfDisclosure;

use App\Http\AppInertia;
use App\Http\Controllers\Controller;
use App\Http\Requests\Address\AddressRequest;
use App\Http\Requests\SelfDisclosure\Wizard\FamilyMemberSaveRequest;
use App\Http\Requests\SelfDisclosure\Wizard\PersonalUpdateRequest;
use App\Http\Requests\SelfDisclosure\Wizard\UserEligibilitySaveRequest;
use App\Http\Requests\SelfDisclosure\Wizard\UserExperienceSaveRequest;
use App\Http\Requests\SelfDisclosure\Wizard\UserGardenSaveRequest;
use App\Http\Requests\SelfDisclosure\Wizard\UserHomeSaveRequest;
use App\Models\Address;
use App\Models\Country;
use App\Models\SelfDisclosure\UserExperience;
use App\Models\SelfDisclosure\UserFamilyAnimal;
use App\Models\SelfDisclosure\UserFamilyHuman;
use App\Models\SelfDisclosure\UserFamilyMember;
use App\Models\SelfDisclosure\UserHome;
use App\Models\SelfDisclosure\UserSelfDisclosure;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Inertia\Inertia;

class SelfDisclosureWizardController extends Controller
{
    public static array $steps = [
        'personal',
        'family',
        'address',
        'home',
        'garden',
        'experiences',
        'eligibility',
        'specific',
        'complete',
    ];
    protected string $baseViewPath = 'SelfDisclosure/Wizard';
    protected string $baseRouteName = 'self-disclosure';

    public function currentStep(): RedirectResponse
    {
        // TODO: Implement step finished logic
        return redirect()->route($this->baseRouteName . '.personal.show');
    }

    /**
     * @throws AuthorizationException
     */
    public function showPersonalStep()
    {
        $disclosure = $this->getDisclosure();

        $member = UserFamilyMember::where([
            'is_primary' => true,
            'self_disclosure_id' => $disclosure->id,
        ])
            ->with('familyable')
            ->first();

        return $this->renderStep(['member' => $member]);
    }

    private function getDisclosure(): UserSelfDisclosure
    {
        $this->authorize('useWizard', UserSelfDisclosure::class);

        return UserSelfDisclosure::whereGlobalUserId(
            auth()->user()->global_id,
        )->first();
    }

    private function renderStep($data, $active = 'personal')
    {
        $this->generateSteps($active);

        return AppInertia::render($this->baseViewPath . '/Show', [
            'step' => $active,
            'data' => $data,
        ]);
    }

    private function generateSteps($active = 'personal'): void
    {
        $active_index = array_search($active, self::$steps);
        Inertia::share(
            'steps',
            array_map(
                function ($step, $index) use ($active_index, $active) {
                    return [
                        'id' => $step,
                        'name' => __('self_disclosure.wizard.steps.' . $step),
                        'href' => route(
                            $this->baseRouteName . '.' . $step . '.show',
                        ),
                        'upcoming' =>
                            $index === $active_index
                                ? null
                                : $index > $active_index,
                    ];
                },
                self::$steps,
                array_keys(self::$steps),
            ),
        );
    }

    public function updatePersonal(PersonalUpdateRequest $request)
    {
        $validated = $request->validated();
        $disclosure = $this->getDisclosure();

        $member = UserFamilyMember::where([
            'is_primary' => true,
            'self_disclosure_id' => $disclosure->id,
        ])
            ->with('familyable')
            ->first();

        $member->update([
            'name' => $validated['name'],
            'year' => $validated['year'],
        ]);

        $member->familyable->update([
            'profession' => $validated['profession'],
            'knows_animals' => $validated['knows_animals'],
        ]);

        return $this->redirect($request, 'self-disclosure.family.show');
    }

    public function showFamilyStep()
    {
        $disclosure = $this->getDisclosure();

        $members = UserFamilyMember::where([
            'self_disclosure_id' => $disclosure->id,
        ])->get();

        return $this->renderStep(
            [
                'members' => $members,
            ],
            'family',
        );
    }

    public function updateFamily()
    {
        return redirect()->route('self-disclosure.family.show');
    }

    public function showExperiencesStep()
    {
        $disclosure = $this->getDisclosure();

        $has_animals = $disclosure
            ->whereHas('userFamilyMembers', function (Builder $query) {
                $query->where('familyable_type', UserFamilyAnimal::class);
            })
            ->exists();

        $experiences = UserExperience::all();

        return $this->renderStep(
            [
                'has_animals' => $has_animals,
                'experiences' => $experiences,
            ],
            'experiences',
        );
    }

    public function updateExperiences()
    {
        return redirect()->route('self-disclosure.experiences.show');
    }

    public function showAddressStep()
    {
        $this->authorize('useWizard', UserSelfDisclosure::class);

        $address = Address::where([
            'addressable_id' => \Auth::user()->id,
            'addressable_type' => User::class,
        ])->first();

        if (!$address) {
            $this->authorize('create', Address::class);
        } else {
            $this->authorize('update', $address);
        }

        $countries = Country::all(['alpha', 'code'])->map(
            fn(Country $country) => [
                'id' => $country->alpha,
                'name' => __('countries.' . Str::lower($country->alpha)),
            ],
        );

        return $this->renderStep(
            ['countries' => $countries, 'address' => $address],
            'address',
        );
    }

    public function updateAddress(AddressRequest $request)
    {
        $this->authorize('useWizard', UserSelfDisclosure::class);

        $validated = $request->validated();

        $address = Address::where([
            'addressable_id' => \Auth::user()->id,
            'addressable_type' => User::class,
        ])->first();

        if (!$address) {
            $address = new Address();
            $address->addressable()->associate(\Auth::user());
        } else {
            $this->authorize('update', $address);
        }

        $country = Country::where('alpha', $validated['country'])->first();

        $address->street_address = $validated['street_address'];
        $address->locality = $validated['locality'];
        $address->region = $validated['region'];
        $address->postal_code = $validated['postal_code'];
        $address->country_id = $country->code;

        $address->save();

        return $this->redirect($request, 'self-disclosure.home.show');
    }

    public function showHomeStep()
    {
        $this->authorize('useWizard', UserSelfDisclosure::class);

        $home = UserHome::home()->first();

        return $this->renderStep(
            [
                'home' => $home,
            ],
            'home',
        );
    }

    public function updateHome(UserHomeSaveRequest $request)
    {
        $disclosure = $this->getDisclosure();

        $home = UserHome::first();

        $validated = $request->validated();

        if (!$home) {
            $disclosure
                ->userHome()
                ->create(array_merge(['garden' => false], $validated));
        } else {
            $home->update($validated);
        }

        return $this->redirect($request, 'self-disclosure.garden.show');
    }

    public function showGardenStep()
    {
        $this->authorize('useWizard', UserSelfDisclosure::class);

        $garden = UserHome::garden()->first();

        if (!$garden) {
            return redirect()->route('self-disclosure.home.show');
        }

        return $this->renderStep(
            [
                'garden' => $garden,
            ],
            'garden',
        );
    }

    public function updateGarden(UserGardenSaveRequest $request)
    {
        $this->authorize('useWizard', UserSelfDisclosure::class);

        $validated = $request->validated();

        $garden = UserHome::first();

        if (!$garden) {
            return redirect()->route('self-disclosure.home.show');
        } else {
            $garden->update([
                'garden' => $validated['garden'],
                'garden_size' => $validated['garden']
                    ? $validated['garden_size']
                    : null,
                'garden_secure' => $validated['garden']
                    ? $validated['garden_secure']
                    : null,
                'garden_connected' => $validated['garden']
                    ? $validated['garden_connected']
                    : null,
            ]);
        }

        return $this->redirect($request, 'self-disclosure.experiences.show');
    }

    public function showEligibilityStep()
    {
        $disclosure = $this->getDisclosure();

        $eligibility = $disclosure->userCareEligibility()->first();

        return $this->renderStep(
            [
                'eligibility' => $eligibility,
            ],
            'eligibility',
        );
    }

    public function updateEligibility(UserEligibilitySaveRequest $request)
    {
        $disclosure = $this->getDisclosure();

        $eligibility = $disclosure->userCareEligibility()->first();

        if (!$eligibility) {
            $disclosure->userCareEligibility()->create($request->validated());
        } else {
            $eligibility->update($request->validated());
        }

        return $this->redirect($request, 'self-disclosure.specific.show');
    }

    public function showSpecificStep()
    {
        $disclosure = $this->getDisclosure();
        return $this->renderStep([], 'specific');
    }

    public function updateSpecific()
    {
        $disclosure = $this->getDisclosure();
    }

    public function showCompleteStep()
    {
        $disclosure = $this->getDisclosure();
        return $this->renderStep([], 'complete');
    }

    public function acceptComplete()
    {
        $disclosure = $this->getDisclosure();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createFamilyMember()
    {
        $this->authorize('useWizard', UserSelfDisclosure::class);
        $this->authorize('create', UserFamilyMember::class);

        $this->generateSteps('family');

        return AppInertia::render($this->baseViewPath . '/FamilyMembers/Edit');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeFamilyMember(FamilyMemberSaveRequest $request)
    {
        $this->authorize('create', UserFamilyMember::class);

        $disclosure = $this->getDisclosure();

        $validated = $request->validated();

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

        return redirect()->route($this->baseRouteName . '.family.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editFamilyMember(UserFamilyMember $userFamilyMember)
    {
        $this->authorize('update', $userFamilyMember);
        $this->authorize('useWizard', UserSelfDisclosure::class);

        $this->generateSteps('family');

        $userFamilyMember->load('selfDisclosure');

        if (
            $userFamilyMember->is_primary ||
            $userFamilyMember->selfDisclosure->global_user_id !==
                auth()->user()->global_id
        ) {
            return redirect()->route($this->baseRouteName . '.family.show');
        }

        return AppInertia::render($this->baseViewPath . '/FamilyMembers/Edit', [
            'member' => $userFamilyMember,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateFamilyMember(
        FamilyMemberSaveRequest $request,
        UserFamilyMember $userFamilyMember,
    ) {
        $this->authorize('update', $userFamilyMember);
        $this->authorize('useWizard', UserSelfDisclosure::class);

        $validated = $request->validated();

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

        return redirect()->route($this->baseRouteName . '.family.show');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyFamilyMember(UserFamilyMember $userFamilyMember)
    {
        $this->authorize('delete', $userFamilyMember);
        $this->authorize('useWizard', UserSelfDisclosure::class);

        $userFamilyMember->familyable()->delete();
        $userFamilyMember->delete();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createExperience()
    {
        $this->authorize('useWizard', UserSelfDisclosure::class);
        $this->authorize('create', UserExperience::class);

        $this->generateSteps('experiences');

        return AppInertia::render($this->baseViewPath . '/Experiences/Edit', [
            'today' => date('Y-m-d'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeExperience(UserExperienceSaveRequest $request)
    {
        $this->authorize('create', UserExperience::class);

        $disclosure = $this->getDisclosure();

        $validated = $request->validated();

        $disclosure->userExperiences()->create($validated);

        return redirect()->route($this->baseRouteName . '.experiences.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editExperience(UserExperience $userExperience)
    {
        $this->authorize('update', $userExperience);
        $this->authorize('useWizard', UserSelfDisclosure::class);

        $this->generateSteps('experiences');

        return AppInertia::render($this->baseViewPath . '/Experiences/Edit', [
            'experience' => $userExperience,
            'today' => date('Y-m-d'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateExperience(
        UserExperienceSaveRequest $request,
        UserExperience $userExperience,
    ) {
        $this->authorize('update', $userExperience);
        $this->authorize('useWizard', UserSelfDisclosure::class);

        $validated = $request->validated();

        $userExperience->update([
            'type' => $validated['type'],
            'animal_type' => $validated['animal_type'],
            'years' => $validated['years'] ?? null,
            'since' => $validated['since'] ?? null,
        ]);

        return redirect()->route($this->baseRouteName . '.experiences.show');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyExperience(UserExperience $userExperience)
    {
        $this->authorize('delete', $userExperience);
        $this->authorize('useWizard', UserSelfDisclosure::class);

        $userExperience->delete();
    }
}
