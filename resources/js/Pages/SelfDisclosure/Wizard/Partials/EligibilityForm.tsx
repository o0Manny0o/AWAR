import useTranslate from '@/shared/hooks/useTranslate'
import { useForm } from '@inertiajs/react'
import { FormEventHandler, useContext } from 'react'
import { WizardFormWrapper } from '@/Pages/SelfDisclosure/Wizard/Lib/Wizard.context'
import { EligibilityFormData } from '@/Pages/SelfDisclosure/Wizard/Lib/Wizard.types'
import SwitchInput from '@/Components/_Base/Input/SwitchInput'
import InputGroup from '@/Components/_Base/Input/InputGroup'
import { SubmitButton } from '@/Pages/SelfDisclosure/Wizard/Components/SubmitButton'

interface PersonalFormProps {
    data?: {
        eligibility?: EligibilityFormData
    }
}

export function EligibilityForm(props: PersonalFormProps) {
    const __ = useTranslate()

    const { data, errors, setData, patch, reset, processing } =
        useForm<EligibilityFormData>({
            animal_protection_experience:
                props.data?.eligibility?.animal_protection_experience ?? false,
            can_afford_insurance:
                props.data?.eligibility?.can_afford_insurance ?? false,
            can_cover_emergencies:
                props.data?.eligibility?.can_cover_emergencies ?? false,
            can_cover_expenses:
                props.data?.eligibility?.can_cover_expenses ?? false,
            can_afford_castration:
                props.data?.eligibility?.can_afford_castration ?? false,
            substitute: props.data?.eligibility?.substitute ?? '',
            time_alone_daily: props.data?.eligibility?.time_alone_daily ?? 0,
        })

    const {
        focusError,
        refs: { substitute, time_alone_daily },
    } = useContext(WizardFormWrapper.Context)

    const submitHandler: FormEventHandler = (e) => {
        e.preventDefault()

        patch(route('self-disclosure.eligibility.update'), {
            onSuccess: () => reset(),
            onError: (errors) => focusError(errors as any),
        })
    }

    return (
        <form className="w-full space-y-6" onSubmit={submitHandler}>
            <SwitchInput
                name="animal_protection_experience"
                checked={data.animal_protection_experience}
                onChange={(v) => setData('animal_protection_experience', v)}
                label={__(
                    'self_disclosure.wizard.forms.eligibility.animal_protection_experience.label',
                )}
            />
            <SwitchInput
                name="can_afford_insurance"
                checked={data.can_afford_insurance}
                onChange={(v) => setData('can_afford_insurance', v)}
                label={__(
                    'self_disclosure.wizard.forms.eligibility.can_afford_insurance.label',
                )}
            />
            <SwitchInput
                name="can_cover_emergencies"
                checked={data.can_cover_emergencies}
                onChange={(v) => setData('can_cover_emergencies', v)}
                description={__(
                    'self_disclosure.wizard.forms.eligibility.can_cover_emergencies.description',
                )}
                label={__(
                    'self_disclosure.wizard.forms.eligibility.can_cover_emergencies.label',
                )}
            />
            <SwitchInput
                name="can_cover_expenses"
                checked={data.can_cover_expenses}
                onChange={(v) => setData('can_cover_expenses', v)}
                description={__(
                    'self_disclosure.wizard.forms.eligibility.can_cover_expenses.description',
                )}
                label={__(
                    'self_disclosure.wizard.forms.eligibility.can_cover_expenses.label',
                )}
            />

            <SwitchInput
                name="can_afford_castration"
                checked={data.can_afford_castration}
                onChange={(v) => setData('can_afford_castration', v)}
                label={__(
                    'self_disclosure.wizard.forms.eligibility.can_afford_castration.label',
                )}
            />

            <InputGroup
                name={'substitute'}
                placeholder={__(
                    'self_disclosure.wizard.forms.eligibility.substitute.placeholder',
                )}
                label={__(
                    'self_disclosure.wizard.forms.eligibility.substitute.label',
                )}
                ref={substitute}
                value={data.substitute}
                error={errors.substitute}
                onChange={(v) => setData('substitute', v)}
            />

            <InputGroup
                name={'time_alone_daily'}
                label={__(
                    'self_disclosure.wizard.forms.eligibility.time_alone_daily.label',
                )}
                type="number"
                min={0}
                max={24}
                ref={time_alone_daily}
                value={data.time_alone_daily}
                error={errors.time_alone_daily}
                onChange={(v) => setData('time_alone_daily', +v)}
            />

            <SubmitButton processing={processing} />
        </form>
    )
}
