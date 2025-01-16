<?php

namespace App\Listeners;

use App\Events\UserCreated;
use App\Models\SelfDisclosure\UserFamilyHuman;
use App\Models\SelfDisclosure\UserFamilyMember;
use App\Models\SelfDisclosure\UserSelfDisclosure;

class CreateSelfDisclosure
{
    /**
     * Create a self disclosure form and family member for the user.
     */
    public function handle(UserCreated $event): void
    {
        $user = $event->user;
        /** @var UserSelfDisclosure $disclosure */
        $disclosure = $user->selfDisclosure()->create();
        /** @var UserFamilyHuman $humanMember */
        $humanMember = UserFamilyHuman::create();

        /** @var UserFamilyMember $familyMember */
        $familyMember = new UserFamilyMember([
            'name' => $user->name,
        ]);

        $familyMember->familyable()->associate($humanMember);

        $familyMember->is_primary = true;

        $disclosure->userFamilyMembers()->save($familyMember);
    }
}
