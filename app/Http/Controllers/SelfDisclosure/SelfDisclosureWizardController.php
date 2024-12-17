<?php

namespace App\Http\Controllers\SelfDisclosure;

use App\Http\AppInertia;
use App\Http\Controllers\Controller;
use App\Http\Requests\SelfDisclosure\Wizard\FamilyMemberCreateRequest;
use App\Http\Requests\SelfDisclosure\Wizard\PersonalUpdateRequest;
use App\Models\SelfDisclosure\UserFamilyAnimal;
use App\Models\SelfDisclosure\UserFamilyHuman;
use App\Models\SelfDisclosure\UserFamilyMember;
use App\Models\SelfDisclosure\UserSelfDisclosure;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

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

    private function getDisclosure()
    {
        $this->authorize('useWizard', UserSelfDisclosure::class);

        return UserSelfDisclosure::whereGlobalUserId(
            auth()->user()->global_id,
        )->first();
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

    private function renderStep($data, $active = 'personal')
    {
        $this->generateSteps($active);

        return AppInertia::render($this->baseViewPath . '/Show', [
            'step' => $active,
            'data' => $data,
        ]);
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
            'age' => $validated['age'],
        ]);

        $member->familyable->update([
            'profession' => $validated['profession'],
            'knows_animals' => $validated['knows'],
        ]);

        return $this->redirect($request, 'self-disclosure.family.show');
    }

    public function showFamilyStep()
    {
        $disclosure = $this->getDisclosure();

        $members = UserFamilyMember::where([
            'self_disclosure_id' => $disclosure->id,
        ])
            ->with('familyable')
            ->get();

        return $this->renderStep(
            [
                'members' => $members,
            ],
            'family',
        );
    }

    public function updateFamily()
    {
        $disclosure = $this->getDisclosure();
    }

    public function showExperiencesStep()
    {
        $disclosure = $this->getDisclosure();
        return $this->renderStep([], 'experiences');
    }

    public function updateExperiences()
    {
        $disclosure = $this->getDisclosure();
    }

    public function showAddressStep()
    {
        $disclosure = $this->getDisclosure();
        return $this->renderStep([], 'address');
    }

    public function updateAddress()
    {
        $disclosure = $this->getDisclosure();
    }

    public function showHomeStep()
    {
        $disclosure = $this->getDisclosure();
        return $this->renderStep([], 'home');
    }

    public function updateHome()
    {
        $disclosure = $this->getDisclosure();
    }

    public function showGardenStep()
    {
        $disclosure = $this->getDisclosure();
        return $this->renderStep([], 'garden');
    }

    public function updateGarden()
    {
        $disclosure = $this->getDisclosure();
    }

    public function showEligibilityStep()
    {
        $disclosure = $this->getDisclosure();
        return $this->renderStep([], 'eligibility');
    }

    public function updateEligibility()
    {
        $disclosure = $this->getDisclosure();
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

        $this->generateSteps('family');

        return AppInertia::render($this->baseViewPath . '/FamilyMembers/Edit');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeFamilyMember(FamilyMemberCreateRequest $request)
    {
        $this->authorize('useWizard', UserSelfDisclosure::class);

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
            'age' => $validated['age'],
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
    public function update(Request $request, UserFamilyMember $userFamilyMember)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserFamilyMember $userFamilyMember)
    {
        //
    }
}
