import { Head } from '@inertiajs/react'
import useTranslate from '@/shared/hooks/useTranslate'
import { SettingsLayout } from '@/Layouts/SettingsLayout'
import { ShowActionButtons } from '@/Pages/Tenant/Settings/PublicSettings/Lib/PublicSettings.buttons'
import { Card } from '@/Components/Layout/Card'
import ShowGroup from '@/Components/_Base/Input/ShowGroup'
import { ImagePreview } from '@/Components/_Base/Input/Images/ImagePreview'
import { Button } from '@/Components/_Base/Button'
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

                <Card header="Branding">
                    <div className="flex gap-8">
                        <div>
                            <div className="flex justify-between items-center py-1">
                                <h3>Logo</h3>
                                <Button
                                    color="secondary"
                                    href={route('settings.logo.edit')}
                                >
                                    Edit
                                </Button>
                            </div>
                            <ImagePreview id={'logo'} file={settings.logo} />
                        </div>
                        <div>
                            <div className="flex justify-between items-center py-1">
                                <h3>Favicon</h3>
                                <Button
                                    color="secondary"
                                    href={route('settings.favicon.edit')}
                                >
                                    Edit
                                </Button>
                            </div>
                            <ImagePreview
                                id={'favicon'}
                                file={settings.favicon}
                            />
                        </div>
                    </div>
                </Card>
            </div>
        </SettingsLayout>
    )
}
