import { Button } from '@/Components/_Base/Button'

interface PageHeaderProps {
    title: string
    actionButtons?: {
        label: string
        variant: 'primary' | 'secondary'
        href: string
    }[]
}

export default function PageHeader({ title, actionButtons }: PageHeaderProps) {
    return (
        <div className="flex items-baseline justify-between">
            <h2 className="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                {title}
            </h2>
            {actionButtons && (
                <div>
                    {actionButtons.map((button) => (
                        <Button
                            key={button.label}
                            href={button.href}
                            color={button.variant}
                        >
                            {button.label}
                        </Button>
                    ))}
                </div>
            )}
        </div>
    )
}
