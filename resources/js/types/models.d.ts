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

    export interface Media {
        id: number
        file_url: string
    }

    export interface Animal {
        id: string
        name: string
        date_of_birth: string
        sex: 'male' | 'female'

        animalable: any

        bio?: string
        abstract?: string

        organisation?: Organisation

        thumbnail?: string
        gallery?: string[]
        images?: string[]

        medially: Media[]

        animal_family_id?: string
        father?: string
        mother?: string

        paternal_families?: Family[]
        maternal_families?: Family[]

        handler?: {
            id: string
            name: string
        }

        fosterHome?: {
            id: string
            name: string
        }

        location?: {
            id: string
            name: string
        }

        published_at?: string
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

    export interface History {
        text: string
        type: string
        fields?: {
            field: string
            value: string
        }[]
    }

    export interface Family {
        id: string
        name: string
        father?: { id: string; name: string }
        mother?: { id: string; name: string }
        children_count: number
        created_at: string
        updated_at: string
    }

    export interface Country {
        id: string
        name: string
    }

    export interface Address {
        street_address: string
        locality: string
        region: string
        postal_code: string
        country: Country
    }

    export interface Location {
        id: string
        name: string
        public: boolean
        address: Address
        created_at: string
        updated_at: string
        deleted_at: string
    }
}
