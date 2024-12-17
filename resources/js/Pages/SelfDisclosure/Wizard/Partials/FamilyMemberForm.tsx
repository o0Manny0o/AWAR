import useTranslate from '@/shared/hooks/useTranslate'
import { useForm } from '@inertiajs/react'
import { FormEventHandler, useContext } from 'react'
import { FamilyMemberFormWrapper } from '@/Pages/SelfDisclosure/Wizard/Lib/Wizard.context'
import { Button } from '@/Components/_Base/Button'
import InputGroup from '@/Components/_Base/Input/InputGroup'
import { SwitchInput } from '@/Components/_Base/Input'

export function FamilyMemberForm({ member }: { member?: any }) {
    const __ = useTranslate()

    const { data, errors, setData, patch, post, reset, processing } = useForm<{
        name: string
        age: number
        animal: boolean
        profession: string
        knows_animals: boolean
        type: string
        good_with_animals: boolean
        castrated: boolean
    }>({
        name: member?.name ?? '',
        age: member?.age ?? 18,
        profession: member?.familyable?.profession ?? '',
        knows_animals: member?.familyable?.knows_animals ?? false,
        animal: !!member?.familyable?.type,
        type: member?.familyable?.type ?? '',
        good_with_animals: member?.familyable?.good_with_animals ?? false,
        castrated: member?.familyable?.castrated ?? false,
    })

    const {
        focusError,
        refs: {
            name,
            age,
            profession,
            knows_animals,
            good_with_animals,
            type,
            castrated,
        },
    } = useContext(FamilyMemberFormWrapper.Context)

    const submitHandler: FormEventHandler = (e) => {
        e.preventDefault()

        if (member?.id) {
            patch(route('self-disclosure.family-members.update', member.id), {
                onSuccess: () => reset(),
                onError: (errors) => focusError(errors as any),
            })
        } else {
            post(route('self-disclosure.family-members.store'), {
                onSuccess: () => reset(),
                onError: (errors) => focusError(errors as any),
            })
        }
    }

    return (
        <form className="w-full space-y-6" onSubmit={submitHandler}>
            <SwitchInput
                name="animal"
                checked={data.animal}
                label={__('animal.label')}
                onChange={(value) => setData('animal', value)}
            />

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

            {!data.animal && (
                <>
                    {data.age >= 18 && (
                        <InputGroup
                            name="profession"
                            placeholder={__('profession.placeholder')}
                            value={data.profession}
                            ref={profession}
                            label={__('profession.label')}
                            error={errors.profession}
                            onChange={(value) => setData('profession', value)}
                        />
                    )}
                    <SwitchInput
                        name="knows_animals"
                        checked={data.knows_animals}
                        ref={knows_animals}
                        label={__('knows_animals.label')}
                        error={errors.knows_animals}
                        onChange={(value) => setData('knows_animals', value)}
                    />
                </>
            )}

            {data.animal && (
                <>
                    <InputGroup
                        name="type"
                        placeholder={__('type.placeholder')}
                        value={data.type}
                        ref={type}
                        label={__('type.label')}
                        error={errors.type}
                        onChange={(value) => setData('type', value)}
                    />
                    <SwitchInput
                        name="good_with_animals"
                        checked={data.good_with_animals}
                        ref={good_with_animals}
                        label={__('good_with_animals.label')}
                        error={errors.good_with_animals}
                        onChange={(value) =>
                            setData('good_with_animals', value)
                        }
                    />
                    <SwitchInput
                        name="castrated"
                        checked={data.castrated}
                        ref={castrated}
                        label={__('castrated.label')}
                        error={errors.castrated}
                        onChange={(value) => setData('castrated', value)}
                    />
                </>
            )}

            <Button className="w-full" disabled={processing}>
                {__(
                    member?.id
                        ? 'general.button.update'
                        : 'general.button.create',
                )}
            </Button>
        </form>
    )
}
