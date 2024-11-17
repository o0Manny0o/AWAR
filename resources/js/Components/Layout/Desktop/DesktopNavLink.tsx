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
                    ? 'border-active text-active bg-active-interactive'
                    : 'text-interactive bg-interactive border-interactive'
            } ${className}`}
        >
            {children}
        </Link>
    )
}
