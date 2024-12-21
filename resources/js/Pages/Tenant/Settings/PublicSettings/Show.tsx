import { Head, Link } from '@inertiajs/react'
import useTranslate from '@/shared/hooks/useTranslate'
import { SettingsLayout } from '@/Layouts/SettingsLayout'
import { ShowActionButtons } from '@/Pages/Tenant/Settings/PublicSettings/Lib/PublicSettings.buttons'
import { Card } from '@/Components/Layout/Card'
import ShowGroup from '@/Components/_Base/Input/ShowGroup'
import { ImagePreview } from '@/Components/_Base/Input/Images/ImagePreview'
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

            <div className="space-y-6">
                <Card>
                    <ShowGroup
                        name={'name'}
                        label={__(
                            'organisations.settings.public.form.name.label',
                        )}
                        value={settings.name}
                    />
                </Card>

                <Card>
                    <div className="flex justify-between">
                        <h3>Favicon</h3>
                        <Link href={route('settings.favicon.edit')}>Edit</Link>
                    </div>
                    <ImagePreview id={'favicon'} file={settings.favicon} />
                </Card>
            </div>
        </SettingsLayout>
    )
}
