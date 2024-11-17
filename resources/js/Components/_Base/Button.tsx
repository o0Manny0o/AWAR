import { tv, VariantProps } from 'tailwind-variants'
import { twMerge } from 'tailwind-merge'
import { ButtonHTMLAttributes, ClassAttributes } from 'react'
import { JSX } from 'react/jsx-runtime'
import { Link } from '@inertiajs/react'

const button = tv({
    base: 'rounded-md font-semibold',
    variants: {
        color: {
            primary: 'bg-primary-500 text-white',
            secondary:
                'bg-gray-50 dark:bg-gray-800 text-base border border-gray-300 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 focus:bg-gray-100 dark:focus:bg-gray-700',
        },
        size: {
            sm: 'text-sm',
            md: 'text-base',
            lg: 'px-4 py-3 text-lg',
        },
        disabled: {
            true: 'opacity-50 bg-gray-500 pointer-events-none',
        },
    },
    defaultVariants: {
        size: 'md',
        color: 'primary',
    },
})

type ButtonVariants = VariantProps<typeof button>

export function Button(
    props: JSX.IntrinsicAttributes &
        ClassAttributes<HTMLButtonElement> &
        ButtonHTMLAttributes<HTMLButtonElement> &
        ButtonVariants & { href?: string },
) {
    return props.href ? (
        <Link
            href={props.href}
            className={twMerge(
                'inline-block',
                props.className,
                button({ color: props.color, size: props.size }),
            )}
        >
            {props.children}
        </Link>
    ) : (
        <button
            {...props}
            className={twMerge(
                props.className,
                button({ color: props.color, size: props.size }),
            )}
        >
            {props.children}
        </button>
    )
}
