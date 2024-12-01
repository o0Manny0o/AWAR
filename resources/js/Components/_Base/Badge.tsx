import { tv } from 'tailwind-variants'
import { twMerge } from 'tailwind-merge'
import { PropsWithChildren } from 'react'

export enum BadgeColor {
    PRIMARY = 'primary',
    SECONDARY = 'secondary',
    WARN = 'warn',
    DANGER = 'danger',
    SUCCESS = 'success',
    OTHER = 'other',
}

const badge = tv({
    base: 'inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset',
    variants: {
        color: {
            primary:
                'bg-primary-50 text-primary-700 ring-primary-700/10 dark:bg-primary-400/10 dark:text-primary-400 dark:ring-primary-400/30',
            secondary:
                'bg-gray-50 text-gray-600 ring-gray-500/10 dark:bg-gray-400/10 dark:text-gray-400 dark:ring-gray-400/20',
            warn: 'bg-yellow-50 text-yellow-800 ring-yellow-600/20 dark:bg-yellow-400/10 dark:text-yellow-500 dark:ring-yellow-400/20',
            danger: 'bg-red-50 text-red-700 ring-red-600/10 dark:bg-red-400/10 dark:text-red-400 dark:ring-red-400/20',
            success:
                'bg-green-50 text-green-700 ring-green-600/20 dark:bg-green-500/10 dark:text-green-400 dark:ring-green-500/20',
            other: 'bg-purple-50 text-purple-700 ring-purple-700/10 dark:bg-purple-400/10 dark:text-purple-400 dark:ring-purple-400/30',
        },
    },
    defaultVariants: {
        color: 'primary',
    },
})

export function Badge(
    props: PropsWithChildren<{ className?: string; color?: BadgeColor }>,
) {
    return (
        <span
            className={twMerge(props.className, badge({ color: props.color }))}
        >
            {props.children}
        </span>
    )
}
