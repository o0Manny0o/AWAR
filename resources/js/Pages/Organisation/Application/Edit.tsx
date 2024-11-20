import { Head, Link } from '@inertiajs/react'
import CreateOrganisationForm from './Partials/CreateOrganisationForm'
import FlowLayout from '@/Layouts/FlowLayout'

export default function Edit({
    centralDomain,
    step,
    application,
}: AppPageProps<{ step: number; application: { id: string } }>) {
    return (
        <FlowLayout header="Organisation Details">
            <Head title="Create an Organisation Application" />

            <CreateOrganisationForm
                domain={centralDomain}
                step={step}
                application={application}
            />

            {step > 1 && (
                <Link
                    href={route('organisations.applications.edit', {
                        application: application.id,
                        step: step - 1,
                    })}
                >
                    Go back
                </Link>
            )}
        </FlowLayout>
    )
}
