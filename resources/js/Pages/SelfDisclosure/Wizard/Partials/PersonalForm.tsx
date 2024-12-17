import { useForm } from '@inertiajs/react'
import InputGroup from '@/Components/_Base/Input/InputGroup'
import useTranslate from '@/shared/hooks/useTranslate'
import { FormEventHandler, useContext } from 'react'
import { WizardFormWrapper } from '@/Pages/SelfDisclosure/Wizard/Lib/Wizard.context'
import { SwitchInput } from '@/Components/_Base/Input'
import { Button } from '@/Components/_Base/Button'

interface PersonalFormProps {
    data: {
        member: any
    }
}

export function PersonalForm(props: PersonalFormProps) {
    const __ = useTranslate()

    const { data, errors, setData, post, reset, processing } = useForm<{
        name: string
        age: number
        profession: string
        knows: boolean
    }>({
        name: props.data?.member?.name ?? '',
        age: props.data?.member?.age ?? 18,
        profession: props.data?.member?.familyable.profession ?? '',
        knows: props.data?.member?.familyable.knows_animals ?? false,
    })

    const {
        focusError,
        refs: { name, age, profession, knows },
    } = useContext(WizardFormWrapper.Context)

    const submitHandler: FormEventHandler = (e) => {
        e.preventDefault()

        post(route('self-disclosure.personal.update'), {
            onSuccess: () => reset(),
            onError: (errors) => focusError(errors as any),
        })
    }

    return (
        <form className="w-full space-y-6" onSubmit={submitHandler}>
            <InputGroup
                name="name"
                placeholder={__('name.placeholder')}
                value={data.name}
                ref={name}
                label={__('name.label')}
                error={errors.name}
                onChange={(value) => setData('name', value)}
            />
            <InputGroup
                name="age"
                placeholder={__('age.placeholder')}
                value={data.age}
                type="number"
                ref={age}
                label={__('age.label')}
                error={errors.age}
                onChange={(value) => setData('age', +value)}
            />
            <InputGroup
                name="profession"
                placeholder={__('profession.placeholder')}
                value={data.profession}
                ref={profession}
                label={__('profession.label')}
                error={errors.profession}
                onChange={(value) => setData('profession', value)}
            />
            <SwitchInput
                name="knows"
                checked={data.knows}
                ref={knows}
                label={__('knows.label')}
                error={errors.knows}
                onChange={(value) => setData('knows', value)}
            />

            <Button className="w-full" disabled={processing}>
                {__('general.button.continue')}
            </Button>
        </form>
    )
}
