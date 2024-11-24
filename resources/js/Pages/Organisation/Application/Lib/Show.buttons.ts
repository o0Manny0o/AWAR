import { PageHeaderButton } from '@/Components/Layout/PageHeader'
import OrganisationApplication = App.Models.OrganisationApplication
import useTranslate from '@/shared/hooks/useTranslate'

export default function ShowActionButtons(
    application: OrganisationApplication,
): PageHeaderButton[] {
    const __ = useTranslate()

    if (application.is_locked) {
        return []
    }
    if (application.deleted_at) {
        return [
            {
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
            },
        ]
    }
    if (application.is_complete) {
        return [
            {
                label: __('general.button.submit', {
                    resource: '',
                }),
                variant: 'primary',
                method: 'patch',
                href: route('organisations.applications.submit', {
                    application: application.id,
                }),
            },
            {
                label: __('general.button.delete', {
                    resource: '',
                }),
                variant: 'danger',
                method: 'delete',
                href: route('organisations.applications.destroy', {
                    application: application.id,
                }),
            },
        ]
    }
    return []
}
