import CreateOrganisationFormStep1 from './CreateOrganisationFormStep1'
import CreateOrganisationFormStep2 from './CreateOrganisationFormStep2'
import CreateOrganisationFormStep3 from './CreateOrganisationFormStep3'
import { FormContextProvider } from '@/shared/contexts/Form.context'
import { ApplicationFormWrapper } from '@/Pages/Organisation/Application/Lib/OrganisationApplication.context'
import OrganisationApplicationDraft = App.Models.OrganisationApplicationDraft

export default function CreateOrganisationForm({
    domain,
    step,
    application,
}: {
    step: OrganisationApplicationSteps
    application?: OrganisationApplicationDraft
    domain: string
}) {
    const renderStep = () => {
        if (!application) {
            return <CreateOrganisationFormStep1 />
        }
        switch (String(step)) {
            case '1':
                return <CreateOrganisationFormStep1 application={application} />
            case '2':
                return <CreateOrganisationFormStep2 application={application} />
            case '3':
                return (
                    <CreateOrganisationFormStep3
                        application={application}
                        domain={domain}
                    />
                )
            default:
                return <CreateOrganisationFormStep1 />
        }
    }

    return (
        <FormContextProvider context={ApplicationFormWrapper}>
            {renderStep()}
        </FormContextProvider>
    )
}
