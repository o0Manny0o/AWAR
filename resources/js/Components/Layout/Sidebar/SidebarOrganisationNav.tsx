import { SidebarMenuItem } from '@/Components/Layout/Sidebar/Menu/SidebarMenuItem'
import useTranslate from '@/shared/hooks/useTranslate'
import { SidebarMenuItemIcon } from '@/Components/Layout/Sidebar/Menu/SidebarMenuItemIcon'
import { SidebarMenuList } from '@/Components/Layout/Sidebar/Menu/SidebarMenuList'
import { useContext } from 'react'
import { SidebarContext } from '@/Components/Layout/Sidebar/Sidebar.context'
import { usePage } from '@inertiajs/react'
import { Anchor } from '@/Components/_Base/Anchor'

export function SidebarOrganisationNav() {
    const __ = useTranslate()
    const { colored } = useContext(SidebarContext)
    const { tenant, tenants } = usePage().props

    if (!tenants?.length) {
        return null
    }

    return (
        <>
            <div
                className={`text-xs/6 font-semibold
                    ${colored ? 'text-primary-700 dark:text-primary-200' : 'text-basic'}`}
            >
                {__('general.navigation.your_organisations')}
            </div>
            <SidebarMenuList>
                {tenants?.map((organisation) => (
                    <SidebarMenuItem
                        key={organisation.name}
                        href={organisation.dashboard_url}
                        active={tenant?.name === organisation.name}
                        element={Anchor}
                    >
                        <SidebarMenuItemIcon
                            text={organisation.name.charAt(0).toUpperCase()}
                        />
                        <span className="truncate">{organisation.name}</span>
                    </SidebarMenuItem>
                ))}
            </SidebarMenuList>
        </>
    )
}
