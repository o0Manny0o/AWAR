import { Button, ButtonColorVariants } from '@/Components/_Base/Button'
import { Method } from '@inertiajs/core'
import { Badge, BadgeColor } from '@/Components/_Base/Badge'
import { ChevronLeftIcon } from '@heroicons/react/24/solid'

export type PageHeaderButton = {
    label: string
    variant: ButtonColorVariants
    href: string
    method?: Method
}

interface PageHeaderProps {
    title: string
    badge?: {
        color: BadgeColor
        label: string
    }
    actionButtons?: PageHeaderButton[]
    backUrl?: string
}

export default function PageHeader({
    title,
    badge,
    actionButtons,
    backUrl,
}: PageHeaderProps) {
    return (
        <div className="flex items-baseline justify-between">
            <div className="flex items-center gap-2">
                {/* TODO: Improve style */}
                {backUrl && (
                    <Button color="secondary" href={backUrl} className="me-4">
                        <ChevronLeftIcon className="size-5" />
                    </Button>
                )}
                <h2 className="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    {title}
                </h2>
                {badge && <Badge color={badge.color}>{badge.label}</Badge>}
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
