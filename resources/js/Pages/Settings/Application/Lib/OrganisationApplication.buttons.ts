import { PageHeaderButton } from '@/Components/Layout/PageHeader'
import useTranslate from '@/shared/hooks/useTranslate'
import usePermission from '@/shared/hooks/usePermission'
import OrganisationApplication = App.Models.OrganisationApplication

export function ShowActionButtons(
    application: OrganisationApplication,
): PageHeaderButton[] {
    const __ = useTranslate()
    const { can } = usePermission()

    const RESTORE_BUTTON: PageHeaderButton = {
        label: __('general.button.restore', {
            resource: '',
        }),
        variant: 'primary',
        method: 'patch',
        href: route('settings.applications.restore', {
            application: application.id,
            redirect: route(
                'settings.applications.show',
                {
                    application: application.id,
                },
                false,
            ),
        }),
    }

    const DELETE_BUTTON: PageHeaderButton = {
        label: __('general.button.delete', {
            resource: '',
        }),
        variant: 'danger',
        method: 'delete',
        href: route('settings.applications.destroy', {
            application: application.id,
        }),
    }

    const SUBMIT_BUTTON: PageHeaderButton = {
        label: __('general.button.submit', {
            resource: '',
        }),
        variant: 'primary',
        method: 'patch',
        href: route('settings.applications.submit', {
            application: application.id,
        }),
    }

    const editButton = (primary: boolean): PageHeaderButton => ({
        label: __('general.button.edit', {
            resource: '',
        }),
        variant: primary ? 'primary' : 'secondary',
        href: route('settings.applications.edit', {
            application: application.id,
        }),
    })

    if (application.is_locked) {
        return []
    }
    if (application.deleted_at) {
        if (can('organisations.applications.restore')) {
            return [RESTORE_BUTTON]
        }
        return []
    }
    if (application.is_complete) {
        return [
            ...(can('organisations.applications.submit')
                ? [SUBMIT_BUTTON]
                : []),
            ...(can('organisations.applications.update')
                ? [editButton(false)]
                : []),
            ...(can('organisations.applications.delete')
                ? [DELETE_BUTTON]
                : []),
        ]
    } else {
        return [
            ...(can('organisations.applications.update')
                ? [editButton(true)]
                : []),
            ...(can('organisations.applications.delete')
                ? [DELETE_BUTTON]
                : []),
        ]
    }
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
        href: route('settings.applications.show', {
            application: application.id,
        }),
    }

    return [SAVE_BUTTON, CANCEL_BUTTON]
}
