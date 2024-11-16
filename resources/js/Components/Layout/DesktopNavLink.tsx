import { InertiaLinkProps, Link } from '@inertiajs/react'

export default function DesktopNavLink({
    active = false,
    className = '',
    children,
    ...props
}: InertiaLinkProps & { active?: boolean }) {
    return (
        <Link
            {...props}
            className={`inline-flex items-center border-b-2 px-3 pt-1 text-sm font-medium ${
                active
                    ? 'border-active text-active focus:bg-primary-100 dark:focus:bg-primary-900'
                    : 'text-interactive border-transparent hover:border-gray-300 focus:border-primary-700 focus:bg-gray-50 dark:hover:border-gray-600 dark:focus:border-gray-600 dark:focus:bg-primary-300'
            } ${className}`}
        >
            {children}
        </Link>
    )
}
