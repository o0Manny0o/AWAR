import { Branding } from '@/Components/Layout/Branding'
import { SidebarOrganisationNav } from '@/Components/Layout/Sidebar/SidebarOrganisationNav'
import { SidebarMenuList } from '@/Components/Layout/Sidebar/Menu/SidebarMenuList'
import { SidebarMenuItem } from '@/Components/Layout/Sidebar/Menu/SidebarMenuItem'
import { SidebarMenuItemIcon } from '@/Components/Layout/Sidebar/Menu/SidebarMenuItemIcon'
import { Cog6ToothIcon } from '@heroicons/react/24/solid'
import { SidebarContext } from '@/Components/Layout/Sidebar/Sidebar.context'
import { NavigationItem } from '@/types/navigation'
import useTranslate from '@/shared/hooks/useTranslate'
import { usePage } from '@inertiajs/react'
import { HomeIcon } from '@heroicons/react/24/outline'
import { RouteName } from 'ziggy-js'

export function SidebarNav({
    colored,
    navigation,
    showOrganisation = true,
    isSettings = false,
}: {
    colored?: boolean
    navigation: NavigationItem[]
    showOrganisation?: boolean
    isSettings?: boolean
}) {
    const __ = useTranslate()
    const { tenant } = usePage().props

    const settingsUrl: RouteName = tenant
        ? 'settings.members.index'
        : 'settings.profile.edit'
    const dashboardUrl: RouteName = tenant ? 'tenant.dashboard' : 'dashboard'

    return (
        <SidebarContext.Provider value={{ colored }}>
            <div
                className={`flex grow flex-col gap-y-5 overflow-y-auto px-6 pb-4
                    ${colored ? 'bg-primary-200 dark:bg-primary-950' : 'bg-ceiling'}`}
            >
                <Branding />
                <nav className="flex flex-1 flex-col">
                    <ul role="list" className="flex flex-1 flex-col gap-y-7">
                        <li>
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
                                                active={route().current(
                                                    item.name,
                                                )}
                                            />
                                        )}
                                        {__(item.label)}
                                    </SidebarMenuItem>
                                ))}
                            </SidebarMenuList>
                        </li>
                        <li className="mt-auto"></li>
                        {showOrganisation && (
                            <li>
                                <SidebarOrganisationNav />
                            </li>
                        )}
                        {isSettings ? (
                            <li>
                                <SidebarMenuList>
                                    <SidebarMenuItem
                                        href={route(dashboardUrl)}
                                        active={route().current(dashboardUrl)}
                                    >
                                        <SidebarMenuItemIcon
                                            icon={HomeIcon}
                                            active={false}
                                        />
                                        Dashboard
                                    </SidebarMenuItem>
                                </SidebarMenuList>
                            </li>
                        ) : (
                            <li>
                                <SidebarMenuList>
                                    <SidebarMenuItem
                                        href={route(settingsUrl)}
                                        active={route().current(settingsUrl)}
                                    >
                                        <SidebarMenuItemIcon
                                            icon={Cog6ToothIcon}
                                            active={false}
                                        />
                                        Settings
                                    </SidebarMenuItem>
                                </SidebarMenuList>
                            </li>
                        )}
                    </ul>
                </nav>
            </div>
        </SidebarContext.Provider>
    )
}
