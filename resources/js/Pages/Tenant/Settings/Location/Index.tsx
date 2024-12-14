import { Head } from '@inertiajs/react'
import useTranslate from '@/shared/hooks/useTranslate'
import { Card } from '@/Components/Layout/Card'
import List from '@/Components/Resource/List'
import { SettingsLayout } from '@/Layouts/SettingsLayout'
import { IndexActionButtons } from '@/Pages/Tenant/Settings/Location/Lib/Location.buttons'
import { Badge } from '@/Components/_Base/Badge'
import {
    badgeColor,
    badgeLabelKey,
} from '@/Pages/Tenant/Settings/Location/Lib/Location.util'
import Location = App.Models.Location

export default function Index({
    locations,
}: AppPageProps<{ locations: Location[] }>) {
    const __ = useTranslate()

    return (
        <SettingsLayout
            title={__('organisations.locations.headers.index')}
            actionButtons={IndexActionButtons(
                'general.resources.organisation.location',
                'settings.locations.create',
            )}
        >
            <Head title={__('organisations.locations.titles.index')} />

            <div className="">
                <Card>
                    <List
                        entities={locations}
                        title={(l) => l.name}
                        subtitle={(l) =>
                            `${l.address.street_address}, ${l.address.postal_code} ${l.address.locality}, ${l.address.region ?? ''} ${l.address.country.name}`
                        }
                        badge={(l) => (
                            <Badge color={badgeColor(l)}>
                                {__(badgeLabelKey(l))}
                            </Badge>
                        )}
                        resourceUrl={'settings.locations'}
                        resourceLabel={
                            'general.resources.organisation.location'
                        }
                    />
                </Card>
            </div>
        </SettingsLayout>
    )
}
