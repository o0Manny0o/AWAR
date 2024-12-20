import { tv } from 'tailwind-variants'
import { Link } from '@inertiajs/react'

export function WizardProgressStep({
    step,
    state,
}: {
    step: { name: string; href: string }
    state: 'active' | 'selectable' | 'disabled'
}) {
    const styles = tv({
        slots: {
            border: 'group flex flex-col border-l-4 py-2 pl-4 md:border-l-0 md:border-t-4 md:pb-0 md:pl-0 md:pt-4 min-w-0 truncate',
            text: 'text-sm font-medium invisible min-[400px]:visible truncate',
        },
        variants: {
            state: {
                selectable: {
                    border: 'border-gray-700 hover:border-gray-800 dark:border-gray-400 dark:hover:border-gray-200 focus:border-gray-800 dark:focus:border-gray-200',
                    text: 'text-gray-700 dark:text-gray-400 group-hover:text-gray-800 dark:group-hover:text-gray-200 group-focus:text-gray-800 dark:group-focus:text-gray-200',
                },
                active: {
                    border: 'border-primary-800 dark:border-primary-400',
                    text: 'text-primary-800 dark:text-primary-400',
                },
                disabled: {
                    border: 'border-gray-700/50 dark:border-gray-400/50',
                    text: 'text-gray-700/50 dark:text-gray-400/50',
                },
            },
        },
    })

    const { border, text } = styles({
        state,
    })

    return state !== 'selectable' ? (
        <p className={border()}>
            <span className={text()}>{step.name}</span>
        </p>
    ) : (
        <Link href={step.href} className={border()}>
            <span className={text()}>{step.name}</span>
        </Link>
    )
}
