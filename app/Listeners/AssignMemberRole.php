<?php

namespace App\Listeners;

use App\Events\TenantResourceCreated;
use App\Models\Tenant\Member;
use App\Models\Tenant\OrganisationInvitation;
use Illuminate\Support\Facades\Log;

class AssignMemberRole
{
    /**
     * Handle the event.
     */
    public function handle(TenantResourceCreated $event): void
    {
        if (
            $event->model instanceof Member &&
            !$event->model->roles()->exists()
        ) {
            /** @var OrganisationInvitation|null $invitation */
            $invitation = OrganisationInvitation::firstWhere(
                'email',
                $event->model->email,
            );

            if ($invitation) {
                $event->model->assignRole($invitation->role);
            }
        }
    }
}
