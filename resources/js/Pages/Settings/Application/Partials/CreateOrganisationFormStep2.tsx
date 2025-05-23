import PrimaryButton from '@/Components/PrimaryButton'
import { useForm } from '@inertiajs/react'
import { FormEventHandler, useContext } from 'react'
import { twMerge } from 'tailwind-merge'
import { AddressInfoGroup } from '@/Pages/Settings/Application/Lib/OrganisationApplication.components'
import { ApplicationFormWrapper } from '@/Pages/Settings/Application/Lib/OrganisationApplication.context'
import OrganisationApplicationDraft = App.Models.OrganisationApplicationDraft

export default function CreateOrganisationFormStep2({
    className = '',
    application,
}: {
    className?: string
    application: OrganisationApplicationDraft
}) {
    const { focusError } = useContext(ApplicationFormWrapper.Context)

    const { data, setData, errors, post, reset, processing } = useForm({
        street: application?.street ?? '',
        post_code: application?.post_code ?? '',
        city: application?.city ?? '',
        country: application?.country ?? '',
    })

    const stepOneHandler: FormEventHandler = (e) => {
        e.preventDefault()

        post(
            route('settings.applications.store.step', {
                application: application.id,
                step: 2,
            }),
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
            <AddressInfoGroup data={data} errors={errors} setData={setData} />

            <div className="">
                <PrimaryButton className="w-full" disabled={processing}>
                    Continue
                </PrimaryButton>
            </div>
        </form>
    )
}
