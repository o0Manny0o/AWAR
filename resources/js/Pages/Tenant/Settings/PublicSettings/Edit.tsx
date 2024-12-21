import { Head } from '@inertiajs/react'
import useTranslate from '@/shared/hooks/useTranslate'
import { FormContextProvider } from '@/shared/contexts/Form.context'
import { SettingsLayout } from '@/Layouts/SettingsLayout'
import { FormActionButtons } from '@/Pages/Tenant/Settings/PublicSettings/Lib/PublicSettings.buttons'
import { Card } from '@/Components/Layout/Card'
import { OrganisationPublicSettingsFormWrapper } from '@/Pages/Tenant/Settings/PublicSettings/Lib/PublicSettings.context'
import UpdateOrganisationPublicSettingsForm from '@/Pages/Tenant/Settings/PublicSettings/Partials/UpdatePublicSettingsForm'
import PublicSettings = App.Models.Organisation.PublicSettings

export default function Edit({
    settings,
}: AppPageProps<{ settings: PublicSettings }>) {
    const __ = useTranslate()
    const FORM_ID = 'edit-organisation-public-settings'

    return (
        <FormContextProvider context={OrganisationPublicSettingsFormWrapper}>
            <SettingsLayout
                title={__('organisations.settings.public.headers.update')}
                actionButtons={FormActionButtons(
                    route('settings.public.show'),
                    FORM_ID,
                )}
            >
                <Head
                    title={__('organisations.settings.public.titles.update')}
                />

                <Card>
                    <UpdateOrganisationPublicSettingsForm
                        formId={FORM_ID}
                        settings={settings}
                    />
                </Card>
            </SettingsLayout>
        </FormContextProvider>
    )
}
