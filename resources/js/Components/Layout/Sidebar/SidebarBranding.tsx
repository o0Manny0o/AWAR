import { Logo } from '@/Components/Layout/Logo'
import { getAbbreviation } from '@/shared/util'
import { Link, usePage } from '@inertiajs/react'

// TODO: Improve Design
export function SidebarBranding() {
    const { tenant } = usePage().props
    return (
        <Link
            href="/public"
            className="flex gap-4 h-16 w-full shrink-0 items-center hover:text-primary-600
                focus:text-primary-600 dark:hover:text-white dark:focus:text-white
                text-primary-700 dark:text-primary-200"
        >
            <Logo className="shrink-0" />
            <p className="truncate text-4xl/9 font-semibold tracking-wider min-w-0">
                {getAbbreviation(tenant?.name ?? 'AWAR')}
            </p>
        </Link>
    )
}
