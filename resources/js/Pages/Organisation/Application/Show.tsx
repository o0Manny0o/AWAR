import { Head } from '@inertiajs/react'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout'
import useTranslate from '@/shared/hooks/useTranslate'
import PageHeader, { PageHeaderButton } from '@/Components/Layout/PageHeader'
import Application = App.Models.OrganisationApplication
import { Badge } from '@/Components/_Base/Badge'
import { badgeColor } from '@/Pages/Organisation/Application/util'

export default function Show({
    application,
}: AppPageProps<{ application: Application }>) {
    const __ = useTranslate()

    const actionButtons = (): PageHeaderButton[] => {
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

    return (
        <AuthenticatedLayout
            header={
                <PageHeader
                    title={application.name}
                    subtitle={
                        <Badge color={badgeColor(application)}>
                            {application.status}
                        </Badge>
                    }
                    actionButtons={actionButtons()}
                />
            }
        >
            <Head title="Organisation Applications" />

            <div className="py-12">
                <div className="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                    <div className="bg-ceiling p-4 shadow sm:rounded-lg sm:p-8">
                        <h3>General</h3>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    )
}
