import PrimaryButton from '@/Components/PrimaryButton'
import { useForm } from '@inertiajs/react'
import { FormEventHandler, useRef } from 'react'
import { twMerge } from 'tailwind-merge'
import { AddressInfoGroup } from '@/Pages/Organisation/Application/Lib/OrganisationApplication.components'
import { InputFocusContext } from '@/Pages/Organisation/Application/Lib/OrganisationApplicationInputContext'
import OrganisationApplication = App.Models.OrganisationApplication

export default function CreateOrganisationFormStep2({
    className = '',
    application,
}: {
    className?: string
    application: Partial<OrganisationApplication>
}) {
    const streetRef = useRef<HTMLInputElement>(null)
    const postCodeRef = useRef<HTMLInputElement>(null)
    const cityRef = useRef<HTMLInputElement>(null)
    const countryRef = useRef<HTMLInputElement>(null)

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
                onError: (errors) => {
                    if (errors.street) {
                        streetRef.current?.focus()
                    } else if (errors.post_code) {
                        postCodeRef.current?.focus()
                    } else if (errors.city) {
                        cityRef.current?.focus()
                    } else if (errors.country) {
                        countryRef.current?.focus()
                    }
                },
            },
        )
    }

    return (
        <InputFocusContext.Provider
            value={{ streetRef, postCodeRef, cityRef, countryRef }}
        >
            <form
                onSubmit={stepOneHandler}
                className={twMerge('w-full space-y-6', className)}
            >
                <AddressInfoGroup
                    data={data}
                    errors={errors}
                    setData={setData}
                />

                <div className="">
                    <PrimaryButton className="w-full" disabled={processing}>
                        Continue
                    </PrimaryButton>
                </div>
            </form>
        </InputFocusContext.Provider>
    )
}
