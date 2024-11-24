import { Button, ButtonColorVariants } from '@/Components/_Base/Button'
import { Method } from '@inertiajs/core'
import { ReactNode } from 'react'

export type PageHeaderButton = {
    label: string
    variant: ButtonColorVariants
    href: string
    method?: Method
}

interface PageHeaderProps {
    title: string
    subtitle?: ReactNode
    actionButtons?: PageHeaderButton[]
}

export default function PageHeader({
    title,
    subtitle,
    actionButtons,
}: PageHeaderProps) {
    return (
        <div className="flex items-baseline justify-between">
            <div className="flex items-center gap-2">
                <h2 className="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    {title}
                </h2>
                {subtitle}
            </div>
            {actionButtons && (
                <div className="flex gap-2">
                    {actionButtons.map((button) => (
                        <Button
                            key={button.label}
                            href={button.href}
                            color={button.variant}
                            method={button.method}
                        >
                            {button.label}
                        </Button>
                    ))}
                </div>
            )}
        </div>
    )
}
