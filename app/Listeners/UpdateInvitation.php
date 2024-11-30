<?php

namespace App\Listeners;

use App\Events\InvitationCreated;
use App\Mail\OrganisationInvitationMail;
use App\Models\Tenant\OrganisationInvitation;
use App\Models\User;
use Illuminate\Mail\Events\MessageSent;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class UpdateInvitation
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
    public function handle(MessageSent $event): void
    {
        if ($event->message->mailable == 'App\\Mail\\OrganisationInvitationMail') {
            OrganisationInvitation::find($event->data["invitation"]->id)?->update(["sent_at" => now(), "status" => 'sent']);
        }
    }
}
