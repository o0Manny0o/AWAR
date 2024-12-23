import { NavigationItem } from '@/types/navigation'
import {
    BuildingOfficeIcon,
    CogIcon,
    EnvelopeIcon,
    UsersIcon,
} from '@heroicons/react/24/outline'

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
        name: 'settings.public.show',
        label: 'general.navigation.organisations.settings',
        icon: CogIcon,
    },
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
    {
        name: 'settings.locations.index',
        label: 'general.navigation.organisations.locations',
        icon: BuildingOfficeIcon,
    },
]
