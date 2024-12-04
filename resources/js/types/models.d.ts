declare namespace App.Models {
    export interface Role {
        id: string
        name: string
        created_at: string
        updated_at: string
    }

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

        can_be_deleted: boolean
        can_be_restored: boolean
        can_be_viewed: boolean
        can_be_updated: boolean
        can_be_submitted: boolean
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
        role: Role
        sent_at: string
        accepted_at: string
        created_at: string
        updated_at: string

        can_be_deleted: boolean
        can_be_viewed: boolean
        can_be_updated: boolean
    }

    export enum InvitationStatus {
        PENDING = 'pending',
        SENT = 'sent',
        ACCEPTED = 'accepted',
    }

    export interface Member {
        id: string
        name: string
        email: string
        roles: Role[]
        created_at: string
        updated_at: string
    }

    export interface Animal {
        id: string
        name: string
        date_of_birth: string
        deleted_at?: string
        created_at: string
        updated_at: string
    }

    export interface Dog extends Animal {
        animalable: {
            breed: string
        }
    }

    export interface Cat extends Animal {
        animalable: {
            breed: string
        }
    }
}
