import { Head, Link } from '@inertiajs/react'
import CreateOrganisationForm from './Partials/CreateOrganisationForm'
import FlowLayout from '@/Layouts/FlowLayout'
import OrganisationApplication = App.Models.OrganisationApplication
import useTranslate from '@/shared/hooks/useTranslate'

export default function Create({
    centralDomain,
    step,
    application,
}: AppPageProps<{
    step: OrganisationApplicationSteps
    application: Partial<OrganisationApplication>
}>) {
    const __ = useTranslate()
    return (
        <FlowLayout header="Create Organisation">
            <Head title="Create an Organisation Application" />

            <CreateOrganisationForm
                domain={centralDomain}
                step={step}
                application={application}
            />

            {step > 1 && application.id && (
                <Link
                    href={route('organisations.applications.create.step', {
                        application: application.id,
                        step: step - 1,
                    })}
                >
                    {__('general.button.go_back')}
                </Link>
            )}
        </FlowLayout>
    )
}
