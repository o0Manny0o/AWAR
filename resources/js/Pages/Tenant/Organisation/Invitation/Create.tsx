import { Head } from '@inertiajs/react'
import FlowLayout from '@/Layouts/FlowLayout'
import useTranslate from '@/shared/hooks/useTranslate'
import { ElementRefProvider } from '@/shared/contexts/ElementRef.context'
import { FormInputRefs } from '@/Pages/Tenant/Organisation/Invitation/Lib/OrganisationInvitation.context'
import CreateInvitationForm from '@/Pages/Tenant/Organisation/Invitation/Partials/CreateInvitationForm'

export default function Create({
    roleOptions,
}: AppPageProps<{ roleOptions: { [id: number]: string } }>) {
    const __ = useTranslate()

    console.log(roleOptions)

    return (
        <FlowLayout
            header={__('organisations.invitations.headers.create')}
            footer={{
                text: __('organisations.invitations.form.cancel_create'),
                label: __('general.button.go_back'),
                href: route('organisation.invitations.index'),
            }}
        >
            <Head title={__('organisations.invitations.titles.create')} />

            <ElementRefProvider context={FormInputRefs}>
                <CreateInvitationForm
                    roleOptions={Object.entries(roleOptions).map(
                        ([id, name]) => ({ id, name }),
                    )}
                />
            </ElementRefProvider>
        </FlowLayout>
    )
}
