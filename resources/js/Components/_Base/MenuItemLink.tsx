import { InertiaLinkProps, Link } from '@inertiajs/react'
import { ComponentType, forwardRef, ReactNode } from 'react'
import { twMerge } from 'tailwind-merge'

export default forwardRef(function MenuItemLink(
    {
        children,
        active,
        component: Component = Link,
        ...props
    }: InertiaLinkProps & {
        active?: boolean
        component?: ComponentType<{
            className?: string
            href: string
            children: ReactNode
            ref?: any
        }>
    },
    ref,
) {
    return (
        <Component
            ref={ref}
            {...props}
            className={twMerge(
                `text-interactive block w-full px-4 py-2 text-left text-sm
                data-[focus]:bg-gray-100 data-[focus]:outline-none dark:data-[focus]:bg-gray-700`,
                props.className,
            )}
        >
            {children}
        </Component>
    )
})
