import PrimaryButton from '@/Components/PrimaryButton'
import { useForm } from '@inertiajs/react'
import { FormEventHandler, useEffect, useRef, useState } from 'react'
import { twMerge } from 'tailwind-merge'
import InputGroup from '@/Components/_Base/Input/InputGroup'

export default function CreateOrganisationFormStep3({
    className = '',
    domain,
    application,
}: {
    className?: string
    domain: string
    application?: any
}) {
    const subdomainInput = useRef<HTMLInputElement>(null)

    const [subdomainTouched, setSubdomainTouched] = useState(false)

    const transformSubdomain = (subdomain: string) => {
        return subdomain
            .toLowerCase()
            .replace(/[^A-Za-z\d-]+/g, '-')
            .replace(/-{2,}/g, '-')
    }

    const removeTrailingDash = (subdomain: string) => {
        setData('subdomain', subdomain.toLowerCase().replace(/-$/, ''))
    }

    useEffect(() => {
        if (!subdomainTouched || !data.subdomain) {
            removeTrailingDash(transformSubdomain(application.name))
        }
    }, [application.name])

    const { data, setData, errors, submit, reset, processing } = useForm({
        step: 1,
        subdomain: application?.subdomain ?? '',
    })

    const stepOneHandler: FormEventHandler = (e) => {
        e.preventDefault()

        submit(
            application ? 'patch' : 'post',
            application
                ? route('organisations.applications.update', {
                      application: application.id,
                  })
                : route('organisations.applications.store'),
            {
                preserveScroll: true,
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
                label="What is the name of your organisation?"
                error={errors.subdomain}
                onChange={(value) => {
                    setSubdomainTouched(true)
                    setData('subdomain', value)
                }}
                append={`.${domain}`}
            />

            <div className="flex items-center gap-4">
                <PrimaryButton disabled={processing}>Save</PrimaryButton>
            </div>
        </form>
    )
}
