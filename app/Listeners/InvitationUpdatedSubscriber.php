<?php

namespace App\Listeners;

use App\Events\InvitationAccepted;
use App\Models\Tenant\OrganisationInvitation;
use Illuminate\Events\Dispatcher;
use Illuminate\Mail\Events\MessageSent;
use Illuminate\Support\Facades\Log;

class InvitationUpdatedSubscriber
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the MessageSent event.
     */
    public function handleMessageSent(MessageSent $event): void
    {
        if (isset($event->message->mailable) && $event->message->mailable == 'App\\Mail\\OrganisationInvitationMail') {
            /** @var OrganisationInvitation|null $invitation */
            $invitation = OrganisationInvitation::find($event->data["invitation"]->id);
            if ($invitation && $invitation->status !== 'accepted') {
                $invitation->update(["sent_at" => now(), "status" => 'sent', "valid_until" => now()->addDays(config("tenancy.invitations_validity"))]);
            }
        }
    }


    /**
     * Handle the InvitationAccepted event.
     */
    public function handleInvitationAccepted(InvitationAccepted $event): void
    {
        tenancy()->find($event->organisation)->run(function ($tenant) use ($event) {
            try {
                $invitation = OrganisationInvitation::firstWhere('token', $event->token);

                $invitation?->update([
                    'accepted_at' => now(),
                    'status' => 'accepted'
                ]);
            } catch (\Exception $e) {
                Log::error($e->getMessage());
            }
        });
    }

    /**
     * Register the listeners for the subscriber.
     */
    public function subscribe(Dispatcher $events): void
    {
        $events->listen(
            MessageSent::class,
            [InvitationUpdatedSubscriber::class, 'handleMessageSent']
        );

        $events->listen(
            InvitationAccepted::class,
            [InvitationUpdatedSubscriber::class, 'handleInvitationAccepted']
        );
    }
}
