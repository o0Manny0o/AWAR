import { twJoin } from 'tailwind-merge'
import { PropsWithChildren } from 'react'

export function SidebarMenuItem({
    href,
    active,
    children,
}: PropsWithChildren<{ href: string; active: boolean }>) {
    return (
        <li>
            <a
                href={href}
                className={twJoin(
                    active
                        ? 'bg-primary-700 text-white'
                        : 'dark:text-primary-200 hover:bg-primary-700 hover:text-white text-primary-700',
                    `group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold transition-colors
                    ease-in`,
                )}
            >
                {children}
            </a>
        </li>
    )
}
