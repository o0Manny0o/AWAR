import { Head } from '@inertiajs/react'
import useTranslate from '@/shared/hooks/useTranslate'
import {
    badgeColor,
    badgeLabelKey,
} from '@/Pages/Tenant/Settings/Location/Lib/Location.util'
import { SettingsLayout } from '@/Layouts/SettingsLayout'
import { Card } from '@/Components/Layout/Card'
import ShowGroup from '@/Components/_Base/Input/ShowGroup'
import { ShowActionButtons } from '@/Pages/Tenant/Settings/Location/Lib/Location.buttons'
import Location = App.Models.Location

export default function Show({
    location,
}: AppPageProps<{ location: Location }>) {
    const __ = useTranslate()

    return (
        <SettingsLayout
            title={location.name}
            actionButtons={ShowActionButtons(
                location,
                'general.resources.organisation.location',
                'settings.locations',
            )}
            badge={{
                color: badgeColor(location),
                label: __(badgeLabelKey(location)),
            }}
            backUrl={route('settings.locations.index')}
        >
            <Head title={`${location.name}`} />

            <div className="space-y-6">
                <Card header="Address">
                    <ShowGroup
                        name={'street_address'}
                        label="Street Address"
                        value={location.address.street_address}
                    />
                    <ShowGroup
                        name={'postal_code'}
                        label="Postal Code"
                        value={location.address.postal_code}
                    />
                    <ShowGroup
                        name={'locality'}
                        label="City"
                        value={location.address.locality}
                    />
                    <ShowGroup
                        name={'region'}
                        label="Region"
                        value={location.address.region}
                    />
                    <ShowGroup
                        name={'Country'}
                        label="Country"
                        value={location.address.country.name}
                    />
                </Card>
            </div>
        </SettingsLayout>
    )
}
