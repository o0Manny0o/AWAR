import { SidebarMenuItem } from '@/Components/Layout/Sidebar/SidebarMenuItem'
import useTranslate from '@/shared/hooks/useTranslate'
import { SidebarMenuItemIcon } from '@/Components/Layout/Sidebar/SidebarMenuItemIcon'
import { SidebarMenuList } from '@/Components/Layout/Sidebar/SidebarMenuList'
import { useContext } from 'react'
import { SidebarContext } from '@/Components/Layout/Sidebar/Sidebar.context'

const organisations = [
    { id: 1, name: 'Heroicons', href: '#', initial: 'H', current: false },
    { id: 2, name: 'Tailwind Labs', href: '#', initial: 'T', current: false },
    { id: 3, name: 'Workcation', href: '#', initial: 'W', current: false },
]

export function SidebarOrganisationNav() {
    const __ = useTranslate()
    const { colored } = useContext(SidebarContext)

    return (
        <>
            <div
                className={`text-xs/6 font-semibold
                    ${colored ? 'text-primary-700 dark:text-primary-200' : 'text-basic'}`}
            >
                {__('general.navigation.your_organisations')}
            </div>
            <SidebarMenuList>
                {organisations.map((team) => (
                    <SidebarMenuItem
                        key={team.name}
                        href={team.href}
                        active={team.current}
                    >
                        <SidebarMenuItemIcon text={team.initial} />
                        <span className="truncate">{team.name}</span>
                    </SidebarMenuItem>
                ))}
            </SidebarMenuList>
        </>
    )
}
