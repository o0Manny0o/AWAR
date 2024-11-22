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
        created_at: string
        updated_at: string
        deleted_at?: string
    }

    export enum ApplicationStatus {
        DRAFT = 'draft',
        SUBMITTED = 'submitted',
        PENDING = 'pending',
        APPROVED = 'approved',
        REJECTED = 'rejected',
        CREATED = 'created',
    }
}
