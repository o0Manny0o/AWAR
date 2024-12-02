import { PropsWithChildren } from 'react'
import { twMerge } from 'tailwind-merge'

interface CardProps {
    header?: string
    bodyClassName?: string
    className?: string
}

export function Card({
    children,
    header,
    bodyClassName,
    className,
}: PropsWithChildren<CardProps>) {
    return (
        <div
            className={twMerge(
                'mx-auto w-full sm:max-w-7xl px-2 sm:px-6 lg:px-8',
                className,
            )}
        >
            <div
                className={twMerge(
                    'bg-ceiling space-y-4 rounded-lg p-4 shadow sm:p-6',
                    bodyClassName,
                )}
            >
                {header && <h3>{header}</h3>}

                {children}
            </div>
        </div>
    )
}
