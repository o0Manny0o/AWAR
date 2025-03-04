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
use App\Models\SelfDisclosure\UserCareEligibility;
use App\Models\SelfDisclosure\UserExperience;
use App\Models\SelfDisclosure\UserFamilyMember;
use App\Models\SelfDisclosure\UserHome;
use App\Models\User;
use App\Services\SelfDisclosureService;
use App\Services\SelfDisclosureWizardService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class SelfDisclosureWizardController extends Controller
{
    protected static string $baseViewPath = 'SelfDisclosure/Wizard';
    protected static string $baseRouteName = 'self-disclosure';

    public function __construct(
        private readonly SelfDisclosureWizardService $service,
        private readonly SelfDisclosureService $disclosureService,
    ) {
    }

    /**
     * Redirect to the current step of the self disclosure
     */
    public function redirectToCurrentStep(): RedirectResponse
    {
        $current = $this->service->getCurrentStep();
        return redirect()->route($current->route());
    }

    /**
     * Show the personal form step of the self disclosure
     */
    public function showPersonalStep(): Response
    {
        $member = $this->service->getPrimaryFamilyMember();

        return $this->renderStep(['member' => $member]);
    }

    /** Render the self disclosure wizard step */
    private function renderStep(
        $data,
        SelfDisclosureStep $active = SelfDisclosureStep::PERSONAL,
    ): Response {
        $this->generateStepNavigation($active);

        return AppInertia::render($this->getShowView(), [
            'step' => $active->value,
            'data' => $data,
            'previousStep' => $active->previous()?->route(),
        ]);
    }

    /** Generate the step navigation for the self disclosure wizard */
    private function generateStepNavigation(
        SelfDisclosureStep $activeStep = SelfDisclosureStep::PERSONAL,
    ): void {
        $disclosure = $this->disclosureService->getDisclosure();
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
        $this->service->updatePrimaryFamilyMember($request->validated());
        $this->service->updateFurthestStep(SelfDisclosureStep::FAMILY);
        return $this->redirect($request, SelfDisclosureStep::FAMILY->route());
    }

    /** Show the family form
     */
    public function showFamilyStep(): Response
    {
        return $this->renderStep(
            [
                'members' => UserFamilyMember::all(),
            ],
            SelfDisclosureStep::FAMILY,
        );
    }

    /** Redirects to the family form step */
    public function updateFamily(): RedirectResponse
    {
        $this->service->updateFurthestStep(SelfDisclosureStep::ADDRESS);
        return redirect()->route(SelfDisclosureStep::ADDRESS->route());
    }

    /**
     * Show the experience form step
     */
    public function showExperiencesStep(): Response
    {
        return $this->renderStep(
            [
                'has_animals' => $this->service->hasAnimalFamilyMember(),
                'experiences' => UserExperience::all(),
            ],
            SelfDisclosureStep::EXPERIENCES,
        );
    }

    /** Redirects to the eligibility form step  */
    public function updateExperiences(): RedirectResponse
    {
        $this->service->updateFurthestStep(SelfDisclosureStep::ELIGIBILITY);
        return redirect()->route(SelfDisclosureStep::ELIGIBILITY->route());
    }

    /**
     * Show the address form step
     * @throws AuthorizationException
     */
    public function showAddressStep(): Response
    {
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

        $this->service->updateFurthestStep(SelfDisclosureStep::HOME);

        return $this->redirect($request, SelfDisclosureStep::HOME->route());
    }

    /**
     * Show the home form step
     */
    public function showHomeStep(): Response
    {
        return $this->renderStep(
            [
                'home' => UserHome::home()->first(),
            ],
            SelfDisclosureStep::HOME,
        );
    }

    /**
     * Update the home of the user in the self disclosure
     */
    public function updateHome(UserHomeSaveRequest $request): RedirectResponse
    {
        $this->service->updateUserHome($request->validated());

        $this->service->updateFurthestStep(SelfDisclosureStep::GARDEN);

        return $this->redirect($request, SelfDisclosureStep::GARDEN->route());
    }

    /**
     * Show the garden form step
     */
    public function showGardenStep(): Response|RedirectResponse
    {
        $garden = UserHome::garden()->first();

        if (!$garden) {
            return redirect()->route(SelfDisclosureStep::HOME->route());
        }

        return $this->renderStep(
            [
                'garden' => $garden,
            ],
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

        $this->service->updateFurthestStep(SelfDisclosureStep::EXPERIENCES);

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
        return $this->renderStep(
            [
                'eligibility' => UserCareEligibility::first(),
            ],
            SelfDisclosureStep::ELIGIBILITY,
        );
    }

    /**
     * Update the eligibility of the user in the self disclosure
     */
    public function updateEligibility(
        UserEligibilitySaveRequest $request,
    ): RedirectResponse {
        $this->service->updateUserEligibility($request->validated());
        $this->service->updateFurthestStep(SelfDisclosureStep::SPECIFIC);
        return $this->redirect($request, SelfDisclosureStep::SPECIFIC->route());
    }

    /**
     * Show the animal specific form step
     */
    public function showSpecificStep(): Response
    {
        return $this->renderStep(
            [
                'dogSpecific' => UserAnimalSpecificDisclosure::dog()->first()
                    ?->specifiable,
                'catSpecific' => UserAnimalSpecificDisclosure::cat()->first()
                    ?->specifiable,
            ],
            SelfDisclosureStep::SPECIFIC,
        );
    }

    /**
     * Update the animal specific disclosures of the user in the self disclosure
     */
    public function updateSpecific(
        AnimalSpecificSaveRequest $request,
    ): RedirectResponse {
        $this->service->updateAnimalSpecificDisclosure($request->validated());
        $this->service->updateFurthestStep(SelfDisclosureStep::CONFIRMATION);

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
        return $this->renderStep(
            ['disclosure' => $this->disclosureService->getDisclosure()],
            SelfDisclosureStep::CONFIRMATION,
        );
    }

    /**
     * Update the confirmations of the user in the self disclosure
     */
    public function updateConfirmation(
        ConfirmationSaveRequest $request,
    ): RedirectResponse {
        $this->service->updateConfirmations($request->validated());
        $this->service->updateFurthestStep(SelfDisclosureStep::COMPLETE);
        return $this->redirect($request, 'self-disclosure.complete');
    }

    /**
     * Show the form for creating a new family member.
     */
    public function createFamilyMember(): Response
    {
        $this->generateStepNavigation(SelfDisclosureStep::FAMILY);

        return AppInertia::render(
            static::$baseViewPath . '/FamilyMembers/Edit',
        );
    }

    /**
     * Store a newly created family member in storage.
     */
    public function storeFamilyMember(
        FamilyMemberSaveRequest $request,
    ): RedirectResponse {
        $this->service->storeFamilyMember($request->validated());
        $this->service->updateFurthestStep(SelfDisclosureStep::ADDRESS);

        return redirect()->route(SelfDisclosureStep::FAMILY->route());
    }

    /**
     * Show the form for editing the family member resource.
     */
    public function editFamilyMember(
        UserFamilyMember $userFamilyMember,
    ): Response|RedirectResponse {
        $this->generateStepNavigation(SelfDisclosureStep::FAMILY);

        $userFamilyMember->load('selfDisclosure');

        if ($userFamilyMember->is_primary) {
            return redirect()->route(SelfDisclosureStep::FAMILY->route());
        }

        return AppInertia::render(
            static::$baseViewPath . '/FamilyMembers/Edit',
            [
                'member' => $userFamilyMember,
            ],
        );
    }

    /**
     * Update the specified family member in storage.
     */
    public function updateFamilyMember(
        FamilyMemberSaveRequest $request,
        UserFamilyMember $userFamilyMember,
    ): RedirectResponse {
        $this->service->updateFamilyMember(
            $userFamilyMember,
            $request->validated(),
        );
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
        $this->generateStepNavigation(SelfDisclosureStep::EXPERIENCES);

        return AppInertia::render(static::$baseViewPath . '/Experiences/Edit', [
            'today' => date('Y-m-d'),
        ]);
    }

    /**
     * Store a newly created experience in storage.
     */
    public function storeExperience(
        UserExperienceSaveRequest $request,
    ): RedirectResponse {
        $this->service->storeExperience($request->validated());
        return redirect()->route(SelfDisclosureStep::EXPERIENCES->route());
    }

    /**
     * Show the form for editing the specified experience.
     */
    public function editExperience(UserExperience $userExperience): Response
    {
        $this->generateStepNavigation(SelfDisclosureStep::EXPERIENCES);

        return AppInertia::render(static::$baseViewPath . '/Experiences/Edit', [
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
        $this->service->updateExperience(
            $userExperience,
            $request->validated(),
        );

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
        return AppInertia::render(static::$baseViewPath . '/Complete');
    }
}
