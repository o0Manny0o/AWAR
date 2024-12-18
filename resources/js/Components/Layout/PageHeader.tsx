import { Button, ButtonColorVariants } from '@/Components/_Base/Button'
import { Method } from '@inertiajs/core'
import { Badge, BadgeColor } from '@/Components/_Base/Badge'
import { ChevronLeftIcon } from '@heroicons/react/24/solid'
import { twMerge } from 'tailwind-merge'
import { Context, createContext, useContext } from 'react'

type PageHeaderBaseButton = {
    label: string
    variant: ButtonColorVariants
    disabled?: boolean
}

type PageHeaderLink = PageHeaderBaseButton & {
    href: string
    method?: Method
}

type PageHeaderSubmit = PageHeaderBaseButton & {
    form: string
}

export type PageHeaderButton = PageHeaderLink | PageHeaderSubmit

const defaultFormContext = createContext({ processing: false })

function isPageHeaderLink(item: PageHeaderButton): item is PageHeaderLink {
    return !!(item as PageHeaderLink).href
}

export interface PageHeaderProps {
    title: string
    badge?: {
        color: BadgeColor
        label: string
    }
    actionButtons?: PageHeaderButton[]
    backUrl?: string
    className?: string
    formContext?: Context<any>
}

export default function PageHeader({
    title,
    badge,
    actionButtons,
    backUrl,
    className,
    formContext,
}: PageHeaderProps) {
    const { processing } = useContext(formContext ?? defaultFormContext)

    return (
        <div
            className={twMerge(
                'flex items-center mb-4 h-10 justify-between',
                className,
            )}
        >
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
                    {actionButtons.map((button) =>
                        isPageHeaderLink(button) ? (
                            <Button
                                key={button.label}
                                href={button.href}
                                color={button.variant}
                                method={button.method}
                                disabled={button.disabled || processing}
                            >
                                {button.label}
                            </Button>
                        ) : (
                            <Button
                                key={button.label}
                                color={button.variant}
                                form={button.form}
                                disabled={button.disabled || processing}
                            >
                                {button.label}
                            </Button>
                        ),
                    )}
                </div>
            )}
        </div>
    )
}
