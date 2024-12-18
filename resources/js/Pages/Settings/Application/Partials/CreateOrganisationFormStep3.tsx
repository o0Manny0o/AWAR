import PrimaryButton from '@/Components/PrimaryButton'
import { useForm } from '@inertiajs/react'
import { FormEventHandler, useContext } from 'react'
import { twMerge } from 'tailwind-merge'
import {
    removeTrailingDash,
    transformSubdomain,
} from '@/Pages/Settings/Application/Lib/OrganisationApplication.util'
import { SubdomainInfoGroup } from '@/Pages/Settings/Application/Lib/OrganisationApplication.components'
import { ApplicationFormWrapper } from '@/Pages/Settings/Application/Lib/OrganisationApplication.context'
import OrganisationApplicationDraft = App.Models.OrganisationApplicationDraft

export default function CreateOrganisationFormStep3({
    className = '',
    domain,
    application,
}: {
    className?: string
    domain: string
    application: OrganisationApplicationDraft
}) {
    const { focusError } = useContext(ApplicationFormWrapper.Context)

    const { data, setData, errors, post, reset, processing, transform } =
        useForm({
            subdomain:
                application?.subdomain ??
                transformSubdomain(application.name ?? ''),
        })

    transform((data) => ({
        subdomain: removeTrailingDash(transformSubdomain(data.subdomain)),
    }))

    const stepOneHandler: FormEventHandler = (e) => {
        e.preventDefault()

        post(
            route('settings.applications.store.step', {
                application: application.id,
                step: 3,
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
            <SubdomainInfoGroup
                domain={domain}
                data={data}
                errors={errors}
                setData={setData}
            />

            <div className="flex items-center gap-4">
                <PrimaryButton className="w-full" disabled={processing}>
                    Continue
                </PrimaryButton>
            </div>
        </form>
    )
}
