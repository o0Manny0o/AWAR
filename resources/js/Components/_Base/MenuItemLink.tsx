import { InertiaLinkProps, Link } from '@inertiajs/react'
import { forwardRef } from 'react'
import { twMerge } from 'tailwind-merge'

export default forwardRef(function MenuItemLink(
    { children, active, ...props }: InertiaLinkProps & { active?: boolean },
    ref,
) {
    return (
        <Link
            ref={ref}
            {...props}
            className={twMerge(
                `text-interactive block w-full px-4 py-2 text-left text-sm
                data-[focus]:bg-gray-100 data-[focus]:outline-none dark:data-[focus]:bg-gray-700`,
                props.className,
            )}
        >
            {children}
        </Link>
    )
})
