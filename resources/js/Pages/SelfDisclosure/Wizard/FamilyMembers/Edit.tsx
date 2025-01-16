import { WizardLayout } from '@/Pages/SelfDisclosure/Wizard/Layouts/WizardLayout'
import useTranslate from '@/shared/hooks/useTranslate'
import { FormContextProvider } from '@/shared/contexts/Form.context'
import { FamilyMemberFormWrapper } from '@/Pages/SelfDisclosure/Wizard/Lib/Wizard.context'
import { FamilyMemberForm } from '@/Pages/SelfDisclosure/Wizard/Partials/FamilyMemberForm'

export default function Edit({ member }: AppPageProps<{ member?: any }>) {
    const __ = useTranslate()

    const header: TranslationKey = member
        ? 'self_disclosure.wizard.headers.family_member.edit'
        : 'self_disclosure.wizard.headers.family_member.create'

    return (
        <WizardLayout header={__(header)}>
            <FormContextProvider context={FamilyMemberFormWrapper}>
                <FamilyMemberForm member={member} />
            </FormContextProvider>
        </WizardLayout>
    )
}
