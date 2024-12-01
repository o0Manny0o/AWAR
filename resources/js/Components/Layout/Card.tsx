import { PropsWithChildren } from 'react'
import { twMerge } from 'tailwind-merge'

interface CardProps {
    header?: string
    className?: string
}

export function Card({
    children,
    header,
    className,
}: PropsWithChildren<CardProps>) {
    return (
        <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div
                className={twMerge(
                    'bg-ceiling space-y-4 rounded-lg p-4 shadow sm:p-6',
                    className,
                )}
            >
                {header && <h3>{header}</h3>}

                {children}
            </div>
        </div>
    )
}
