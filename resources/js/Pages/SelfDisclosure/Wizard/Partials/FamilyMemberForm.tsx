import useTranslate from '@/shared/hooks/useTranslate'
import { useForm } from '@inertiajs/react'
import { FormEventHandler, useContext } from 'react'
import { FamilyMemberFormWrapper } from '@/Pages/SelfDisclosure/Wizard/Lib/Wizard.context'
import InputGroup from '@/Components/_Base/Input/InputGroup'
import SwitchInput from '@/Components/_Base/Input/SwitchInput'
import AutocompleteGroup from '@/Components/_Base/Input/AutocompleteGroup'
import { SubmitButton } from '@/Pages/SelfDisclosure/Wizard/Components/SubmitButton'

export function FamilyMemberForm({ member }: { member?: any }) {
    const __ = useTranslate()

    const { data, errors, setData, patch, post, reset, processing } = useForm<{
        name: string
        year: number
        animal: boolean
        profession: string
        knows_animals: boolean
        type: 'dog' | 'cat' | 'other'
        good_with_animals: boolean
        castrated: boolean
    }>({
        name: member?.name ?? '',
        year: member?.year ?? new Date().getFullYear(),
        profession: member?.familyable?.profession ?? '',
        knows_animals: member?.familyable?.knows_animals ?? false,
        animal: !!member?.familyable?.type,
        type: member?.familyable?.type ?? 'dog',
        good_with_animals: member?.familyable?.good_with_animals ?? false,
        castrated: member?.familyable?.castrated ?? false,
    })

    const {
        focusError,
        refs: {
            name,
            year,
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
                label={__(
                    'self_disclosure.wizard.forms.family_member.animal.label',
                )}
                onChange={(value) => setData('animal', value)}
            />

            <InputGroup
                name="name"
                placeholder={__(
                    'self_disclosure.wizard.forms.family_member.name.placeholder',
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
                min={new Date().getFullYear() - 100}
                max={new Date().getFullYear()}
                ref={year}
                label={__(
                    'self_disclosure.wizard.forms.family_member.year.label',
                )}
                error={errors.year}
                onChange={(value) => setData('year', +value)}
            />

            {!data.animal && (
                <>
                    {data.year + 18 <= new Date().getFullYear() && (
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
                    )}
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
                </>
            )}

            {data.animal && (
                <>
                    <AutocompleteGroup
                        name="type"
                        value={data.type}
                        label={__(
                            'self_disclosure.wizard.forms.family_member.type.label',
                        )}
                        error={errors.type}
                        onChange={(value) => setData('type', value?.id as any)}
                        options={[
                            {
                                id: 'dog',
                                name: __('self_disclosure.family_members.dog'),
                            },
                            {
                                id: 'cat',
                                name: __('self_disclosure.family_members.cat'),
                            },
                            {
                                id: 'other',
                                name: __(
                                    'self_disclosure.family_members.other',
                                ),
                            },
                        ]}
                    />
                    <SwitchInput
                        name="good_with_animals"
                        checked={data.good_with_animals}
                        ref={good_with_animals}
                        label={__(
                            'self_disclosure.wizard.forms.family_member.good_with_animals.label',
                        )}
                        error={errors.good_with_animals}
                        onChange={(value) =>
                            setData('good_with_animals', value)
                        }
                    />
                    <SwitchInput
                        name="castrated"
                        checked={data.castrated}
                        ref={castrated}
                        label={__(
                            'self_disclosure.wizard.forms.family_member.castrated.label',
                        )}
                        error={errors.castrated}
                        onChange={(value) => setData('castrated', value)}
                    />
                </>
            )}

            <SubmitButton
                processing={processing}
                label={__(
                    member?.id
                        ? 'general.button.update'
                        : 'general.button.save',
                    { resource: '' },
                )}
            />
        </form>
    )
}
