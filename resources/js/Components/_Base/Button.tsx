import { tv, VariantProps } from 'tailwind-variants'
import { twMerge } from 'tailwind-merge'
import { ButtonHTMLAttributes, ClassAttributes } from 'react'
import { JSX } from 'react/jsx-runtime'
import { Link } from '@inertiajs/react'
import { Method } from '@inertiajs/core'

export type ButtonColorVariants = 'primary' | 'secondary' | 'danger'

const button = tv({
    base: 'rounded-md transition duration-150 ease-in-out font-semibold inline-flex items-center justify-center border shadow-sm dark:shadow-gray-300/10',
    variants: {
        color: {
            primary:
                'bg-gray-800 hover:bg-gray-700 focus:bg-gray-700 text-gray-50 dark:bg-gray-200 dark:text-gray-800 dark:hover:bg-white dark:focus:bg-white',
            secondary:
                'bg-gray-50 text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-900 border-gray-300 dark:border-gray-600 dark:hover:bg-gray-800 focus:bg-gray-100 dark:focus:bg-gray-800',
            danger: 'bg-red-50 text-red-700 hover:bg-red-100 dark:text-red-400 dark:bg-red-400/10 border-red-600/10 dark:border-red-400/20 dark:hover:bg-red-500/20 focus:bg-red-100 dark:focus:bg-red-500/20',
        },
        size: {
            xs: 'px-2 py-1 text-xs',
            sm: 'px-2 py-1 text-sm',
            base: 'px-2.5 py-1.5 text-sm',
            md: 'px-3 py-2 text-sm ',
            lg: 'px-3.5 py-2.5 text-sm',
        },
        disabled: {
            true: 'opacity-50 bg-gray-500 pointer-events-none',
        },
    },
    defaultVariants: {
        size: 'base',
        color: 'primary',
    },
})

type ButtonVariants = VariantProps<typeof button>

export function Button(
    props: JSX.IntrinsicAttributes &
        ClassAttributes<HTMLButtonElement> &
        ButtonHTMLAttributes<HTMLButtonElement> &
        ButtonVariants & { href?: string; method?: Method },
) {
    return props.href ? (
        <Link
            method={props.method}
            href={props.href}
            {...(props.method && props.method !== 'get'
                ? { as: 'button' }
                : {})}
            className={twMerge(
                button({
                    color: props.color,
                    size: props.size,
                    disabled: props.disabled,
                }),
                props.className,
            )}
        >
            {props.children}
        </Link>
    ) : (
        <button
            {...props}
            className={twMerge(
                button({
                    color: props.color,
                    size: props.size,
                    disabled: props.disabled,
                }),
                props.className,
            )}
        >
            {props.children}
        </button>
    )
}
