<?php

namespace App\Listeners;

use App\Events\InvitationSaved;
use App\Mail\OrganisationInvitationMail;
use App\Messages\ToastMessage;
use App\Models\Tenant\Member;
use Illuminate\Support\Facades\Mail;

class SendInvitationEmail
{
    /**
     * Handle the event.
     */
    public function handle(InvitationSaved $event): void
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
        ToastMessage::success(
            __('organisations.invitations.messages.sent', [
                'email' => $event->invitation->email,
            ]),
        );
    }
}
