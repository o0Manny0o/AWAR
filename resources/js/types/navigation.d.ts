import { RouteName } from 'ziggy-js'
import { ComponentType } from 'react'

type NavigationItem = {
    icon?: ComponentType<{ className?: string }>
    name: RouteName
    label: TranslationKey
}
