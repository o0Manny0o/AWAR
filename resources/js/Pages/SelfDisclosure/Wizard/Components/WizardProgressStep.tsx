import { tv } from 'tailwind-variants'
import { Link } from '@inertiajs/react'

export function WizardProgressStep({
    step,
    state,
}: {
    step: { name: string; href: string }
    state: 'completed' | 'active' | 'upcoming'
}) {
    const styles = tv({
        slots: {
            border: 'group flex flex-col border-l-4 py-2 pl-4 md:border-l-0 md:border-t-4 md:pb-0 md:pl-0 md:pt-4 min-w-0 truncate',
            text: 'text-sm font-medium invisible min-[400px]:visible truncate',
        },
        variants: {
            state: {
                completed: {
                    border: 'border-primary-600 hover:border-primary-800 dark:border-primary-400 dark:hover:border-primary-200 focus:border-primary-800 dark:focus:border-primary-200',
                    text: 'text-primary-interactive group-hover:text-primary-800 dark:group-hover:text-primary-200 group-focus:text-primary-800 dark:group-focus:text-primary-200',
                },
                active: {
                    border: 'border-primary-600 dark:border-primary-400',
                    text: 'text-primary-600 dark:text-primary-400',
                },
                upcoming: {
                    border: 'border-gray-600 dark:border-gray-400 hover:border-gray-800 dark:hover:border-gray-200 focus:border-gray-800 dark:focus:border-gray-200',
                    text: 'text-interactive group-hover:text-gray-800 dark:group-hover:text-gray-200 group-focus:text-gray-800 dark:group-focus:text-gray-200',
                },
            },
        },
    })

    const { border, text } = styles({
        state,
    })

    return state === 'active' ? (
        <p className={border()}>
            <span className={text()}>{step.name}</span>
        </p>
    ) : (
        <Link href={step.href} className={border()}>
            <span className={text()}>{step.name}</span>
        </Link>
    )
}
