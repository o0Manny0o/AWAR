declare namespace App.Models {
    export interface OrganisationApplication {
        id: string
        name: string
        type: string
        user_role: string
        registered: boolean
        street: string
        post_code: string
        city: string
        country: string
        subdomain: string
        user_id: string
        status: ApplicationStatus
        is_complete: boolean
        is_locked: boolean
        created_at: string
        updated_at: string
        deleted_at?: string
    }

    export type OrganisationApplicationDraft = Pick<
        OrganisationApplication,
        | 'id'
        | 'name'
        | 'type'
        | 'user_role'
        | 'created_at'
        | 'deleted_at'
        | 'status'
    > &
        Partial<OrganisationApplication>

    export enum ApplicationStatus {
        DRAFT = 'draft',
        SUBMITTED = 'submitted',
        PENDING = 'pending',
        APPROVED = 'approved',
        REJECTED = 'rejected',
        CREATED = 'created',
    }

    export interface OrganisationInvitation {
        id: string
        name: string
        email: string
        status: InvitationStatus
        token: string
        role?: string
        sent_at: string
        accepted_at: string
        created_at: string
        updated_at: string
    }

    export enum InvitationStatus {
        PENDING = 'pending',
        SENT = 'sent',
        ACCEPTED = 'accepted',
    }
}
