import { NavigationItem } from '@/types/navigation'
import { DocumentIcon, HomeIcon } from '@heroicons/react/24/outline'
import { CatIcon } from '@/shared/icons/CatIcon'
import { DogIcon } from '@/shared/icons/DogIcon'

export class NextStep {
    static readonly FINISH_DISCLOSURE: NextStep = new NextStep(
        'FINISH_DISCLOSURE',
        {
            name: 'self-disclosure',
            label: 'general.navigation.self_disclosure.finish',
            icon: DocumentIcon,
        },
    )

    private constructor(
        private readonly key: string,
        public readonly value: NavigationItem,
    ) {}

    toString() {
        return this.key
    }
}

export const CentralNavigation: (
    nextSteps?: NavigationItem[],
) => NavigationItem[] = (nextSteps) => [
    ...(nextSteps ?? []),
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
