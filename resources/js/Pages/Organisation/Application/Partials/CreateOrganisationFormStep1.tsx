import { useForm } from '@inertiajs/react'
import { FormEventHandler, useRef } from 'react'
import { twMerge } from 'tailwind-merge'
import useTranslate from '@/shared/hooks/useTranslate'
import { Button } from '@/Components/_Base/Button'
import { GeneralInfoGroup } from '@/Pages/Organisation/Application/Lib/OrganisationApplication.inputs'
import { InputFocusContext } from '@/Pages/Organisation/Application/Lib/OrganisationApplicationInputContext'

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

    const nameRef = useRef<HTMLInputElement>(null)
    const typeRef = useRef<HTMLInputElement>(null)
    const roleRef = useRef<HTMLInputElement>(null)
    const registeredRef = useRef<HTMLButtonElement>(null)

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
                ? route('organisations.applications.store.step', {
                      application: application.id,
                      step: 1,
                      ...routeParams,
                  })
                : route('organisations.applications.store', { ...routeParams }),
            {
                preserveScroll: true,
                replace: true,
                onSuccess: () => reset(),
                onError: (errors) => {
                    if (errors.name) {
                        nameRef.current?.focus()
                    } else if (errors.type) {
                        typeRef.current?.focus()
                    } else if (errors.role) {
                        roleRef.current?.focus()
                    } else if (errors.registered) {
                        registeredRef.current?.focus()
                    }
                },
            },
        )
    }

    return (
        <InputFocusContext.Provider
            value={{ nameRef, typeRef, roleRef, registeredRef }}
        >
            <form
                onSubmit={stepOneHandler}
                className={twMerge('w-full space-y-6', className)}
            >
                <GeneralInfoGroup
                    data={data}
                    errors={errors}
                    setData={setData}
                />

                <Button className="w-full" disabled={processing}>
                    {__(...submitLabel)}
                </Button>
            </form>
        </InputFocusContext.Provider>
    )
}
