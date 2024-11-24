import { Head } from '@inertiajs/react'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout'
import useTranslate from '@/shared/hooks/useTranslate'
import PageHeader from '@/Components/Layout/PageHeader'
import { badgeColor, badgeLabelKey } from './Lib/OrganisationApplication.util'
import actionButtons from './Lib/Show.buttons'
import CreateOrganisationFormStep1 from '@/Pages/Organisation/Application/Partials/CreateOrganisationFormStep1'
import Application = App.Models.OrganisationApplication
import { Button } from '@/Components/_Base/Button'
import { useState } from 'react'

export default function Show({
    application,
}: AppPageProps<{ application: Application }>) {
    const __ = useTranslate()

    const [step1ReadOnly, setStep1ReadOnly] = useState(true)

    const isEditing = !step1ReadOnly

    return (
        <AuthenticatedLayout
            header={
                <PageHeader
                    title={application.name}
                    badge={{
                        color: badgeColor(application),
                        label: __(badgeLabelKey(application)),
                    }}
                    actionButtons={isEditing ? [] : actionButtons(application)}
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
                        <CreateOrganisationFormStep1
                            className="mt-4"
                            application={application}
                            submitLabel={[
                                'general.button.save',
                                { resource: '' },
                            ]}
                            onSuccess={() => setStep1ReadOnly(true)}
                            onCancel={() => setStep1ReadOnly(true)}
                            routeParams={{
                                redirect: route(
                                    'organisations.applications.show',
                                    {
                                        application: application.id,
                                    },
                                    false,
                                ),
                            }}
                            readonly={step1ReadOnly}
                        />
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    )
}
