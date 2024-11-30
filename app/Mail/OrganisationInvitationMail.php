<?php

namespace App\Mail;

use App\Models\Organisation;
use App\Models\Tenant\Member;
use App\Models\Tenant\OrganisationInvitation;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class OrganisationInvitationMail extends BaseMail
{

    /**
     * Create a new message instance.
     */
    public function __construct(
        public OrganisationInvitation $invitation,
        public string $invitee,
        public Member $inviter,
        public Organisation $organisation,
        public string $url)
    {
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->inviter->name . ' invited you to join ' . $this->organisation->name,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return $this->localizedContent(
            view: 'mail.organisation_invite',
            title: $this->inviter->name . ' invited you to join ' . $this->organisation->name
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
