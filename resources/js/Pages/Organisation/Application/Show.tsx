import { Head } from '@inertiajs/react'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout'
import useTranslate from '@/shared/hooks/useTranslate'
import PageHeader from '@/Components/Layout/PageHeader'
import { badgeColor, badgeLabelKey } from './Lib/OrganisationApplication.util'
import { ShowActionButtons } from './Lib/OragnisationApplication.buttons'
import Application = App.Models.OrganisationApplication

export default function Show({
    application,
}: AppPageProps<{ application: Application }>) {
    const __ = useTranslate()

    return (
        <AuthenticatedLayout
            header={
                <PageHeader
                    title={application.name}
                    badge={{
                        color: badgeColor(application),
                        label: __(badgeLabelKey(application)),
                    }}
                    actionButtons={ShowActionButtons(application)}
                    backUrl={route('organisations.applications.index')}
                />
            }
        >
            <Head title="Organisation Applications" />

            <div className="py-12">
                <div className="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                    <div className="bg-ceiling p-4 shadow sm:rounded-lg sm:p-8">
                        <h3>
                            {__('organisations.applications.form.general_info')}
                        </h3>

                        {/* TODO: Display */}
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    )
}
