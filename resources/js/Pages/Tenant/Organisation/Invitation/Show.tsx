import { Head } from '@inertiajs/react'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout'
import useTranslate, { toTranslationKey } from '@/shared/hooks/useTranslate'
import PageHeader from '@/Components/Layout/PageHeader'
import { Card } from '@/Components/Layout/Card'
import { badgeColor, badgeLabelKey } from './Lib/OrganisationInvitation.util'
import ShowGroup from '@/Components/_Base/Input/ShowGroup'
import { ShowActionButtons } from './Lib/OrganisationInvitation.buttons'
import OrganisationInvitation = App.Models.OrganisationInvitation

export default function Show({
    invitation,
}: AppPageProps<{ invitation: OrganisationInvitation }>) {
    const __ = useTranslate()

    return (
        <AuthenticatedLayout
            header={
                <PageHeader
                    title={invitation.email}
                    badge={{
                        color: badgeColor(invitation),
                        label: __(badgeLabelKey(invitation)),
                    }}
                    actionButtons={ShowActionButtons(invitation)}
                    backUrl={route('organisation.invitations.index')}
                />
            }
        >
            <Head title={`Invitation ${invitation.email}`} />

            <Card>
                <ShowGroup
                    name="token"
                    label={__('organisations.invitations.form.token.label')}
                    value={invitation.token}
                />
                <ShowGroup
                    name="role"
                    label={__('organisations.invitations.form.role.label')}
                    value={__(
                        toTranslationKey(
                            'general.roles.tenant.' + invitation.role.name,
                        ),
                    )}
                />
            </Card>
        </AuthenticatedLayout>
    )
}
