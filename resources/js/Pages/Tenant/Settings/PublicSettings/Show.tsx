import { Head } from '@inertiajs/react'
import useTranslate from '@/shared/hooks/useTranslate'
import { SettingsLayout } from '@/Layouts/SettingsLayout'
import { ShowActionButtons } from '@/Pages/Tenant/Settings/PublicSettings/Lib/PublicSettings.buttons'
import { Card } from '@/Components/Layout/Card'
import ShowGroup from '@/Components/_Base/Input/ShowGroup'
import PublicSettings = App.Models.Organisation.PublicSettings

export default function Show({
    settings,
}: AppPageProps<{ settings: PublicSettings }>) {
    const __ = useTranslate()

    return (
        <SettingsLayout
            title={__('organisations.settings.public.headers.update')}
            actionButtons={ShowActionButtons(settings, 'settings.public')}
        >
            <Head title={__('organisations.settings.public.titles.update')} />

            <Card>
                <ShowGroup
                    name={'name'}
                    label={__('organisations.settings.public.form.name.label')}
                    value={settings.name}
                />
            </Card>
        </SettingsLayout>
    )
}
