import useTranslate from '@/shared/hooks/useTranslate'
import { useForm } from '@inertiajs/react'
import { FormEventHandler, useContext } from 'react'
import { WizardFormWrapper } from '@/Pages/SelfDisclosure/Wizard/Lib/Wizard.context'
import InputGroup from '@/Components/_Base/Input/InputGroup'
import SwitchInput from '@/Components/_Base/Input/SwitchInput'
import { SubmitButton } from '@/Pages/SelfDisclosure/Wizard/Components/SubmitButton'

interface PersonalFormProps {
    data?: {
        garden?: {
            garden: boolean
            garden_size: number
            garden_secure: boolean
            garden_connected: boolean
        }
    }
}

export function GardenForm(props: PersonalFormProps) {
    const __ = useTranslate()

    const { data, errors, setData, patch, reset, processing } = useForm<{
        garden: boolean
        garden_size: number
        garden_secure: boolean
        garden_connected: boolean
    }>({
        garden: props.data?.garden?.garden ?? false,
        garden_size: props.data?.garden?.garden_size ?? 20,
        garden_secure: props.data?.garden?.garden_secure ?? false,
        garden_connected: props.data?.garden?.garden_connected ?? false,
    })

    const {
        focusError,
        refs: { garden_size },
    } = useContext(WizardFormWrapper.Context)

    const submitHandler: FormEventHandler = (e) => {
        e.preventDefault()

        patch(route('self-disclosure.garden.update'), {
            onSuccess: () => reset(),
            onError: (errors) => focusError(errors as any),
        })
    }

    return (
        <form className="w-full space-y-6" onSubmit={submitHandler}>
            <SwitchInput
                name={'garden'}
                checked={data.garden}
                label={__('self_disclosure.wizard.forms.garden.garden.label')}
                onChange={(value) => setData('garden', value)}
            />

            {data.garden && (
                <>
                    <InputGroup
                        name={'garden_size'}
                        placeholder={__(
                            'self_disclosure.wizard.forms.garden.garden_size.placeholder',
                        )}
                        label={__(
                            'self_disclosure.wizard.forms.garden.garden_size.label',
                        )}
                        value={data.garden_size}
                        min={1}
                        append={
                            <>
                                m<sup>2</sup>
                            </>
                        }
                        onChange={(value) => setData('garden_size', +value)}
                        ref={garden_size}
                        error={errors.garden_size}
                        type="number"
                    />

                    <SwitchInput
                        name={'garden_secure'}
                        checked={data.garden_secure}
                        label={__(
                            'self_disclosure.wizard.forms.garden.garden_secure.label',
                        )}
                        onChange={(value) => setData('garden_secure', value)}
                    />

                    <SwitchInput
                        name={'garden_connected'}
                        checked={data.garden_connected}
                        label={__(
                            'self_disclosure.wizard.forms.garden.garden_connected.label',
                        )}
                        onChange={(value) => setData('garden_connected', value)}
                    />
                </>
            )}

            <SubmitButton processing={processing} />
        </form>
    )
}
