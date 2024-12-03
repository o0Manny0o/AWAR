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
            user: User
            member?: any
        }
        permissions?: NestedRecord<string, boolean>
        ziggy: ZiggyConfig
        locale: LanguageKey
        locales: Locale[]
        translations: Partial<Translations>
        fallback?: Translations
        centralDomain: string
        previousUrl?: string
        tenant?: Organisation
        messages?: AppMessage[]
    }

type TranslationKey = Paths<Translations, 10>
type TranslationReplace = Record<string, string | TranslationKey>
