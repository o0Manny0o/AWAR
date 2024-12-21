import useTranslate from '@/shared/hooks/useTranslate'
import { useForm } from '@inertiajs/react'
import { FormEventHandler, useContext } from 'react'
import { WizardFormWrapper } from '@/Pages/SelfDisclosure/Wizard/Lib/Wizard.context'
import AutocompleteGroup from '@/Components/_Base/Input/AutocompleteGroup'
import { InputGroup, SwitchInput } from '@/Components/_Base/Input'
import { SubmitButton } from '@/Pages/SelfDisclosure/Wizard/Components/SubmitButton'
import { Option } from '@/Components/_Base/Input/AutocompleteInput'

interface PersonalFormProps {
    data?: {
        home?: {
            type: 'apartment' | 'house' | 'other'
            own: boolean
            pets_allowed: boolean
            move_in_date: string
            size: number
            level: number
            location: 'city' | 'suburb' | 'rural'
        }
    }
}

type HomeType = 'apartment' | 'house' | 'other'
type HomeLocation = 'city' | 'suburb' | 'rural'

type HomeTypeOption = {
    id: HomeType
    name: string
}

type HomeLocationOption = {
    id: HomeLocation
    name: string
}

export function HomeForm(props: PersonalFormProps) {
    const __ = useTranslate()

    const { data, errors, setData, patch, reset, processing } = useForm<{
        type: HomeType
        own: boolean
        pets_allowed: boolean
        move_in_date: string
        size: number
        level: number
        location: HomeLocation
    }>({
        type: props.data?.home?.type ?? 'apartment',
        own: props.data?.home?.own ?? false,
        pets_allowed: props.data?.home?.pets_allowed ?? true,
        move_in_date: props.data?.home?.move_in_date ?? '',
        size: props.data?.home?.size ?? 50,
        level: props.data?.home?.level ?? 1,
        location: props.data?.home?.location ?? 'city',
    })

    const {
        focusError,
        refs: { size, level, move_in_date },
    } = useContext(WizardFormWrapper.Context)

    const submitHandler: FormEventHandler = (e) => {
        e.preventDefault()

        patch(route('self-disclosure.home.update'), {
            onSuccess: () => reset(),
            onError: (errors) => focusError(errors as any),
        })
    }

    return (
        <form className="w-full space-y-6" onSubmit={submitHandler}>
            <AutocompleteGroup
                name={'type'}
                label={__('self_disclosure.wizard.forms.home.type.label')}
                optionsClassName="[--anchor-max-height:15rem]"
                value={data.type}
                onChange={(v: Option | null) =>
                    setData(
                        'type',
                        (v?.id as HomeTypeOption['id']) ?? 'apartment',
                    )
                }
                error={errors.type}
                options={[
                    {
                        id: 'apartment',
                        name: __(
                            'self_disclosure.wizard.forms.home.type.apartment',
                        ),
                    },
                    {
                        id: 'house',
                        name: __(
                            'self_disclosure.wizard.forms.home.type.house',
                        ),
                    },
                    {
                        id: 'other',
                        name: __(
                            'self_disclosure.wizard.forms.home.type.other',
                        ),
                    },
                ]}
            />

            <SwitchInput
                name={'own'}
                checked={data.own}
                label={__('self_disclosure.wizard.forms.home.own.label')}
                onChange={(value) => setData('own', value)}
            />

            {!data.own && (
                <SwitchInput
                    name={'pets_allowed'}
                    checked={data.pets_allowed}
                    label={__(
                        'self_disclosure.wizard.forms.home.pets_allowed.label',
                    )}
                    description={
                        !data.pets_allowed
                            ? __(
                                  'self_disclosure.wizard.forms.home.pets_allowed.description',
                              )
                            : undefined
                    }
                    onChange={(value) => setData('pets_allowed', value)}
                />
            )}

            <InputGroup
                name="move_in_date"
                value={data.move_in_date}
                type="date"
                ref={move_in_date}
                label={__(
                    'self_disclosure.wizard.forms.home.move_in_date.label',
                )}
                error={errors.move_in_date}
                onChange={(value) => setData('move_in_date', value)}
            />

            <InputGroup
                name="size"
                placeholder={__(
                    'self_disclosure.wizard.forms.home.size.placeholder',
                )}
                value={data.size}
                type="number"
                ref={size}
                label={__('self_disclosure.wizard.forms.home.size.label')}
                error={errors.size}
                onChange={(value) => setData('size', +value)}
            />

            <InputGroup
                name="level"
                value={data.level}
                type="number"
                ref={level}
                label={__('self_disclosure.wizard.forms.home.level.label')}
                error={errors.level}
                onChange={(value) => setData('level', +value)}
            />

            <AutocompleteGroup
                name={'location'}
                label={__('self_disclosure.wizard.forms.home.location.label')}
                optionsClassName="[--anchor-max-height:15rem]"
                value={data.location}
                onChange={(v: Option | null) =>
                    setData(
                        'location',
                        (v?.id as HomeLocationOption['id']) ?? 'city',
                    )
                }
                options={[
                    {
                        id: 'city',
                        name: __(
                            'self_disclosure.wizard.forms.home.location.city',
                        ),
                    },
                    {
                        id: 'suburb',
                        name: __(
                            'self_disclosure.wizard.forms.home.location.suburb',
                        ),
                    },
                    {
                        id: 'rural',
                        name: __(
                            'self_disclosure.wizard.forms.home.location.rural',
                        ),
                    },
                ]}
            />

            <SubmitButton processing={processing} />
        </form>
    )
}
