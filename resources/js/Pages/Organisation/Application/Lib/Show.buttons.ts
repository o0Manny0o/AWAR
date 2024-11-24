import { PageHeaderButton } from '@/Components/Layout/PageHeader'
import useTranslate from '@/shared/hooks/useTranslate'
import OrganisationApplication = App.Models.OrganisationApplication

export default function ShowActionButtons(
    application: OrganisationApplication,
): PageHeaderButton[] {
    const __ = useTranslate()

    const RESTORE_BUTTON: PageHeaderButton = {
        label: __('general.button.restore', {
            resource: '',
        }),
        variant: 'primary',
        method: 'patch',
        href: route('organisations.applications.restore', {
            application: application.id,
            redirect: route(
                'organisations.applications.show',
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
        href: route('organisations.applications.destroy', {
            application: application.id,
        }),
    }

    const SUBMIT_BUTTON: PageHeaderButton = {
        label: __('general.button.submit', {
            resource: '',
        }),
        variant: 'primary',
        method: 'patch',
        href: route('organisations.applications.submit', {
            application: application.id,
        }),
    }

    const editButton = (primary: boolean): PageHeaderButton => ({
        label: __('general.button.edit', {
            resource: '',
        }),
        variant: primary ? 'primary' : 'secondary',
        method: 'patch',
        href: route('organisations.applications.edit', {
            application: application.id,
        }),
    })

    if (application.is_locked) {
        return []
    }
    if (application.deleted_at) {
        return [RESTORE_BUTTON]
    }
    if (application.is_complete) {
        return [SUBMIT_BUTTON, editButton(false), DELETE_BUTTON]
    } else {
        return [editButton(true), DELETE_BUTTON]
    }
}
