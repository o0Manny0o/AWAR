import { NavigationItem } from '@/types/navigation'

export const CentralPublicNavigation: NavigationItem[] = [
    {
        name: 'about',
        label: 'general.navigation.about',
    },
    {
        name: 'pricing',
        label: 'general.navigation.pricing',
    },
    {
        name: 'animals.browse',
        label: 'general.navigation.browse',
    },
]

/** TODO: Make configurable and generate in backend */
export const TenantPublicNavigation: NavigationItem[] = [
    {
        name: 'about',
        label: 'general.navigation.about',
    },
    {
        name: 'animals.browse',
        label: 'general.navigation.browse',
    },
]
