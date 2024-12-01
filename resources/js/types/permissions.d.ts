interface Resources {
    // general
    create: string
    view: string
    update: string
    delete: string
    restore: string
    submit: string

    organisations: {
        applications: {
            create: string
            view: string
            update: string
            delete: string
            restore: string
            submit: string
        }
        invitations: {
            view: string
            create: string
            update: string
            delete: string
        }
    }
}

type ResourcePermissions = Paths<Resources, 10>
