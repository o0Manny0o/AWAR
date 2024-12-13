import { Head } from '@inertiajs/react'
import useTranslate from '@/shared/hooks/useTranslate'
import { Card } from '@/Components/Layout/Card'
import List from '@/Components/Resource/List'
import { SettingsLayout } from '@/Layouts/SettingsLayout'
import { IndexActionButtons } from '@/Pages/Tenant/Settings/Location/Lib/Location.buttons'

export default function Index({
    locations,
}: AppPageProps<{ locations: any[] }>) {
    const __ = useTranslate()

    console.log(locations)

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
                        title={(i) => i.name}
                        subtitle={(e) => e.email}
                        secondarySubtitle={(e) => e.roles}
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
