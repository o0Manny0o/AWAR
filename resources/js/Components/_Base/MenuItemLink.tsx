import { InertiaLinkProps, Link } from '@inertiajs/react'

export default function MenuItemLink({
    children,
    active,
    ...props
}: InertiaLinkProps & { active?: boolean }) {
    return (
        <Link
            {...props}
            href={route('profile.edit')}
            className="text-interactive block w-full px-4 py-2 text-left text-sm data-[focus]:bg-gray-100 data-[focus]:outline-none dark:data-[focus]:bg-gray-700"
        >
            {children}
        </Link>
    )
}
