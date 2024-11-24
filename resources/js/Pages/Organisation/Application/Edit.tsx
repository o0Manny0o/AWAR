import { Head } from '@inertiajs/react'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout'
import PageHeader from '@/Components/Layout/PageHeader'
import { EditActionButtons } from '@/Pages/Organisation/Application/Lib/OragnisationApplication.buttons'
import EditOrganisationForm from '@/Pages/Organisation/Application/Partials/EditOrganisationForm'
import OrganisationApplicationDraft = App.Models.OrganisationApplicationDraft

export default function Edit({
    centralDomain,
    application,
}: AppPageProps<{ step: number; application: OrganisationApplicationDraft }>) {
    const FORM_ID = 'edit-organisation-form'

    return (
        <AuthenticatedLayout
            header={
                <PageHeader
                    title={application.name!}
                    actionButtons={EditActionButtons(application, FORM_ID)}
                />
            }
        >
            <Head title="Organisation Applications" />

            <EditOrganisationForm
                formId={FORM_ID}
                application={application}
                domain={centralDomain}
            />
        </AuthenticatedLayout>
    )
}
