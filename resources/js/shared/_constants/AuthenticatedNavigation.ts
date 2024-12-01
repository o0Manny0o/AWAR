import { NavigationItem } from '@/types/navigation'

export const CentralNavigation: NavigationItem[] = [
    {
        name: 'dashboard',
        routeName: 'dashboard',
        label: 'general.navigation.dashboard',
    },
    {
        name: 'organisations.applications.index',
        routeName: 'organisations.applications.index',
        label: 'general.navigation.organisations.applications',
    },
]

export const TenantNavigation: NavigationItem[] = [
    {
        name: 'tenant.dashboard',
        routeName: 'tenant.dashboard',
        label: 'general.navigation.dashboard',
    },
    {
        name: 'organisation.invitations.index',
        routeName: 'organisation.invitations.index',
        label: 'general.navigation.organisations.invitations',
    },
]
