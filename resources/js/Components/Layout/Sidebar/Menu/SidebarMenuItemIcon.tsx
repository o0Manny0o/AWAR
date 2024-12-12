import { twJoin } from 'tailwind-merge'
import { ComponentType, useContext } from 'react'
import { SidebarContext } from '@/Components/Layout/Sidebar/Sidebar.context'

type SideMenuIcon = {
    icon: ComponentType<{ className?: string }>
    active: boolean
}

type SideMenuText = {
    text: string
}

type SidebarMenuItemIconProps = SideMenuIcon | SideMenuText

function isIcon(item: SidebarMenuItemIconProps): item is SideMenuIcon {
    return !!(item as SideMenuIcon).icon
}

export function SidebarMenuItemIcon(props: SidebarMenuItemIconProps) {
    const { colored } = useContext(SidebarContext)

    return (
        <span className="shrink-0 size-6">
            {isIcon(props) ? (
                <props.icon
                    aria-hidden="true"
                    className={twJoin(
                        props.active
                            ? 'text-white'
                            : `group-hover:text-white
                                ${colored ? 'dark:text-primary-200 text-primary-700' : 'text-basic'}`,
                        ' transition-colors ease-in ',
                    )}
                ></props.icon>
            ) : (
                <span
                    className="flex items-center justify-center rounded-lg border border-primary-400
                        bg-primary-500 text-[0.625rem] font-medium text-white"
                >
                    {props.text}
                </span>
            )}
        </span>
    )
}
