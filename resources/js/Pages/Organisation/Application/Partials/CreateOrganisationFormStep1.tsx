import PrimaryButton from '@/Components/PrimaryButton'
import { useForm } from '@inertiajs/react'
import { FormEventHandler, useRef } from 'react'
import { twMerge } from 'tailwind-merge'
import InputGroup from '@/Components/_Base/Input/InputGroup'
import useTranslate from '@/shared/hooks/useTranslate'
import { SwitchInput } from '@/Components/_Base/Input'

export default function CreateOrganisationFormStep1({
    className = '',
    application,
}: {
    className?: string
    application?: any
}) {
    const __ = useTranslate()

    const nameInput = useRef<HTMLInputElement>(null)
    const typeInput = useRef<HTMLInputElement>(null)
    const roleInput = useRef<HTMLInputElement>(null)
    const registeredInput = useRef<HTMLButtonElement>(null)

    const { data, setData, errors, submit, reset, processing } = useForm({
        step: 1,
        name: application?.name ?? '',
        type: application?.type ?? '',
        user_role: application?.user_role ?? '',
        registered: application?.registered ?? false,
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
                    if (errors.name) {
                        nameInput.current?.focus()
                    } else if (errors.type) {
                        typeInput.current?.focus()
                    } else if (errors.role) {
                        roleInput.current?.focus()
                    } else if (errors.registered) {
                        registeredInput.current?.focus()
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
                    'organisations.applications.form.name.placeholder',
                )}
                value={data.name}
                ref={nameInput}
                label={__('organisations.applications.form.name.label')}
                error={errors.name}
                onChange={(value) => setData('name', value)}
            />
            <InputGroup
                name="type"
                placeholder={__(
                    'organisations.applications.form.type.placeholder',
                )}
                value={data.type}
                ref={typeInput}
                label={__('organisations.applications.form.type.label')}
                error={errors.type}
                onChange={(value) => setData('type', value)}
            />
            <InputGroup
                name="role"
                placeholder={__(
                    'organisations.applications.form.role.placeholder',
                )}
                value={data.user_role}
                ref={roleInput}
                label={__('organisations.applications.form.role.label')}
                error={errors.user_role}
                onChange={(value) => setData('user_role', value)}
            />

            <SwitchInput
                name={'registered'}
                checked={data.registered}
                ref={registeredInput}
                label={'Are you officially registered?'}
                error={errors.registered}
                onChange={(value) => setData('registered', value)}
            />

            <div className="">
                <PrimaryButton className="w-full" disabled={processing}>
                    Continue
                </PrimaryButton>
            </div>
        </form>
    )
}
