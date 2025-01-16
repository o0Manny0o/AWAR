import { Head, useForm } from '@inertiajs/react'
import useTranslate from '@/shared/hooks/useTranslate'
import { SettingsLayout } from '@/Layouts/SettingsLayout'
import { FormActionButtons } from '@/Pages/Tenant/Settings/PublicSettings/Lib/PublicSettings.buttons'
import { Card } from '@/Components/Layout/Card'
import { FormEventHandler } from 'react'
import { ImageInput } from '@/Components/_Base/Input/Images/ImageInput'
import { InputError } from '@/Components/_Base/Input'
import PublicSettings = App.Models.Organisation.PublicSettings

export default function Edit({
    settings,
}: AppPageProps<{ settings: PublicSettings }>) {
    const __ = useTranslate()
    const FORM_ID = 'edit-favicon'

    const { data, setData, errors, post, processing } = useForm<{
        favicon: string | File
    }>({
        favicon: settings.favicon,
    })

    const submitHandler: FormEventHandler = (e) => {
        e.preventDefault()

        post(route('settings.favicon.update'), {
            replace: true,
        })
    }

    return (
        <SettingsLayout
            title={__('organisations.settings.favicon.headers.update')}
            actionButtons={FormActionButtons(
                route('settings.public.show'),
                FORM_ID,
                processing,
            )}
        >
            <Head title={__('organisations.settings.favicon.titles.update')} />

            <Card>
                <form onSubmit={submitHandler} id={FORM_ID}>
                    <ImageInput
                        image={data.favicon}
                        onChange={(image) => setData('favicon', image)}
                    />
                    <InputError message={errors.favicon} />
                </form>
            </Card>
        </SettingsLayout>
    )
}
