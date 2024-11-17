import { InertiaLinkProps, Link } from '@inertiajs/react'
import { twMerge } from 'tailwind-merge'

export default function MobileNavLink(
    props: InertiaLinkProps & { active: boolean },
) {
    return (
        <Link
            {...props}
            className={twMerge(
                props.className,
                'flex rounded p-2',
                props.active
                    ? 'bg-active text-active'
                    : 'text-interactive bg-interactive',
            )}
        >
            {props.children}
        </Link>
    )
}
