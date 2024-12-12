import { twMerge } from 'tailwind-merge'
import { PropsWithChildren } from 'react'

export function SidebarMenuList(
    props: PropsWithChildren<{ className?: string }>,
) {
    return (
        <ul role="list" className={twMerge('-mx-2 space-y-1', props.className)}>
            {props.children}
        </ul>
    )
}
