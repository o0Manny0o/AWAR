import { Head } from '@inertiajs/react'
import useTranslate from '@/shared/hooks/useTranslate'
import {
    badgeColor,
    badgeLabelKey,
} from '@/Pages/Settings/Application/Lib/OrganisationApplication.util'
import { ShowActionButtons } from '@/Pages/Settings/Application/Lib/OrganisationApplication.buttons'
import { Card } from '@/Components/Layout/Card'
import {
    AddressInfoShowGroup,
    GeneralInfoShowGroup,
    SubdomainInfoShowGroup,
} from '@/Pages/Settings/Application/Lib/OrganisationApplication.components'
import { SettingsLayout } from '@/Layouts/SettingsLayout'
import Application = App.Models.OrganisationApplication

export default function Show({
    application,
}: AppPageProps<{ application: Application }>) {
    const __ = useTranslate()

    return (
        <SettingsLayout
            title={application.name}
            badge={{
                color: badgeColor(application),
                label: __(badgeLabelKey(application)),
            }}
            actionButtons={ShowActionButtons(application)}
            backUrl={route('settings.applications.index')}
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
        </SettingsLayout>
    )
}
