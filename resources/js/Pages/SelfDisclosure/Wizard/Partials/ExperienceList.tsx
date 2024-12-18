import useTranslate from '@/shared/hooks/useTranslate'
import { Link, useForm, usePage } from '@inertiajs/react'
import { FormEventHandler, useContext } from 'react'
import { WizardFormWrapper } from '@/Pages/SelfDisclosure/Wizard/Lib/Wizard.context'
import { Button } from '@/Components/_Base/Button'
import { PlusCircleIcon, TrashIcon } from '@heroicons/react/24/outline'
import { PencilIcon } from '@heroicons/react/24/solid'

interface PersonalFormProps {
    data?: {
        has_animals: boolean
        experiences: any[]
    }
}

export function ExperienceList(props: PersonalFormProps) {
    const __ = useTranslate()
    const { locale } = usePage().props

    const { data, errors, setData, post, reset, processing } = useForm<{}>({})

    const {
        focusError,
        refs: {},
    } = useContext(WizardFormWrapper.Context)

    const submitHandler: FormEventHandler = (e) => {
        e.preventDefault()

        post(route('self-disclosure.personal.update'), {
            onSuccess: () => reset(),
            onError: (errors) => focusError(errors as any),
        })
    }

    return (
        <div className="w-full gap-8 flex flex-col mb-8">
            <div className="space-y-4 flex flex-col h-full flex-1 min-h-0">
                <ol className="space-y-4 flex-1 pt-2 overflow-y-auto">
                    {props.data?.has_animals && (
                        <li key="primary">
                            <p className="py-2.5 px-3.5 bg-ceiling rounded-md shadow">
                                {__(
                                    'self_disclosure.wizard.forms.experience.has_animals',
                                )}
                            </p>
                        </li>
                    )}

                    {props.data?.experiences
                        .filter((m) => !m.is_primary)
                        .map((m) => (
                            <li key={m.id}>
                                <p className="flex justify-between items-center px-3.5 bg-ceiling rounded-md shadow h-11">
                                    <span>
                                        {__(
                                            'self_disclosure.wizard.forms.experience.as_string',
                                            {
                                                type:
                                                    'self_disclosure.wizard.forms.experience.' +
                                                    m.type,
                                                animal_type:
                                                    'self_disclosure.wizard.forms.experience.' +
                                                    m.animal_type,
                                                time: m.years
                                                    ? `${__('general.various.for')} ${m.years === 1 ? '< 5' : m.years === 2 ? '5 - 10' : '10+'} ${__('general.various.years')}`
                                                    : `${__('general.various.since')} ${new Date(m.since).toLocaleDateString(locale)}`,
                                            },
                                        )}
                                    </span>
                                    <div className="flex gap-4 items-center">
                                        <div className="flex gap-1">
                                            <Link
                                                className="text-interactive p-2"
                                                href={route(
                                                    'self-disclosure.experience.edit',
                                                    m.id,
                                                )}
                                            >
                                                <PencilIcon className="size-5" />
                                                <span className="sr-only">
                                                    {__('general.button.edit', {
                                                        resource:
                                                            'general.resources.experience',
                                                    })}
                                                </span>
                                            </Link>
                                            <Link
                                                method="delete"
                                                as="button"
                                                className="text-interactive p-2"
                                                href={route(
                                                    'self-disclosure.experience.destroy',
                                                    m.id,
                                                )}
                                            >
                                                <TrashIcon className="size-5" />
                                                <span className="sr-only">
                                                    {__(
                                                        'general.button.delete',
                                                        {
                                                            resource:
                                                                'general.resources.experience',
                                                        },
                                                    )}
                                                </span>
                                            </Link>
                                        </div>
                                    </div>
                                </p>
                            </li>
                        ))}
                </ol>

                {!props.data?.experiences ||
                    (props.data.experiences.length < 5 && (
                        <Button
                            href={route('self-disclosure.experience.create')}
                            type="button"
                            color="secondary"
                            size="lg"
                            className="w-full gap-2"
                        >
                            <PlusCircleIcon className="size-5" />
                            <span>
                                {__('general.button.add', {
                                    resource: 'general.resources.experience',
                                })}
                            </span>
                        </Button>
                    ))}
            </div>

            <Button
                className="w-full"
                href={route('self-disclosure.eligibility.show')}
            >
                {__('general.button.continue')}
            </Button>
        </div>
    )
}
