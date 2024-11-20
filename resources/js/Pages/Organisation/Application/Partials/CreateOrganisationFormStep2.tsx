import PrimaryButton from '@/Components/PrimaryButton'
import { useForm } from '@inertiajs/react'
import { FormEventHandler, useRef } from 'react'
import { twMerge } from 'tailwind-merge'
import InputGroup from '@/Components/_Base/Input/InputGroup'
import useTranslate from '@/shared/hooks/useTranslate'

export default function CreateOrganisationFormStep2({
    className = '',
    application,
}: {
    className?: string
    application?: any
}) {
    const __ = useTranslate()

    const streetInput = useRef<HTMLInputElement>(null)
    const postCodeInput = useRef<HTMLInputElement>(null)
    const cityInput = useRef<HTMLInputElement>(null)
    const countryInput = useRef<HTMLInputElement>(null)

    const { data, setData, errors, submit, reset, processing } = useForm({
        step: 2,
        street: application?.street ?? '',
        post_code: application?.post_code ?? '',
        city: application?.city ?? '',
        country: application?.country ?? '',
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
                    if (errors.street) {
                        streetInput.current?.focus()
                    } else if (errors.post_code) {
                        postCodeInput.current?.focus()
                    } else if (errors.city) {
                        cityInput.current?.focus()
                    } else if (errors.country) {
                        countryInput.current?.focus()
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
                name="name"
                placeholder={__(
                    'organisations.applications.form.street.placeholder',
                )}
                value={data.street}
                ref={streetInput}
                label={__('organisations.applications.form.street.label')}
                error={errors.street}
                onChange={(value) => setData('street', value)}
            />
            <InputGroup
                name="postCode"
                placeholder={__(
                    'organisations.applications.form.post_code.placeholder',
                )}
                value={data.post_code}
                ref={postCodeInput}
                label={__('organisations.applications.form.post_code.label')}
                error={errors.post_code}
                onChange={(value) => setData('post_code', value)}
            />
            <InputGroup
                name="city"
                placeholder={__(
                    'organisations.applications.form.city.placeholder',
                )}
                value={data.city}
                ref={cityInput}
                label={__('organisations.applications.form.city.label')}
                error={errors.city}
                onChange={(value) => setData('city', value)}
            />
            <InputGroup
                name="country"
                placeholder={__(
                    'organisations.applications.form.country.placeholder',
                )}
                value={data.country}
                ref={countryInput}
                label={__('organisations.applications.form.country.label')}
                error={errors.country}
                onChange={(value) => setData('country', value)}
            />

            <div className="">
                <PrimaryButton className="w-full" disabled={processing}>
                    Continue
                </PrimaryButton>
            </div>
        </form>
    )
}
