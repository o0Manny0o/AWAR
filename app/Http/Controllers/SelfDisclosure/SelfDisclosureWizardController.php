<?php

namespace App\Http\Controllers\SelfDisclosure;

use App\Enum\SelfDisclosure\SelfDisclosureStep;
use App\Http\AppInertia;
use App\Http\Controllers\Controller;
use App\Http\Requests\Address\AddressRequest;
use App\Http\Requests\SelfDisclosure\Wizard\AnimalSpecificSaveRequest;
use App\Http\Requests\SelfDisclosure\Wizard\ConfirmationSaveRequest;
use App\Http\Requests\SelfDisclosure\Wizard\FamilyMemberSaveRequest;
use App\Http\Requests\SelfDisclosure\Wizard\PersonalUpdateRequest;
use App\Http\Requests\SelfDisclosure\Wizard\UserEligibilitySaveRequest;
use App\Http\Requests\SelfDisclosure\Wizard\UserExperienceSaveRequest;
use App\Http\Requests\SelfDisclosure\Wizard\UserGardenSaveRequest;
use App\Http\Requests\SelfDisclosure\Wizard\UserHomeSaveRequest;
use App\Models\Address;
use App\Models\Country;
use App\Models\SelfDisclosure\UserAnimalSpecificDisclosure;
use App\Models\SelfDisclosure\UserCatSpecificDisclosure;
use App\Models\SelfDisclosure\UserDogSpecificDisclosure;
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
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class SelfDisclosureWizardController extends Controller
{
    protected string $baseViewPath = 'SelfDisclosure/Wizard';
    protected string $baseRouteName = 'self-disclosure';

    /**
     * Show the current step of the self disclosure
     */
    public function showCurrentStep(): RedirectResponse
    {
        $current = SelfDisclosureStep::from(
            $this->getDisclosure()->furthest_step ??
                SelfDisclosureStep::PERSONAL->value,
        );
        return redirect()->route($current->route());
    }

    /** Authorize and get the user's self disclosure
     */
    private function getDisclosure(): UserSelfDisclosure
    {
        return UserSelfDisclosure::whereGlobalUserId(
            Auth::user()->global_id,
        )->first();
    }

    /**
     * Show the personal form step of the self disclosure
     */
    public function showPersonalStep(): Response
    {
        $disclosure = $this->getDisclosure();

        $member = UserFamilyMember::primary()->first();

        return $this->renderStep(['member' => $member], $disclosure);
    }

    /** Render the self disclosure wizard step */
    private function renderStep(
        $data,
        UserSelfDisclosure $disclosure,
        SelfDisclosureStep $active = SelfDisclosureStep::PERSONAL,
    ): Response {
        $this->generateStepNavigation($disclosure, $active);

        return AppInertia::render($this->baseViewPath . '/Show', [
            'step' => $active->value,
            'data' => $data,
            'previousStep' => $active->previous()?->route(),
        ]);
    }

    /** Generate the step navigation for the self disclosure wizard */
    private function generateStepNavigation(
        UserSelfDisclosure $disclosure,
        SelfDisclosureStep $activeStep = SelfDisclosureStep::PERSONAL,
    ): void {
        $steps = SelfDisclosureStep::formSteps();
        $furthestStep = SelfDisclosureStep::from(
            $disclosure->furthest_step ?? SelfDisclosureStep::PERSONAL->value,
        );
        $active_index = array_search($activeStep, $steps);
        $furthest_index = array_search($furthestStep, $steps);
        Inertia::share(
            'steps',
            array_map(
                function ($step, $index) use ($furthest_index, $active_index) {
                    return [
                        'id' => $step->value,
                        'name' => __(
                            'self_disclosure.wizard.steps.' . $step->value,
                        ),
                        'href' => route($step->route()),
                        'completed' => $index < $furthest_index,
                        'active' => $index === $active_index,
                        'next' => $index === $furthest_index,
                    ];
                },
                $steps,
                array_keys($steps),
            ),
        );
    }

    /** Update the personal information of the user in the self disclosure
     */
    public function updatePersonal(
        PersonalUpdateRequest $request,
    ): RedirectResponse {
        $validated = $request->validated();

        $member = UserFamilyMember::primary()->first();

        $member->update([
            'name' => $validated['name'],
            'year' => $validated['year'],
        ]);

        $member->familyable->update([
            'profession' => $validated['profession'],
            'knows_animals' => $validated['knows_animals'],
        ]);

        return $this->redirect($request, SelfDisclosureStep::FAMILY->route());
    }

    /** Show the family form
     */
    public function showFamilyStep(): Response
    {
        $disclosure = $this->getDisclosure();

        $members = UserFamilyMember::all();

        return $this->renderStep(
            [
                'members' => $members,
            ],
            $disclosure,
            SelfDisclosureStep::FAMILY,
        );
    }

    /** Redirects to the family form step */
    public function updateFamily(): RedirectResponse
    {
        return redirect()->route(SelfDisclosureStep::FAMILY->route());
    }

    /**
     * Show the experience form step
     */
    public function showExperiencesStep(): Response
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
            $disclosure,
            SelfDisclosureStep::EXPERIENCES,
        );
    }

    /** Redirects to the eligibility form step  */
    public function updateExperiences(): RedirectResponse
    {
        return redirect()->route(SelfDisclosureStep::ELIGIBILITY->route());
    }

    /**
     * Show the address form step
     * @throws AuthorizationException
     */
    public function showAddressStep(): Response
    {
        $disclosure = $this->getDisclosure();

        $address = Address::where([
            'addressable_id' => \Auth::user()->id,
            'addressable_type' => User::class,
        ])->first();

        if (!$address) {
            $this->authorize('create', Address::class);
        } else {
            $this->authorize('update', $address);
        }

        return $this->renderStep(
            ['countries' => Country::asOptions(), 'address' => $address],
            $disclosure,
            SelfDisclosureStep::ADDRESS,
        );
    }

    /**
     * Update the address of the user in the self disclosure
     * @throws AuthorizationException
     */
    public function updateAddress(AddressRequest $request): RedirectResponse
    {
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

        return $this->redirect($request, SelfDisclosureStep::HOME->route());
    }

    /**
     * Show the home form step
     */
    public function showHomeStep(): Response
    {
        $disclosure = $this->getDisclosure();

        $home = UserHome::home()->first();

        return $this->renderStep(
            [
                'home' => $home,
            ],
            $disclosure,
            SelfDisclosureStep::HOME,
        );
    }

    /**
     * Update the home of the user in the self disclosure
     */
    public function updateHome(UserHomeSaveRequest $request): RedirectResponse
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

        return $this->redirect($request, SelfDisclosureStep::GARDEN->route());
    }

    /**
     * Show the garden form step
     */
    public function showGardenStep(): Response|RedirectResponse
    {
        $disclosure = $this->getDisclosure();

        $garden = UserHome::garden()->first();

        if (!$garden) {
            return redirect()->route(SelfDisclosureStep::HOME->route());
        }

        return $this->renderStep(
            [
                'garden' => $garden,
            ],
            $disclosure,
            SelfDisclosureStep::GARDEN,
        );
    }

    /**
     * Update the garden of the user in the self disclosure
     */
    public function updateGarden(
        UserGardenSaveRequest $request,
    ): RedirectResponse {
        $garden = UserHome::first();

        if (!$garden) {
            return redirect()->route(SelfDisclosureStep::HOME->route());
        } else {
            $garden->update($request->validated());
        }

        return $this->redirect(
            $request,
            SelfDisclosureStep::EXPERIENCES->route(),
        );
    }

    /**
     * Show the eligibility form step
     */
    public function showEligibilityStep(): Response
    {
        $disclosure = $this->getDisclosure();

        $eligibility = $disclosure->userCareEligibility()->first();

        return $this->renderStep(
            [
                'eligibility' => $eligibility,
            ],
            $disclosure,
            SelfDisclosureStep::ELIGIBILITY,
        );
    }

    /**
     * Update the eligibility of the user in the self disclosure
     */
    public function updateEligibility(
        UserEligibilitySaveRequest $request,
    ): RedirectResponse {
        $disclosure = $this->getDisclosure();

        $eligibility = $disclosure->userCareEligibility()->first();

        if (!$eligibility) {
            $disclosure->userCareEligibility()->create($request->validated());
        } else {
            $eligibility->update($request->validated());
        }

        return $this->redirect($request, SelfDisclosureStep::SPECIFIC->route());
    }

    /**
     * Show the animal specific form step
     */
    public function showSpecificStep(): Response
    {
        $disclosure = $this->getDisclosure();

        $dogSpecific = UserAnimalSpecificDisclosure::dog()->first()
            ?->specifiable;

        $catSpecific = UserAnimalSpecificDisclosure::cat()->first()
            ?->specifiable;

        return $this->renderStep(
            [
                'dogSpecific' => $dogSpecific,
                'catSpecific' => $catSpecific,
            ],
            $disclosure,
            SelfDisclosureStep::SPECIFIC,
        );
    }

    /**
     * Update the animal specific disclosures of the user in the self disclosure
     */
    public function updateSpecific(
        AnimalSpecificSaveRequest $request,
    ): RedirectResponse {
        $disclosure = $this->getDisclosure();

        $dogSpecific = UserAnimalSpecificDisclosure::dog()->first();

        $catSpecific = UserAnimalSpecificDisclosure::cat()->first();

        $validated = $request->validated();

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

        return $this->redirect(
            $request,
            SelfDisclosureStep::CONFIRMATION->route(),
        );
    }

    /**
     * Show the confirmation form step
     */
    public function showConfirmationStep(): Response
    {
        $disclosure = $this->getDisclosure();
        return $this->renderStep(
            ['disclosure' => $disclosure],
            $disclosure,
            SelfDisclosureStep::CONFIRMATION,
        );
    }

    /**
     * Update the confirmations of the user in the self disclosure
     */
    public function updateConfirmation(
        ConfirmationSaveRequest $request,
    ): RedirectResponse {
        $disclosure = $this->getDisclosure();

        $disclosure->update($request->validated());

        return $this->redirect($request, 'self-disclosure.complete');
    }

    /**
     * Show the form for creating a new family member.
     */
    public function createFamilyMember(): Response
    {
        $disclosure = $this->getDisclosure();

        $this->generateStepNavigation($disclosure, SelfDisclosureStep::FAMILY);

        return AppInertia::render($this->baseViewPath . '/FamilyMembers/Edit');
    }

    /**
     * Store a newly created family member in storage.
     */
    public function storeFamilyMember(
        FamilyMemberSaveRequest $request,
    ): RedirectResponse {
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

        return redirect()->route(SelfDisclosureStep::FAMILY->route());
    }

    /**
     * Show the form for editing the family member resource.
     */
    public function editFamilyMember(
        UserFamilyMember $userFamilyMember,
    ): Response|RedirectResponse {
        $disclosure = $this->getDisclosure();

        $this->generateStepNavigation($disclosure, SelfDisclosureStep::FAMILY);

        $userFamilyMember->load('selfDisclosure');

        if (
            $userFamilyMember->is_primary ||
            $userFamilyMember->selfDisclosure->global_user_id !==
                Auth::user()->global_id
        ) {
            return redirect()->route(SelfDisclosureStep::FAMILY->route());
        }

        return AppInertia::render($this->baseViewPath . '/FamilyMembers/Edit', [
            'member' => $userFamilyMember,
        ]);
    }

    /**
     * Update the specified family member in storage.
     */
    public function updateFamilyMember(
        FamilyMemberSaveRequest $request,
        UserFamilyMember $userFamilyMember,
    ): RedirectResponse {
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

        return redirect()->route(SelfDisclosureStep::FAMILY->route());
    }

    /**
     * Remove the specified family member from storage.
     */
    public function destroyFamilyMember(
        UserFamilyMember $userFamilyMember,
    ): void {
        $userFamilyMember->familyable()->delete();
        $userFamilyMember->delete();
    }

    /**
     * Show the form for creating a new experience.
     */
    public function createExperience(): Response
    {
        $disclosure = $this->getDisclosure();

        $this->generateStepNavigation(
            $disclosure,
            SelfDisclosureStep::EXPERIENCES,
        );

        return AppInertia::render($this->baseViewPath . '/Experiences/Edit', [
            'today' => date('Y-m-d'),
        ]);
    }

    /**
     * Store a newly created experience in storage.
     */
    public function storeExperience(
        UserExperienceSaveRequest $request,
    ): RedirectResponse {
        $disclosure = $this->getDisclosure();

        $validated = $request->validated();

        $disclosure->userExperiences()->create($validated);

        return redirect()->route(SelfDisclosureStep::EXPERIENCES->route());
    }

    /**
     * Show the form for editing the specified experience.
     */
    public function editExperience(UserExperience $userExperience): Response
    {
        $disclosure = $this->getDisclosure();

        $this->generateStepNavigation(
            $disclosure,
            SelfDisclosureStep::EXPERIENCES,
        );

        return AppInertia::render($this->baseViewPath . '/Experiences/Edit', [
            'experience' => $userExperience,
            'today' => date('Y-m-d'),
        ]);
    }

    /**
     * Update the specified experience in storage.
     */
    public function updateExperience(
        UserExperienceSaveRequest $request,
        UserExperience $userExperience,
    ): RedirectResponse {
        $validated = $request->validated();

        $userExperience->update([
            'type' => $validated['type'],
            'animal_type' => $validated['animal_type'],
            'years' => $validated['years'] ?? null,
            'since' => $validated['since'] ?? null,
        ]);

        return redirect()->route(SelfDisclosureStep::EXPERIENCES->route());
    }

    /**
     * Remove the specified experience from storage.
     */
    public function destroyExperience(
        UserExperience $userExperience,
    ): RedirectResponse {
        $userExperience->delete();

        return redirect()->route(SelfDisclosureStep::EXPERIENCES->route());
    }

    /**
     * Show the complete page of the wizard.
     */
    public function showComplete(): Response
    {
        return AppInertia::render($this->baseViewPath . '/Complete');
    }
}
