import { PageHeaderButton } from '@/Components/Layout/PageHeader'
import useTranslate from '@/shared/hooks/useTranslate'
import usePermission from '@/shared/hooks/usePermission'
import OrganisationApplication = App.Models.OrganisationApplication
import OrganisationInvitation = App.Models.OrganisationInvitation

export function ShowActionButtons(
    invitation: OrganisationInvitation,
): PageHeaderButton[] {
    const __ = useTranslate()
    const { can } = usePermission()

    const DELETE_BUTTON: PageHeaderButton = {
        label: __('general.button.delete', {
            resource: '',
        }),
        variant: 'danger',
        method: 'delete',
        href: route('organisations.applications.destroy', {
            application: invitation.id,
        }),
    }

    const EDIT_BUTTON: PageHeaderButton = {
        label: __('general.button.edit', {
            resource: '',
        }),
        variant: 'primary',
        href: route('organisations.applications.edit', {
            application: invitation.id,
        }),
    }

    if (invitation.accepted_at) {
        return []
    }
    return [
        ...(can('organisations.applications.update') ? [EDIT_BUTTON] : []),
        ...(can('organisations.applications.delete') ? [DELETE_BUTTON] : []),
    ]
}

export function EditActionButtons(
    application: Pick<OrganisationApplication, 'id'>,
    formId: string,
): PageHeaderButton[] {
    const __ = useTranslate()

    const SAVE_BUTTON: PageHeaderButton = {
        label: __('general.button.save', {
            resource: '',
        }),
        variant: 'primary',
        form: formId,
    }

    const CANCEL_BUTTON: PageHeaderButton = {
        label: __('general.button.cancel', {
            resource: '',
        }),
        variant: 'secondary',
        href: route('organisations.applications.show', {
            application: application.id,
        }),
    }

    return [SAVE_BUTTON, CANCEL_BUTTON]
}
