import { MenuItems as BaseMenuItems } from '@headlessui/react'
import { PropsWithChildren } from 'react'
import { tv } from 'tailwind-variants'
import { twMerge } from 'tailwind-merge'

const menuItems = tv({
    base: 'bg-ceiling absolute right-0 z-10 origin-top-right rounded-md py-2 shadow-lg dark:shadow-gray-300/10 ring-1 ring-gray-900/5 dark:ring-gray-50/5 transition focus:outline-none data-[closed]:scale-95 data-[closed]:transform data-[closed]:opacity-0 data-[enter]:duration-200 data-[leave]:duration-75 data-[enter]:ease-out data-[leave]:ease-in',
    variants: {
        size: {
            sm: 'w-32',
            md: 'w-48',
        },
    },
})

export function MenuItems({
    className,
    children,
}: PropsWithChildren<{ className?: string }>) {
    return (
        <BaseMenuItems transition className={twMerge(className, menuItems())}>
            {children}
        </BaseMenuItems>
    )
}
