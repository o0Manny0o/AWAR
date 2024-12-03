import { Logo } from '@/Components/Layout/Logo'
import { getAbbreviation } from '@/shared/util'
import { Link, usePage } from '@inertiajs/react'
import { useContext } from 'react'
import { SidebarContext } from '@/Components/Layout/Sidebar/Sidebar.context'
import { twJoin } from 'tailwind-merge'

// TODO: Improve Design
export function SidebarBranding() {
    const { tenant } = usePage().props
    const { colored } = useContext(SidebarContext)

    const colorClass = colored
        ? 'dark:hover:text-white dark:focus:text-white text-primary-700 dark:text-primary-200'
        : 'dark:hover:text-primary-400 dark:focus:text-primary-400 text-basic'

    return (
        <Link
            href={route(
                tenant ? 'tenant.dashboard' : 'dashboard',
                undefined,
                false,
            )}
            className={twJoin(
                `flex gap-4 h-16 w-full shrink-0 items-center hover:text-primary-600
                focus:text-primary-600`,
                colorClass,
            )}
        >
            <Logo className="shrink-0" />
            <p className="truncate text-4xl/9 font-semibold tracking-wider min-w-0">
                {getAbbreviation(tenant?.name ?? 'AWAR')}
                <span className="sr-only">{tenant?.name ?? 'AWAR'}</span>
            </p>
        </Link>
    )
}
