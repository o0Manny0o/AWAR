import { Head } from '@inertiajs/react'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout'
import useTranslate from '@/shared/hooks/useTranslate'
import { badgeColor, badgeLabelKey } from './Lib/OrganisationApplication.util'
import { ShowActionButtons } from './Lib/OragnisationApplication.buttons'
import { Card } from '@/Components/Layout/Card'
import {
    AddressInfoShowGroup,
    GeneralInfoShowGroup,
    SubdomainInfoShowGroup,
} from '@/Pages/Organisation/Application/Lib/OrganisationApplication.components'
import Application = App.Models.OrganisationApplication

export default function Show({
    application,
}: AppPageProps<{ application: Application }>) {
    const __ = useTranslate()

    return (
        <AuthenticatedLayout
            title={application.name}
            badge={{
                color: badgeColor(application),
                label: __(badgeLabelKey(application)),
            }}
            actionButtons={ShowActionButtons(application)}
            backUrl={route('organisations.applications.index')}
        >
            <Head title={`${application.name} Application`} />

            <div className="space-y-6">
                <Card
                    header={__('organisations.applications.form.general_info')}
                >
                    <GeneralInfoShowGroup application={application} />
                </Card>
                <Card
                    header={__('organisations.applications.form.address_info')}
                >
                    <AddressInfoShowGroup application={application} />
                </Card>
                <Card
                    header={__(
                        'organisations.applications.form.subdomain_info',
                    )}
                >
                    <SubdomainInfoShowGroup application={application} />
                </Card>
            </div>
        </AuthenticatedLayout>
    )
}
