import CreateOrganisationFormStep1 from './CreateOrganisationFormStep1'
import CreateOrganisationFormStep2 from './CreateOrganisationFormStep2'
import CreateOrganisationFormStep3 from './CreateOrganisationFormStep3'

export default function CreateOrganisationForm({
    domain,
    step,
    application,
}: {
    className?: string
    step: number
    application?: { id: string }
    domain: string
}) {
    const renderStep = () => {
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
        }
    }

    return renderStep()
}
