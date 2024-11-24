import PrimaryButton from '@/Components/PrimaryButton'
import { useForm } from '@inertiajs/react'
import { FormEventHandler, useRef } from 'react'
import { twMerge } from 'tailwind-merge'
import InputGroup from '@/Components/_Base/Input/InputGroup'
import useTranslate from '@/shared/hooks/useTranslate'
import { SwitchInput } from '@/Components/_Base/Input'
import { Button } from '@/Components/_Base/Button'

export default function CreateOrganisationFormStep1({
    className = '',
    application,
    submitLabel = ['general.button.continue'],
    routeParams = {},
    readonly = false,
    onSuccess,
    onCancel,
}: {
    className?: string
    application?: any
    submitLabel?: [TranslationKey, TranslationReplace?]
    routeParams?: Record<string, unknown>
    readonly?: boolean
    onSuccess?: () => void
    onCancel?: () => void
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
                      ...routeParams,
                  })
                : route('organisations.applications.store', { ...routeParams }),
            {
                preserveScroll: true,
                replace: true,
                onSuccess: onSuccess,
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
                readOnly={readonly}
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
                readOnly={readonly}
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
                readOnly={readonly}
            />

            <SwitchInput
                name={'registered'}
                checked={data.registered}
                ref={registeredInput}
                label={'Are you officially registered?'}
                error={errors.registered}
                onChange={(value) => setData('registered', value)}
                readOnly={readonly}
            />

            <div
                className={`flex justify-end gap-4 ${readonly ? 'hidden' : ''}`}
            >
                <Button
                    color="secondary"
                    type="reset"
                    onClick={() => {
                        reset()
                        onCancel?.()
                    }}
                    className=""
                    disabled={processing}
                >
                    {__('general.button.cancel')}
                </Button>
                <PrimaryButton className="" disabled={processing}>
                    {__(...submitLabel)}
                </PrimaryButton>
            </div>
        </form>
    )
}
