import { WizardLayout } from '@/Pages/SelfDisclosure/Wizard/Layouts/WizardLayout'
import useTranslate from '@/shared/hooks/useTranslate'
import { Head } from '@inertiajs/react'
import { Button } from '@/Components/_Base/Button'

export default function Complete({}: AppPageProps) {
    const __ = useTranslate()

    return (
        <WizardLayout header={__('self_disclosure.wizard.headers.complete')}>
            <Head title={__('self_disclosure.wizard.headers.complete')} />
            <div className="space-y-8 text-center">
                <p>{__('self_disclosure.wizard.complete.thank_you')}</p>
                <p className="text-sm">
                    {__('self_disclosure.wizard.complete.changes')}
                </p>
                <p>
                    <Button color="secondary" href={route('dashboard')}>
                        {__('self_disclosure.wizard.complete.return_home')}
                    </Button>
                </p>
            </div>
        </WizardLayout>
    )
}
