import { Head } from '@inertiajs/react'
import useTranslate from '@/shared/hooks/useTranslate'
import { FormContextProvider } from '@/shared/contexts/Form.context'
import { LocationFormWrapper } from '@/Pages/Tenant/Settings/Location/Lib/Location.context'
import { SettingsLayout } from '@/Layouts/SettingsLayout'
import { FormActionButtons } from '@/Pages/Tenant/Settings/Location/Lib/Location.buttons'
import UpdateLocationForm from '@/Pages/Tenant/Settings/Location/Partials/UpdateLocationForm'
import { Card } from '@/Components/Layout/Card'
import Location = App.Models.Location

export default function Edit({
    location,
}: AppPageProps<{ location: Location }>) {
    const __ = useTranslate()
    const FORM_ID = 'edit-location'

    return (
        <FormContextProvider context={LocationFormWrapper}>
            <SettingsLayout
                title={__('organisations.locations.headers.update', {
                    name: location.name,
                })}
                actionButtons={FormActionButtons(
                    route('settings.locations.update', location.id),
                    FORM_ID,
                )}
            >
                <Head title={__('organisations.locations.titles.update')} />

                <Card>
                    <UpdateLocationForm formId={FORM_ID} location={location} />
                </Card>
            </SettingsLayout>
        </FormContextProvider>
    )
}
