import useTranslate from '@/shared/hooks/useTranslate'
import { useForm } from '@inertiajs/react'
import { FormEventHandler, useContext } from 'react'
import { WizardFormWrapper } from '@/Pages/SelfDisclosure/Wizard/Lib/Wizard.context'
import { Button } from '@/Components/_Base/Button'
import { AcknowledgementFormData } from '@/Pages/SelfDisclosure/Wizard/Lib/Wizard.types'
import SwitchInput from '@/Components/_Base/Input/SwitchInput'
import TextAreaGroup from '@/Components/_Base/Input/TextAreaGroup'

interface AcknowledgementFormProps {
    data?: {
        disclosure: AcknowledgementFormData
    }
}

export function ConfirmationForm(props: AcknowledgementFormProps) {
    const __ = useTranslate()

    const { data, errors, setData, patch, reset, processing } =
        useForm<AcknowledgementFormData>({
            not_banned: false,
            accepted_inaccuracy: false,
            has_proof_of_identity: false,
            everyone_agrees: false,
            notes: props.data?.disclosure?.notes ?? '',
        })

    const {
        focusError,
        refs: {},
    } = useContext(WizardFormWrapper.Context)

    const submitHandler: FormEventHandler = (e) => {
        e.preventDefault()

        patch(route('self-disclosure.confirmation.update'), {
            onSuccess: () => reset(),
            onError: (errors) => focusError(errors as any),
        })
    }

    return (
        <form
            className="w-full divide-y divide-gray-200"
            onSubmit={submitHandler}
        >
            <SwitchInput
                name="everyone_agrees"
                label={__(
                    'self_disclosure.wizard.forms.confirmation.everyone_agrees.label',
                )}
                checked={data.everyone_agrees}
                onChange={(v) => setData('everyone_agrees', v)}
                error={errors.everyone_agrees}
                className="py-8"
            />
            <SwitchInput
                name="not_banned"
                label={__(
                    'self_disclosure.wizard.forms.confirmation.not_banned.label',
                )}
                checked={data.not_banned}
                onChange={(v) => setData('not_banned', v)}
                error={errors.not_banned}
                className="py-8"
            />
            <SwitchInput
                name="accepted_inaccuracy"
                label={__(
                    'self_disclosure.wizard.forms.confirmation.accepted_inaccuracy.label',
                )}
                checked={data.accepted_inaccuracy}
                onChange={(v) => setData('accepted_inaccuracy', v)}
                error={errors.accepted_inaccuracy}
                className="py-8"
            />
            <SwitchInput
                name="has_proof_of_identity"
                label={__(
                    'self_disclosure.wizard.forms.confirmation.has_proof_of_identity.label',
                )}
                checked={data.has_proof_of_identity}
                onChange={(v) => setData('has_proof_of_identity', v)}
                error={errors.has_proof_of_identity}
                className="py-8"
            />

            <div className="py-8">
                <TextAreaGroup
                    name="notes"
                    label={__(
                        'self_disclosure.wizard.forms.confirmation.notes.label',
                    )}
                    value={data.notes}
                    onChange={(v) => setData('notes', v)}
                    error={errors.notes}
                />
            </div>

            <Button className="w-full" disabled={processing}>
                {__('self_disclosure.button.complete')}
            </Button>
        </form>
    )
}
