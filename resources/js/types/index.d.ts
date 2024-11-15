type User = {
    id: number
    name: string
    email: string
    email_verified_at?: string
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

type TranslationKey = Paths<Translations>
