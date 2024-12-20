import useTranslate from '@/shared/hooks/useTranslate'
import { useForm } from '@inertiajs/react'
import { FormEventHandler, useContext } from 'react'
import { WizardFormWrapper } from '@/Pages/SelfDisclosure/Wizard/Lib/Wizard.context'
import { Button } from '@/Components/_Base/Button'
import SwitchInput from '@/Components/_Base/Input/SwitchInput'
import AutocompleteGroup from '@/Components/_Base/Input/AutocompleteGroup'
import {
    AnimalSpecificFormData,
    CatSpecificData,
    DogSpecificData,
} from '@/Pages/SelfDisclosure/Wizard/Lib/Wizard.types'
import InputGroup from '@/Components/_Base/Input/InputGroup'

interface PersonalFormProps {
    data?: {
        catSpecific?: CatSpecificData
        dogSpecific?: DogSpecificData
    }
}

export function AnimalSpecificForm(props: PersonalFormProps) {
    const __ = useTranslate()

    const { data, errors, setData, patch, reset, processing, transform } =
        useForm<AnimalSpecificFormData>({
            cats: !!props.data?.catSpecific,
            cat_flap_available:
                props.data?.catSpecific?.cat_flap_available ?? false,
            cat_habitat: props.data?.catSpecific?.habitat ?? 'indoor',
            cat_house_secure: props.data?.catSpecific?.house_secure ?? false,
            cat_sleeping_place: props.data?.catSpecific?.sleeping_place ?? '',
            cat_streets_safe: props.data?.catSpecific?.streets_safe ?? false,

            dogs: !!props.data?.dogSpecific,
            dog_habitat: props.data?.dogSpecific?.habitat ?? 'home',
            dog_school: props.data?.dogSpecific?.dog_school ?? false,
            dog_time_to_occupy:
                props.data?.dogSpecific?.time_to_occupy ?? false,
            dog_purpose: props.data?.dogSpecific?.purpose ?? 'pet',
        })

    const {
        focusError,
        refs: { cat_habitat, cat_sleeping_place, dog_habitat, dog_purpose },
    } = useContext(WizardFormWrapper.Context)

    const submitHandler: FormEventHandler = (e) => {
        e.preventDefault()

        patch(route('self-disclosure.specific.update'), {
            onSuccess: () => reset(),
            onError: (errors) => focusError(errors as any),
        })
    }

    transform((data) => {
        const d = { ...data }
        if (!d.dogs) {
            delete d.dog_habitat
            delete d.dog_school
            delete d.dog_time_to_occupy
            delete d.dog_purpose
        }
        if (!d.cats) {
            delete d.cat_flap_available
            delete d.cat_habitat
            delete d.cat_house_secure
            delete d.cat_sleeping_place
            delete d.cat_streets_safe
        }
        return d
    })

    return (
        <form
            className="w-full divide-y divide-gray-200"
            onSubmit={submitHandler}
        >
            <div className="space-y-6 pb-6">
                <SwitchInput
                    name="dogs"
                    checked={data.dogs}
                    onChange={(v) => setData('dogs', v)}
                    label={__(
                        'self_disclosure.wizard.forms.specific.dogs.select.label',
                    )}
                />

                {data.dogs && (
                    <div className="space-y-6 px-4">
                        <AutocompleteGroup
                            name={'dog_habitat'}
                            label={__(
                                'self_disclosure.wizard.forms.specific.dogs.habitat.label',
                            )}
                            value={data.dog_habitat}
                            onChange={(v) =>
                                setData(
                                    'dog_habitat',
                                    (v?.id as any) ?? undefined,
                                )
                            }
                            error={errors.dog_habitat}
                            ref={dog_habitat}
                            options={[
                                {
                                    id: 'home',
                                    name: __(
                                        'self_disclosure.wizard.forms.specific.dogs.habitat.options.home',
                                    ),
                                },
                                {
                                    id: 'garden',
                                    name: __(
                                        'self_disclosure.wizard.forms.specific.dogs.habitat.options.garden',
                                    ),
                                },
                                {
                                    id: 'other',
                                    name: __(
                                        'self_disclosure.wizard.forms.specific.dogs.habitat.options.other',
                                    ),
                                },
                            ]}
                        />
                        <AutocompleteGroup
                            name={'dog_purpose'}
                            label={__(
                                'self_disclosure.wizard.forms.specific.dogs.purpose.label',
                            )}
                            value={data.dog_purpose}
                            onChange={(v) =>
                                setData(
                                    'dog_purpose',
                                    (v?.id as any) ?? undefined,
                                )
                            }
                            error={errors.dog_purpose}
                            ref={dog_purpose}
                            options={[
                                {
                                    id: 'pet',
                                    name: __(
                                        'self_disclosure.wizard.forms.specific.dogs.purpose.options.pet',
                                    ),
                                },
                                {
                                    id: 'work',
                                    name: __(
                                        'self_disclosure.wizard.forms.specific.dogs.purpose.options.work',
                                    ),
                                },
                                {
                                    id: 'other',
                                    name: __(
                                        'self_disclosure.wizard.forms.specific.dogs.purpose.options.other',
                                    ),
                                },
                            ]}
                        />

                        <SwitchInput
                            name="dog_school"
                            checked={data.dog_school}
                            onChange={(v) => setData('dog_school', v)}
                            label={__(
                                'self_disclosure.wizard.forms.specific.dogs.dog_school.label',
                            )}
                        />

                        <SwitchInput
                            name="dog_time_to_occupy"
                            checked={data.dog_time_to_occupy}
                            onChange={(v) => setData('dog_time_to_occupy', v)}
                            label={__(
                                'self_disclosure.wizard.forms.specific.dogs.time_to_occupy.label',
                            )}
                        />
                    </div>
                )}
            </div>

            <div className="space-y-6 pt-6">
                <SwitchInput
                    name="cats"
                    checked={data.cats}
                    onChange={(v) => setData('cats', v)}
                    label={__(
                        'self_disclosure.wizard.forms.specific.cats.select.label',
                    )}
                />

                {data.cats && (
                    <div className="space-y-6 px-4">
                        <AutocompleteGroup
                            name={'cat_habitat'}
                            label={__(
                                'self_disclosure.wizard.forms.specific.cats.habitat.label',
                            )}
                            value={data.cat_habitat}
                            onChange={(v) =>
                                setData(
                                    'cat_habitat',
                                    (v?.id as any) ?? undefined,
                                )
                            }
                            error={errors.cat_habitat}
                            ref={cat_habitat}
                            options={[
                                {
                                    id: 'indoor',
                                    name: __(
                                        'self_disclosure.wizard.forms.specific.cats.habitat.options.indoor',
                                    ),
                                },
                                {
                                    id: 'outdoor',
                                    name: __(
                                        'self_disclosure.wizard.forms.specific.cats.habitat.options.outdoor',
                                    ),
                                },
                                {
                                    id: 'both',
                                    name: __(
                                        'self_disclosure.wizard.forms.specific.cats.habitat.options.both',
                                    ),
                                },
                            ]}
                        />

                        {(data.cat_habitat === 'indoor' ||
                            data.cat_habitat === 'both') && (
                            <>
                                <SwitchInput
                                    name="cat_house_secure"
                                    checked={data.cat_house_secure}
                                    onChange={(v) =>
                                        setData('cat_house_secure', v)
                                    }
                                    label={__(
                                        'self_disclosure.wizard.forms.specific.cats.house_secure.label',
                                    )}
                                />
                            </>
                        )}

                        {(data.cat_habitat === 'outdoor' ||
                            data.cat_habitat === 'both') && (
                            <>
                                <InputGroup
                                    name="cat_sleeping_place"
                                    label={__(
                                        'self_disclosure.wizard.forms.specific.cats.sleeping_place.label',
                                    )}
                                    placeholder={__(
                                        'self_disclosure.wizard.forms.specific.cats.sleeping_place.placeholder',
                                    )}
                                    value={data.cat_sleeping_place ?? ''}
                                    ref={cat_sleeping_place}
                                    onChange={(v) =>
                                        setData('cat_sleeping_place', v)
                                    }
                                    error={errors.cat_sleeping_place}
                                />

                                <SwitchInput
                                    name="cat_streets_safe"
                                    checked={data.cat_streets_safe}
                                    onChange={(v) =>
                                        setData('cat_streets_safe', v)
                                    }
                                    label={__(
                                        'self_disclosure.wizard.forms.specific.cats.streets_safe.label',
                                    )}
                                />

                                <SwitchInput
                                    name="cat_flap_available"
                                    checked={data.cat_flap_available}
                                    onChange={(v) =>
                                        setData('cat_flap_available', v)
                                    }
                                    label={__(
                                        'self_disclosure.wizard.forms.specific.cats.flap_available.label',
                                    )}
                                />
                            </>
                        )}
                    </div>
                )}
            </div>

            <Button className="w-full mt-6" disabled={processing}>
                {__('general.button.continue')}
            </Button>
        </form>
    )
}
