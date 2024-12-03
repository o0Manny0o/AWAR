import { twJoin, twMerge } from 'tailwind-merge'
import {
    CalendarIcon,
    ChartPieIcon,
    DocumentDuplicateIcon,
    FolderIcon,
    HomeIcon,
    UsersIcon,
} from '@heroicons/react/24/solid'

const navigation = [
    { name: 'Dashboard', href: '#', icon: HomeIcon, current: true },
    { name: 'Team', href: '#', icon: UsersIcon, current: false },
    { name: 'Projects', href: '#', icon: FolderIcon, current: false },
    { name: 'Calendar', href: '#', icon: CalendarIcon, current: false },
    {
        name: 'Documents',
        href: '#',
        icon: DocumentDuplicateIcon,
        current: false,
    },
    { name: 'Reports', href: '#', icon: ChartPieIcon, current: false },
]

export function SidebarMainNav() {
    return (
        <ul role="list" className="-mx-2 space-y-1">
            {navigation.map((item) => (
                <li key={item.name}>
                    <a
                        href={item.href}
                        className={twJoin(
                            item.current
                                ? 'bg-primary-700 text-white'
                                : 'dark:text-primary-200 hover:bg-primary-700 hover:text-white text-primary-700',
                            `group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold transition-colors
                            ease-in`,
                        )}
                    >
                        <item.icon
                            aria-hidden="true"
                            className={twJoin(
                                item.current
                                    ? 'text-white'
                                    : 'dark:text-primary-200 group-hover:text-white text-primary-700',
                                'size-6 shrink-0 transition-colors ease-in',
                            )}
                        />
                        {item.name}
                    </a>
                </li>
            ))}
        </ul>
    )
}
