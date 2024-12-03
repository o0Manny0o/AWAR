import { SidebarMenuItem } from '@/Components/Layout/Sidebar/SidebarMenuItem'
import useTranslate from '@/shared/hooks/useTranslate'

const organisations = [
    { id: 1, name: 'Heroicons', href: '#', initial: 'H', current: false },
    { id: 2, name: 'Tailwind Labs', href: '#', initial: 'T', current: false },
    { id: 3, name: 'Workcation', href: '#', initial: 'W', current: false },
]

export function SidebarOrganisationNav() {
    const __ = useTranslate()

    return (
        <>
            <div className="text-xs/6 font-semibold text-primary-700 dark:text-primary-200">
                {__('general.navigation.your_organisations')}
            </div>
            <ul role="list" className="-mx-2 mt-2 space-y-1">
                {organisations.map((team) => (
                    <SidebarMenuItem
                        key={team.name}
                        href={team.href}
                        active={team.current}
                    >
                        <span
                            className="flex size-6 shrink-0 items-center justify-center rounded-lg border
                                border-primary-400 bg-primary-500 text-[0.625rem] font-medium text-white"
                        >
                            {team.initial}
                        </span>
                        <span className="truncate">{team.name}</span>
                    </SidebarMenuItem>
                ))}
            </ul>
        </>
    )
}
