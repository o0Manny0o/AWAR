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
                        className="flex flex-col md:flex-1 md:flex-row max-h-[450px] h-screen md:gap-4 md:h-auto
                            justify-between md:space-y-0 w-full max-w-8 min-[400px]:max-w-24 md:max-w-none"
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
                className="fixed left-8 bottom-0 min-[400px]:left-24 right-0 top-0 md:top-10 px-4
                    md:left-1/2 md:right-auto md:-translate-x-1/2 md:w-full md:max-w-xl flex
                    flex-col"
            >
                <div className="max-h-56 flex-1"></div>
                <FormStack
                    header={header}
                    footer={footer}
                    className="py-8 flex-grow h-auto min-h-96"
                >
                    {children}
                </FormStack>
            </div>
        </BaseLayout>
    )
}
