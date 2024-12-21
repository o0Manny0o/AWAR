import { FormEventHandler, useContext } from 'react'
import { useForm } from '@inertiajs/react'
import useTranslate from '@/shared/hooks/useTranslate'
import { OrganisationPublicSettingsFormWrapper } from '@/Pages/Tenant/Settings/PublicSettings/Lib/PublicSettings.context'
import { OrganisationPublicSettingsFormData } from '@/Pages/Tenant/Settings/PublicSettings/Lib/PublicSettings.types'
import InputGroup from '@/Components/_Base/Input/InputGroup'
import PublicSettings = App.Models.Organisation.PublicSettings

export default function UpdatePublicSettingsForm({
    settings,
    formId,
}: {
    settings: PublicSettings
    formId: string
}) {
    const __ = useTranslate()

    const {
        focusError,
        refs: { name },
    } = useContext(OrganisationPublicSettingsFormWrapper.Context)

    const { data, setData, errors, patch, reset, processing } =
        useForm<OrganisationPublicSettingsFormData>({
            name: settings.name ?? '',
        })

    const submitHandler: FormEventHandler = (e) => {
        e.preventDefault()

        patch(route('settings.public.update', settings.id), {
            preserveScroll: true,
            replace: true,
            onSuccess: () => reset(),
            onError: (errors) => focusError(errors as any),
        })
    }
    return (
        <form onSubmit={submitHandler} id={formId} className="w-full space-y-6">
            <InputGroup
                name={'name'}
                label={__('organisations.settings.public.form.name.label')}
                placeholder={settings.name}
                value={data.name}
                ref={name}
                error={errors.name}
                onChange={(v) => setData('name', v)}
            />
        </form>
    )
}
