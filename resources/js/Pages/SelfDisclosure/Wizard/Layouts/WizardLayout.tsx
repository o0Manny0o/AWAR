import { WizardProgressStep } from '@/Pages/SelfDisclosure/Wizard/Components/WizardProgressStep'
import { usePage } from '@inertiajs/react'
import { BaseLayout } from '@/Layouts/BaseLayout'
import { PropsWithChildren } from 'react'
import { FormStack } from '@/Components/Layout/FormStack'

type WizardStep = {
    name: string
    href: string
    upcoming?: boolean
}

export function WizardLayout({
    header,
    children,
    footer,
}: PropsWithChildren<{
    header: string
    footer?: { href: string; text?: string; label: string }
}>) {
    const { steps } = usePage<AppPageProps<{ steps?: WizardStep[] }>>().props

    return (
        <BaseLayout>
            {steps && (
                <nav
                    aria-label="Wizard Progress"
                    className="fixed inset-y-0 left-0 md:inset-y-auto md:top-0 md:inset-x-2 flex items-center
                        md:items-stretch"
                >
                    <ol
                        role="list"
                        className="flex flex-col md:flex-1 md:flex-row gap-4 justify-between md:space-y-0 w-full
                            max-w-8 min-[400px]:max-w-24 md:max-w-none"
                    >
                        {steps.map((step) => (
                            <li key={step.name} className="md:flex-1 min-w-0">
                                <WizardProgressStep
                                    step={step}
                                    state={
                                        step.upcoming
                                            ? 'upcoming'
                                            : step.upcoming === null
                                              ? 'active'
                                              : 'completed'
                                    }
                                />
                            </li>
                        ))}
                    </ol>
                </nav>
            )}
            <div
                className="fixed left-8 min-[400px]:left-24 right-0 top-[min(20vh,256px)] px-4 md:left-1/2
                    md:right-auto md:-translate-x-1/2 md:w-full md:max-w-xl"
            >
                <FormStack header={header} footer={footer}>
                    {children}
                </FormStack>
            </div>
        </BaseLayout>
    )
}
