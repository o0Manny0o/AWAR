import PrimaryButton from '@/Components/PrimaryButton'
import { useForm } from '@inertiajs/react'
import { FormEventHandler, useContext } from 'react'
import { twMerge } from 'tailwind-merge'
import { AddressInfoGroup } from '@/Pages/Organisation/Application/Lib/OrganisationApplication.components'
import { FormInputRefs } from '@/Pages/Organisation/Application/Lib/OrganisationApplication.context'
import OrganisationApplication = App.Models.OrganisationApplication

export default function CreateOrganisationFormStep2({
    className = '',
    application,
}: {
    className?: string
    application: Partial<OrganisationApplication>
}) {
    const { focusError } = useContext(FormInputRefs.Context)

    const { data, setData, errors, post, reset, processing } = useForm({
        street: application?.street ?? '',
        post_code: application?.post_code ?? '',
        city: application?.city ?? '',
        country: application?.country ?? '',
    })

    const stepOneHandler: FormEventHandler = (e) => {
        e.preventDefault()

        post(
            route('organisations.applications.store.step', {
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
