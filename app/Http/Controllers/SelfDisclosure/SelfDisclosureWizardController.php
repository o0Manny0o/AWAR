<?php

namespace App\Http\Controllers\SelfDisclosure;

use App\Http\AppInertia;
use App\Http\Controllers\Controller;
use App\Models\SelfDisclosure\UserFamilyMember;
use App\Models\SelfDisclosure\UserSelfDisclosure;
use Illuminate\Auth\Access\AuthorizationException;
use Inertia\Inertia;

class SelfDisclosureWizardController extends Controller
{
    public static array $steps = [
        'personal',
        'family',
        'experiences',
        'address',
        'home',
        'garden',
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

    private function renderStep($data, $active = 'personal')
    {
        $active_index = array_search($active, self::$steps);
        Inertia::share(
            'steps',
            array_map(
                function ($step, $index) use ($active_index, $active) {
                    return [
                        'id' => $step,
                        'name' => __('self_disclosure.wizard.steps.' . $step),
                        'href' => route($this->baseRouteName . '.' . $step),
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

        return AppInertia::render($this->baseViewPath . '/Show', [
            'step' => __('self_disclosure.wizard.headers.' . $active),
            'data' => $data,
        ]);
    }

    public function updatePersonal()
    {
        $disclosure = $this->getDisclosure();
    }

    public function showFamilyStep()
    {
        $disclosure = $this->getDisclosure();
        return $this->renderStep([], 'family');
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
}
