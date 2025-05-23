type User = {
    id: number
    name: string
    email: string
    email_verified_at?: string
    tenants?: Organisation[]
}

type Organisation = {
    name: string
    domains?: { domain: string }[]
    dashboard_url: string
    public_settings?: {
        name: string
        favicon: string
        logo: string
    }
}

type ZiggyConfig = {
    url: string
    port: number | null
    defaults: Record<string, number | string>
    routes: Record<string, ZiggyRoute>
    location: string
}

type ZiggyRoute = {
    uri: string
    methods: (
        | 'GET'
        | 'HEAD'
        | 'POST'
        | 'PATCH'
        | 'PUT'
        | 'OPTIONS'
        | 'DELETE'
    )[]
    domain?: string
    parameters?: string[]
    bindings?: Record<string, string>
    wheres?: Record<string, unknown>
    middleware?: string[]
}

type LanguageKey = 'en' | 'de'

type Locale = {
    id: LanguageKey
    name: string
}

type AppMessage = {
    message: string
    type?: 'success' | 'error' | 'warning' | 'info'
    config?: Record<string, unknown>
}

type NestedRecord<K, T> = Record<K, T | NestedRecord<K, T>>

type AppPageProps<T extends Record<string, unknown> = Record<string, unknown>> =
    T & {
        auth: {
            user?: User
            isMember?: boolean
        }
        ziggy: ZiggyConfig
        locale: LanguageKey
        locales: Locale[]
        centralDomain: string
        previousUrl?: string
        tenant?: Organisation
        tenants?: Organisation[]
        messages?: AppMessage[]
        nextSteps?: string[]
        canCreate?: boolean
    }

type TranslationKey = Paths<Translations, 10>
type TranslationReplace = Record<string, string | TranslationKey>
type Errors<T> = { [P in keyof T]?: string }
