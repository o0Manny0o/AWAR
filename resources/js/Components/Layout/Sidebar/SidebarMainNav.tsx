import { SidebarMenuItem } from '@/Components/Layout/Sidebar/SidebarMenuItem'
import { SidebarMenuItemIcon } from '@/Components/Layout/Sidebar/SidebarMenuItemIcon'
import { SidebarMenuList } from '@/Components/Layout/Sidebar/SidebarMenuList'
import { usePage } from '@inertiajs/react'
import {
    CentralNavigation,
    TenantNavigation,
} from '@/shared/_constants/AuthenticatedNavigation'
import useTranslate from '@/shared/hooks/useTranslate'

export function SidebarMainNav() {
    const __ = useTranslate()
    const { tenant } = usePage().props

    const navigation = tenant ? TenantNavigation : CentralNavigation

    return (
        <SidebarMenuList>
            {navigation.map((item) => (
                <SidebarMenuItem
                    key={item.name}
                    href={route(item.name)}
                    active={route().current(item.name)}
                >
                    {item.icon && (
                        <SidebarMenuItemIcon
                            icon={item.icon}
                            active={route().current(item.name)}
                        />
                    )}
                    {__(item.label)}
                </SidebarMenuItem>
            ))}
        </SidebarMenuList>
    )
}
