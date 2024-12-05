import { Head } from '@inertiajs/react'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout'
import { EditActionButtons } from '@/Pages/Organisation/Application/Lib/OragnisationApplication.buttons'
import EditOrganisationForm from '@/Pages/Organisation/Application/Partials/EditOrganisationForm'
import { FormContextProvider } from '@/shared/contexts/Form.context'
import { ApplicationFormWrapper } from '@/Pages/Organisation/Application/Lib/OrganisationApplication.context'
import OrganisationApplicationDraft = App.Models.OrganisationApplicationDraft

export default function Edit({
    centralDomain,
    application,
}: AppPageProps<{ step: number; application: OrganisationApplicationDraft }>) {
    const FORM_ID = 'edit-organisation-form'

    return (
        <FormContextProvider context={ApplicationFormWrapper}>
            <AuthenticatedLayout
                title={application.name!}
                actionButtons={EditActionButtons(application, FORM_ID)}
            >
                <Head title="Organisation Applications" />

                <EditOrganisationForm
                    formId={FORM_ID}
                    application={application}
                    domain={centralDomain}
                />
            </AuthenticatedLayout>
        </FormContextProvider>
    )
}
