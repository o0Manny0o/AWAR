import useTranslate from '@/shared/hooks/useTranslate'
import { FormEventHandler, useRef } from 'react'
import { useForm } from '@inertiajs/react'
import {
    removeTrailingDash,
    transformSubdomain,
} from '@/Pages/Organisation/Application/Lib/OrganisationApplication.util'
import {
    AddressInfoGroup,
    GeneralInfoGroup,
    SubdomainInfoGroup,
} from '@/Pages/Organisation/Application/Lib/OrganisationApplication.inputs'
import { InputFocusContext } from '../Lib/OrganisationApplicationInputContext'
import OrganisationApplicationDraft = App.Models.OrganisationApplicationDraft

export default function EditOrganisationForm({
    domain,
    application,
    formId,
}: {
    application: OrganisationApplicationDraft
    domain: string
    formId: string
}) {
    const __ = useTranslate()

    const nameRef = useRef<HTMLInputElement>(null)
    const typeRef = useRef<HTMLInputElement>(null)
    const roleRef = useRef<HTMLInputElement>(null)
    const registeredRef = useRef<HTMLButtonElement>(null)

    const streetRef = useRef<HTMLInputElement>(null)
    const postCodeRef = useRef<HTMLInputElement>(null)
    const cityRef = useRef<HTMLInputElement>(null)
    const countryRef = useRef<HTMLInputElement>(null)

    const subdomainRef = useRef<HTMLInputElement>(null)

    // TODO: Disable buttons while processing
    const { data, setData, errors, patch, reset, processing, transform } =
        useForm({
            name: application?.name ?? '',
            type: application?.type ?? '',
            user_role: application?.user_role ?? '',
            registered: application?.registered ?? false,

            street: application?.street ?? '',
            post_code: application?.post_code ?? '',
            city: application?.city ?? '',
            country: application?.country ?? '',

            subdomain:
                application?.subdomain ??
                transformSubdomain(application.name ?? ''),
        })

    transform((data) => ({
        ...data,
        subdomain: removeTrailingDash(transformSubdomain(data.subdomain)),
    }))

    const submitHandler: FormEventHandler = (e) => {
        e.preventDefault()

        patch(
            route('organisations.applications.update', {
                application: application.id,
            }),
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
                    } else if (errors.street) {
                        streetRef.current?.focus()
                    } else if (errors.post_code) {
                        postCodeRef.current?.focus()
                    } else if (errors.city) {
                        cityRef.current?.focus()
                    } else if (errors.country) {
                        console.log(countryRef.current)
                        countryRef.current?.focus()
                    } else if (errors.subdomain) {
                        subdomainRef.current?.focus()
                    }
                },
            },
        )
    }

    return (
        <InputFocusContext.Provider
            value={{
                nameRef,
                typeRef,
                roleRef,
                registeredRef,
                streetRef,
                postCodeRef,
                cityRef,
                countryRef,
                subdomainRef,
            }}
        >
            <form id={formId} onSubmit={submitHandler}>
                <div className="space-y-6 py-6">
                    <div className="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                        <div className="bg-ceiling space-y-4 rounded-lg p-4 shadow sm:p-6">
                            <h3>
                                {__(
                                    'organisations.applications.form.general_info',
                                )}
                            </h3>

                            <GeneralInfoGroup
                                data={data}
                                errors={errors}
                                setData={setData}
                            />
                        </div>
                    </div>

                    <div className="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                        <div className="bg-ceiling space-y-6 rounded-lg p-4 shadow sm:p-6">
                            <h3>
                                {__(
                                    'organisations.applications.form.address_info',
                                )}
                            </h3>

                            <AddressInfoGroup
                                data={data}
                                errors={errors}
                                setData={setData}
                            />
                        </div>
                    </div>

                    <div className="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                        <div className="bg-ceiling space-y-6 rounded-lg p-4 shadow sm:p-6">
                            <h3>
                                {__(
                                    'organisations.applications.form.address_info',
                                )}
                            </h3>

                            <SubdomainInfoGroup
                                data={data}
                                errors={errors}
                                setData={setData}
                                domain={domain}
                            />
                        </div>
                    </div>
                </div>
            </form>
        </InputFocusContext.Provider>
    )
}
