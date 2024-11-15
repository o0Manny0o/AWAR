import { PageProps as InertiaPageProps } from '@inertiajs/core'
import { AxiosInstance } from 'axios'
import { route as ziggyRoute } from 'ziggy-js'

declare global {
    interface Window {
        axios: AxiosInstance
    }

    /* eslint-disable no-var */
    var route: typeof ziggyRoute
}

type AppPageProps<T extends Record<string, unknown> = Record<string, unknown>> =
    T & {
        auth: {
            user: User
        }
        ziggy: ZiggyConfig
        locale: LanguageKey
        locales: Locale[]
        translations: Partial<Translations>
    }

declare module '@inertiajs/core' {
    interface PageProps extends InertiaPageProps, AppPageProps {}
}
