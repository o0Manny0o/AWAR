import {
    CalendarIcon,
    ChartPieIcon,
    DocumentDuplicateIcon,
    FolderIcon,
    HomeIcon,
    UsersIcon,
} from '@heroicons/react/24/outline'
import { SidebarMenuItem } from '@/Components/Layout/Sidebar/SidebarMenuItem'
import { SidebarMenuItemIcon } from '@/Components/Layout/Sidebar/SidebarMenuItemIcon'
import { SidebarMenuList } from '@/Components/Layout/Sidebar/SidebarMenuList'

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
        <SidebarMenuList>
            {navigation.map((item) => (
                <SidebarMenuItem
                    key={item.name}
                    href={item.href}
                    active={item.current}
                >
                    <SidebarMenuItemIcon
                        icon={item.icon}
                        active={item.current}
                    />
                    {item.name}
                </SidebarMenuItem>
            ))}
        </SidebarMenuList>
    )
}
