import { Head } from '@inertiajs/react'
import { EditActionButtons } from '@/Pages/Settings/Application/Lib/OrganisationApplication.buttons'
import EditOrganisationForm from '@/Pages/Settings/Application/Partials/EditOrganisationForm'
import { FormContextProvider } from '@/shared/contexts/Form.context'
import { ApplicationFormWrapper } from '@/Pages/Settings/Application/Lib/OrganisationApplication.context'
import { SettingsLayout } from '@/Layouts/SettingsLayout'
import OrganisationApplicationDraft = App.Models.OrganisationApplicationDraft

export default function Edit({
    centralDomain,
    application,
}: AppPageProps<{ step: number; application: OrganisationApplicationDraft }>) {
    const FORM_ID = 'edit-organisation-form'

    return (
        <FormContextProvider context={ApplicationFormWrapper}>
            <SettingsLayout
                title={application.name!}
                actionButtons={EditActionButtons(application, FORM_ID)}
            >
                <Head title="Organisation Applications" />

                <EditOrganisationForm
                    formId={FORM_ID}
                    application={application}
                    domain={centralDomain}
                />
            </SettingsLayout>
        </FormContextProvider>
    )
}
