<?php

namespace App\Listeners;

use App\Events\InvitationCreated;
use App\Mail\OrganisationInvitationMail;
use App\Models\Tenant\Member;
use Illuminate\Support\Facades\Mail;

class SendInvitationEmail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(InvitationCreated $event): void
    {
        /** @var Member $inviter */
        $inviter = Member::find($event->invitation->member_id);
        $mail = new OrganisationInvitationMail(
            $event->invitation,
            $event->invitation->email,
            $inviter,
            tenancy()->tenant,
            route('organisation.invitations.accept', $event->invitation->token),
        );
        Mail::to($event->invitation->email)->send($mail);
    }
}
