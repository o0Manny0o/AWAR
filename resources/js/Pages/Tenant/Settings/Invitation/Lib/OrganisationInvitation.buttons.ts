import { PageHeaderButton } from '@/Components/Layout/PageHeader'
import useTranslate from '@/shared/hooks/useTranslate'
import usePermission from '@/shared/hooks/usePermission'
import OrganisationInvitation = App.Models.OrganisationInvitation

export function ShowActionButtons(
    invitation: OrganisationInvitation,
): PageHeaderButton[] {
    const __ = useTranslate()
    const { canResend } = usePermission()

    const RESEND_BUTTON: PageHeaderButton = {
        label: __('general.button.resend', {
            resource: '',
        }),
        variant: 'primary',
        method: 'post',
        href: route('settings.invitations.resend', {
            id: invitation.id,
            redirect: route('settings.invitations.show', invitation.id),
        }),
    }

    if (invitation.accepted_at) {
        return []
    }

    console.log(canResend(invitation))

    if (canResend(invitation)) {
        return [RESEND_BUTTON]
    }
    return []
}
