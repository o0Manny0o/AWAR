import { Head } from '@inertiajs/react'
import FlowLayout from '@/Layouts/FlowLayout'
import useTranslate from '@/shared/hooks/useTranslate'
import { ElementRefProvider } from '@/shared/contexts/ElementRef.context'
import { FormInputRefs } from '@/Pages/Tenant/Organisation/Invitation/Lib/OrganisationInvitation.context'
import CreateInvitationForm from '@/Pages/Tenant/Organisation/Invitation/Partials/CreateInvitationForm'

export default function Create(props: AppPageProps) {
    const __ = useTranslate()

    return (
        <FlowLayout header="Create Organisation">
            <Head title="Create an Organisation Application" />

            <ElementRefProvider context={FormInputRefs}>
                <CreateInvitationForm />
            </ElementRefProvider>
        </FlowLayout>
    )
}
