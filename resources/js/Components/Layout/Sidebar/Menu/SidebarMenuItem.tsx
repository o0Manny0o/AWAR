import { twJoin } from 'tailwind-merge'
import { ComponentType, PropsWithChildren, ReactNode, useContext } from 'react'
import { SidebarContext } from '@/Components/Layout/Sidebar/Sidebar.context'
import { Link } from '@inertiajs/react'

export function SidebarMenuItem({
    href,
    active,
    children,
    element: Element = Link,
}: PropsWithChildren<{
    href: string
    active: boolean
    element?: ComponentType<{
        children: ReactNode
        href: string
        className?: string
    }>
}>) {
    const { colored } = useContext(SidebarContext)

    return (
        <li>
            <Element
                href={href}
                className={twJoin(
                    active
                        ? 'bg-primary-700 text-white'
                        : `hover:bg-primary-700 hover:text-white ${
                            colored
                                  ? 'dark:text-primary-200 text-primary-700'
                                  : 'text-basic'
                            }`,
                    `group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold transition-colors
                    ease-in`,
                )}
            >
                {children}
            </Element>
        </li>
    )
}
