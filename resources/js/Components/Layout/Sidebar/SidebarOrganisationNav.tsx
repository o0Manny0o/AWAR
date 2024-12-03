import { SidebarMenuItem } from '@/Components/Layout/Sidebar/SidebarMenuItem'
import useTranslate from '@/shared/hooks/useTranslate'
import { SidebarMenuItemIcon } from '@/Components/Layout/Sidebar/SidebarMenuItemIcon'
import { SidebarMenuList } from '@/Components/Layout/Sidebar/SidebarMenuList'
import { useContext } from 'react'
import { SidebarContext } from '@/Components/Layout/Sidebar/Sidebar.context'
import { usePage } from '@inertiajs/react'

const organisations = [
    { id: 1, name: 'Heroicons', href: '#', initial: 'H', current: false },
    { id: 2, name: 'Tailwind Labs', href: '#', initial: 'T', current: false },
    { id: 3, name: 'Workcation', href: '#', initial: 'W', current: false },
]

export function SidebarOrganisationNav() {
    const __ = useTranslate()
    const { colored } = useContext(SidebarContext)
    const {
        auth: { user },
        tenant,
    } = usePage().props

    return (
        <>
            <div
                className={`text-xs/6 font-semibold
                    ${colored ? 'text-primary-700 dark:text-primary-200' : 'text-basic'}`}
            >
                {__('general.navigation.your_organisations')}
            </div>
            <SidebarMenuList>
                {user.tenants?.map(
                    (organisation) =>
                        organisation.domains &&
                        organisation.domains[0] && (
                            <SidebarMenuItem
                                key={organisation.name}
                                href={`https://${organisation.domains[0].domain}/dashboard`}
                                active={
                                    tenant?.domains?.[0].domain ===
                                    organisation.domains[0].domain
                                }
                                element={function Anchor(props) {
                                    return <a {...props}>{props.children}</a>
                                }}
                            >
                                <SidebarMenuItemIcon
                                    text={organisation.name
                                        .charAt(0)
                                        .toUpperCase()}
                                />
                                <span className="truncate">
                                    {organisation.name}
                                </span>
                            </SidebarMenuItem>
                        ),
                )}
            </SidebarMenuList>
        </>
    )
}
