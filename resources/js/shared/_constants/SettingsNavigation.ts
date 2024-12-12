import { NavigationItem } from '@/types/navigation'
import { EnvelopeIcon, UsersIcon } from '@heroicons/react/24/outline'

export const CentralSettingsNavigation: NavigationItem[] = [
    {
        name: 'settings.profile.edit',
        label: 'general.navigation.profile',
    },
    {
        name: 'settings.applications.index',
        label: 'general.navigation.organisations.applications',
    },
]

export const TenantSettingsNavigation: NavigationItem[] = [
    {
        name: 'settings.members.index',
        label: 'general.navigation.organisations.members',
        icon: UsersIcon,
    },
    {
        name: 'settings.invitations.index',
        label: 'general.navigation.organisations.invitations',
        icon: EnvelopeIcon,
    },
]
