import { Head } from '@inertiajs/react'
import FlowLayout from '@/Layouts/FlowLayout'
import useTranslate from '@/shared/hooks/useTranslate'
import { FormContextProvider } from '@/shared/contexts/Form.context'
import { FormInputRefs } from '@/Pages/Tenant/Settings/Invitation/Lib/OrganisationInvitation.context'
import CreateInvitationForm from '@/Pages/Tenant/Settings/Invitation/Partials/CreateInvitationForm'

export default function Create({
    roleOptions,
}: AppPageProps<{ roleOptions: { [id: number]: string } }>) {
    const __ = useTranslate()

    return (
        <FlowLayout
            header={__('organisations.invitations.headers.create')}
            footer={{
                text: __('organisations.invitations.form.cancel_create'),
                label: __('general.button.go_back'),
                href: route('settings.invitations.index'),
            }}
        >
            <Head title={__('organisations.invitations.titles.create')} />

            <FormContextProvider context={FormInputRefs}>
                <CreateInvitationForm
                    roleOptions={Object.entries(roleOptions).map(
                        ([id, name]) => ({ id, name }),
                    )}
                />
            </FormContextProvider>
        </FlowLayout>
    )
}
