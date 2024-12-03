import { NavigationItem } from '@/types/navigation'
import { EnvelopeIcon, HomeIcon, UsersIcon } from '@heroicons/react/24/outline'

export const CentralNavigation: NavigationItem[] = [
    {
        name: 'dashboard',
        label: 'general.navigation.dashboard',
    },
    {
        name: 'organisations.applications.index',
        label: 'general.navigation.organisations.applications',
    },
]

export const TenantNavigation: NavigationItem[] = [
    {
        name: 'tenant.dashboard',
        label: 'general.navigation.dashboard',
        icon: HomeIcon,
    },
    {
        name: 'organisation.invitations.index',
        label: 'general.navigation.organisations.invitations',
        icon: EnvelopeIcon,
    },
    {
        name: 'organisation.members.index',
        label: 'general.navigation.organisations.members',
        icon: UsersIcon,
    },
]
