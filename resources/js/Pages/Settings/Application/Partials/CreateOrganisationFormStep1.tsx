import { useForm } from '@inertiajs/react'
import { FormEventHandler, useContext } from 'react'
import { twMerge } from 'tailwind-merge'
import useTranslate from '@/shared/hooks/useTranslate'
import { Button } from '@/Components/_Base/Button'
import { GeneralInfoGroup } from '@/Pages/Settings/Application/Lib/OrganisationApplication.components'
import { ApplicationFormWrapper } from '@/Pages/Settings/Application/Lib/OrganisationApplication.context'

export default function CreateOrganisationFormStep1({
    className = '',
    application,
    submitLabel = ['general.button.continue'],
    routeParams = {},
}: {
    className?: string
    application?: any
    submitLabel?: [TranslationKey, TranslationReplace?]
    routeParams?: Record<string, unknown>
}) {
    const __ = useTranslate()
    const { focusError } = useContext(ApplicationFormWrapper.Context)

    const { data, setData, errors, post, reset, processing } = useForm({
        name: application?.name ?? '',
        type: application?.type ?? '',
        user_role: application?.user_role ?? '',
        registered: application?.registered ?? false,
    })

    const stepOneHandler: FormEventHandler = (e) => {
        e.preventDefault()

        post(
            application?.id
                ? route('settings.applications.store.step', {
                      application: application.id,
                      step: 1,
                      ...routeParams,
                  })
                : route('settings.applications.store', { ...routeParams }),
            {
                preserveScroll: true,
                replace: true,
                onSuccess: () => reset(),
                onError: (errors) => focusError(errors as any),
            },
        )
    }

    return (
        <form
            onSubmit={stepOneHandler}
            className={twMerge('w-full space-y-6', className)}
        >
            <GeneralInfoGroup data={data} errors={errors} setData={setData} />

            <Button className="w-full" disabled={processing}>
                {__(...submitLabel)}
            </Button>
        </form>
    )
}
