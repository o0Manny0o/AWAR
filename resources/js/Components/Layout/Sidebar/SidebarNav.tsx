import { Branding } from '@/Components/Layout/Branding'
import { SidebarMainNav } from '@/Components/Layout/Sidebar/SidebarMainNav'
import { SidebarOrganisationNav } from '@/Components/Layout/Sidebar/SidebarOrganisationNav'
import { SidebarMenuList } from '@/Components/Layout/Sidebar/SidebarMenuList'
import { SidebarMenuItem } from '@/Components/Layout/Sidebar/SidebarMenuItem'
import { SidebarMenuItemIcon } from '@/Components/Layout/Sidebar/SidebarMenuItemIcon'
import { Cog6ToothIcon } from '@heroicons/react/24/solid'
import { SidebarContext } from '@/Components/Layout/Sidebar/Sidebar.context'

export function SidebarNav({ colored }: { colored?: boolean }) {
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
                            <SidebarMainNav />
                        </li>
                        <li className="mt-auto"></li>
                        <li>
                            <SidebarOrganisationNav />
                        </li>
                        <li>
                            <SidebarMenuList>
                                <SidebarMenuItem href={'#'} active={false}>
                                    <SidebarMenuItemIcon
                                        icon={Cog6ToothIcon}
                                        active={false}
                                    />
                                    Settings
                                </SidebarMenuItem>
                            </SidebarMenuList>
                        </li>
                    </ul>
                </nav>
            </div>
        </SidebarContext.Provider>
    )
}
