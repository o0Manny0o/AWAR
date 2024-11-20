import { Head } from '@inertiajs/react'
import CreateOrganisationForm from './Partials/CreateOrganisationForm'
import FlowLayout from '@/Layouts/FlowLayout'

export default function Create({
    centralDomain,
}: AppPageProps) {
    return (
        <FlowLayout header="Create Organisation">
            <Head title="Create an Organisation Application" />

            <CreateOrganisationForm domain={centralDomain} step={1} />
        </FlowLayout>
    )
}
