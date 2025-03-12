import { useForm } from '@inertiajs/react'
import InputGroup from '@/Components/_Base/Input/InputGroup'
import useTranslate from '@/shared/hooks/useTranslate'
import { FormEventHandler, useContext } from 'react'
import { WizardFormWrapper } from '@/Pages/SelfDisclosure/Wizard/Lib/Wizard.context'
import SwitchInput from '@/Components/_Base/Input/SwitchInput'
import { SubmitButton } from '@/Pages/SelfDisclosure/Wizard/Components/SubmitButton'

interface PersonalFormProps {
    data: {
        member: any
    }
}

export function PersonalForm(props: PersonalFormProps) {
    const __ = useTranslate()

    const { data, errors, setData, patch, reset, processing } = useForm<{
        name: string
        year: number
        profession: string
        knows_animals: boolean
    }>({
        name: props.data?.member?.name ?? '',
        year: props.data?.member?.year ?? 1990,
        profession: props.data?.member?.familyable.profession ?? '',
        knows_animals: props.data?.member?.familyable.knows_animals ?? false,
    })

    const {
        focusError,
        refs: { name, year, profession, knows_animals },
    } = useContext(WizardFormWrapper.Context)

    const submitHandler: FormEventHandler = (e) => {
        e.preventDefault()

        patch(route('self-disclosure.personal.update'), {
            onSuccess: () => reset(),
            onError: (errors) => focusError(errors as any),
        })
    }

    return (
        <form className="w-full space-y-6" onSubmit={submitHandler}>
            <InputGroup
                name="name"
                placeholder={__(
                    'self_disclosure.wizard.forms.family_member.name.label',
                )}
                value={data.name}
                ref={name}
                label={__(
                    'self_disclosure.wizard.forms.family_member.name.label',
                )}
                error={errors.name}
                onChange={(value) => setData('name', value)}
            />
            <InputGroup
                name="year"
                placeholder={__(
                    'self_disclosure.wizard.forms.family_member.year.placeholder',
                )}
                value={data.year}
                type="number"
                ref={year}
                label={__(
                    'self_disclosure.wizard.forms.family_member.year.label',
                )}
                error={errors.year}
                onChange={(value) => setData('year', +value)}
            />
            <InputGroup
                name="profession"
                placeholder={__(
                    'self_disclosure.wizard.forms.family_member.profession.placeholder',
                )}
                value={data.profession}
                ref={profession}
                label={__(
                    'self_disclosure.wizard.forms.family_member.profession.label',
                )}
                error={errors.profession}
                onChange={(value) => setData('profession', value)}
            />
            <SwitchInput
                name="knows_animals"
                checked={data.knows_animals}
                ref={knows_animals}
                label={__(
                    'self_disclosure.wizard.forms.family_member.knows_animals.label',
                )}
                error={errors.knows_animals}
                onChange={(value) => setData('knows_animals', value)}
            />

            <SubmitButton processing={processing} />
        </form>
    )
}
