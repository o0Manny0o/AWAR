import { WizardLayout } from '@/Pages/SelfDisclosure/Wizard/Layouts/WizardLayout'
import useTranslate from '@/shared/hooks/useTranslate'
import { FormContextProvider } from '@/shared/contexts/Form.context'
import { ExperienceFormWrapper } from '@/Pages/SelfDisclosure/Wizard/Lib/Wizard.context'
import { ExperienceForm } from '@/Pages/SelfDisclosure/Wizard/Partials/ExperienceForm'

export default function Edit({
    experience,
}: AppPageProps<{ experience?: any }>) {
    const __ = useTranslate()

    const header: TranslationKey = experience
        ? 'self_disclosure.wizard.headers.experience.edit'
        : 'self_disclosure.wizard.headers.experience.create'

    return (
        <WizardLayout header={__(header)}>
            <FormContextProvider context={ExperienceFormWrapper}>
                <ExperienceForm experience={experience} />
            </FormContextProvider>
        </WizardLayout>
    )
}
