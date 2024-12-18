import { NavigationItem } from '@/types/navigation'
import { HomeIcon } from '@heroicons/react/24/outline'
import { CatIcon } from '@/shared/icons/CatIcon'
import { DogIcon } from '@/shared/icons/DogIcon'

export const CentralNavigation: NavigationItem[] = [
    {
        name: 'dashboard',
        label: 'general.navigation.dashboard',
    },
]

export const TenantNavigation: NavigationItem[] = [
    {
        name: 'tenant.dashboard',
        label: 'general.navigation.dashboard',
        icon: HomeIcon,
    },
    {
        name: 'animals.dogs.index',
        label: 'general.navigation.animals.dogs',
        icon: DogIcon,
    },
    {
        name: 'animals.cats.index',
        label: 'general.navigation.animals.cats',
        icon: CatIcon,
    },
]
