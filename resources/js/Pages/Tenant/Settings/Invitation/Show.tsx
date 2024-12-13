import { Head } from '@inertiajs/react'
import useTranslate, { toTranslationKey } from '@/shared/hooks/useTranslate'
import { Card } from '@/Components/Layout/Card'
import {
    badgeColor,
    badgeLabelKey,
} from '@/Pages/Tenant/Settings/Invitation/Lib/OrganisationInvitation.util'
import ShowGroup from '@/Components/_Base/Input/ShowGroup'
import { ShowActionButtons } from '@/Pages/Tenant/Settings/Invitation/Lib/OrganisationInvitation.buttons'
import { SettingsLayout } from '@/Layouts/SettingsLayout'
import OrganisationInvitation = App.Models.OrganisationInvitation

export default function Show({
    invitation,
}: AppPageProps<{ invitation: OrganisationInvitation }>) {
    const __ = useTranslate()

    return (
        <SettingsLayout
            title={invitation.email}
            badge={{
                color: badgeColor(invitation),
                label: __(badgeLabelKey(invitation)),
            }}
            actionButtons={ShowActionButtons(invitation)}
            backUrl={route('settings.invitations.index')}
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
        </SettingsLayout>
    )
}
