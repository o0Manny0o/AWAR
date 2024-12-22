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
    const FORM_ID = 'edit-logo'

    const { data, setData, errors, post, processing } = useForm<{
        logo: string | File
    }>({
        logo: settings.logo,
    })

    const submitHandler: FormEventHandler = (e) => {
        e.preventDefault()

        post(route('settings.logo.update'), {
            replace: true,
        })
    }

    return (
        <SettingsLayout
            title={__('organisations.settings.logo.headers.update')}
            actionButtons={FormActionButtons(
                route('settings.public.show'),
                FORM_ID,
                processing,
            )}
        >
            <Head title={__('organisations.settings.logo.titles.update')} />

            <Card>
                <form onSubmit={submitHandler} id={FORM_ID}>
                    <ImageInput
                        image={data.logo}
                        onChange={(image) => setData('logo', image)}
                    />
                    <InputError message={errors.logo} />
                </form>
            </Card>
        </SettingsLayout>
    )
}
