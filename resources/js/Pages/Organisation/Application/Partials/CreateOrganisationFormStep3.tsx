import PrimaryButton from '@/Components/PrimaryButton'
import { useForm } from '@inertiajs/react'
import { FormEventHandler, useRef } from 'react'
import { twMerge } from 'tailwind-merge'
import InputGroup from '@/Components/_Base/Input/InputGroup'
import useTranslate from '@/shared/hooks/useTranslate'
import OrganisationApplication = App.Models.OrganisationApplication

export default function CreateOrganisationFormStep3({
    className = '',
    domain,
    application,
}: {
    className?: string
    domain: string
    application: Partial<OrganisationApplication>
}) {
    const __ = useTranslate()
    const subdomainInput = useRef<HTMLInputElement>(null)

    const transformSubdomain = (subdomain: string) => {
        return subdomain
            .toLowerCase()
            .replace(/[^A-Za-z\d-]+/g, '-')
            .replace(/-{2,}/g, '-')
    }

    const removeTrailingDash = (subdomain: string) => {
        return subdomain.toLowerCase().replace(/-$/, '')
    }

    const { data, setData, errors, post, reset, processing } = useForm({
        subdomain:
            application?.subdomain ??
            transformSubdomain(application.name ?? ''),
    })

    const stepOneHandler: FormEventHandler = (e) => {
        e.preventDefault()

        post(
            route('organisations.applications.store.step', {
                application: application.id,
                step: 3,
            }),
            {
                preserveScroll: true,
                replace: true,
                onSuccess: () => reset(),
                onError: (errors) => {
                    if (errors.subdomain) {
                        subdomainInput.current?.focus()
                    }
                },
            },
        )
    }

    return (
        <form
            onSubmit={stepOneHandler}
            className={twMerge('w-full space-y-6', className)}
        >
            <InputGroup
                name="subdomain"
                value={data.subdomain}
                ref={subdomainInput}
                label={__('organisations.applications.form.subdomain.label')}
                placeholder={__(
                    'organisations.applications.form.subdomain.placeholder',
                )}
                error={errors.subdomain}
                onChange={(value) =>
                    setData('subdomain', transformSubdomain(value))
                }
                onBlur={() =>
                    setData('subdomain', removeTrailingDash(data.subdomain))
                }
                leading={'https://'}
                append={`.${domain}`}
                className="pl-16"
            />

            <div className="flex items-center gap-4">
                <PrimaryButton className="w-full" disabled={processing}>
                    Continue
                </PrimaryButton>
            </div>
        </form>
    )
}
