import useTranslate from '@/shared/hooks/useTranslate'
import { useForm, usePage } from '@inertiajs/react'
import { FormEventHandler, ReactNode, useContext } from 'react'
import { ExperienceFormWrapper } from '@/Pages/SelfDisclosure/Wizard/Lib/Wizard.context'
import { Button } from '@/Components/_Base/Button'
import { ExperienceFormData } from '@/Pages/SelfDisclosure/Wizard/Lib/Wizard.types'

export function ExperienceForm({ experience }: { experience?: any }) {
    const __ = useTranslate()
    const { locale, today } = usePage<AppPageProps<{ today: string }>>().props

    const { data, errors, setData, patch, post, reset, processing, transform } =
        useForm<ExperienceFormData>({
            type: experience?.type ?? 'work',
            time: experience?.years ? 'years' : 'since',
            animal_type: experience?.animal_type ?? 'dog',
            years: experience?.years ?? 1,
            since: experience?.since ?? today,
        })

    const {
        focusError,
        refs: { since },
    } = useContext(ExperienceFormWrapper.Context)

    transform((data) => {
        const d = { ...data }
        if (d.time === 'since') {
            delete d.years
        } else {
            delete d.since
        }
        delete d.time
        return d
    })

    const submitHandler: FormEventHandler = (e) => {
        e.preventDefault()

        if (experience?.id) {
            patch(route('self-disclosure.experience.update', experience.id), {
                onSuccess: () => reset(),
                onError: (errors) => focusError(errors as any),
            })
        } else {
            post(route('self-disclosure.experience.store'), {
                onSuccess: () => reset(),
                onError: (errors) => focusError(errors as any),
            })
        }
    }

    const typeSelect: ReactNode = (
        <select
            className="bg-ceiling border-0 rounded text-basic pr-8"
            value={data.type}
            onChange={(e) => setData('type', e.target.value as any)}
        >
            <option value="work">
                {__('self_disclosure.wizard.forms.experience.work')}
            </option>
            <option value="pet">
                {__('self_disclosure.wizard.forms.experience.pet')}
            </option>
        </select>
    )

    const animalTypeSelect: ReactNode = (
        <select
            className="bg-ceiling border-0 rounded text-basic pr-8"
            value={data.animal_type}
            onChange={(e) => setData('animal_type', e.target.value as any)}
        >
            <option value="dog">
                {__('self_disclosure.wizard.forms.experience.dog')}
            </option>
            <option value="cat">
                {__('self_disclosure.wizard.forms.experience.cat')}
            </option>
            <option value="other">
                {__('self_disclosure.wizard.forms.experience.other')}
            </option>
        </select>
    )

    const experienceTimeSelect: ReactNode = (
        <>
            <select
                className="bg-ceiling border-0 rounded text-basic pr-8"
                value={data.time}
                onChange={(e) => setData('time', e.target.value as any)}
            >
                <option value="since">{__('general.various.since')}</option>
                <option value="years">{__('general.various.for')}</option>
            </select>
            {data.time === 'since' ? (
                <input
                    ref={since}
                    type="date"
                    className="bg-ceiling border-0 rounded text-basic"
                    value={data.since}
                    onChange={(e) => setData('since', e.target.value)}
                />
            ) : (
                <>
                    <select
                        className="bg-ceiling border-0 rounded text-basic pr-8"
                        value={data.years}
                        onChange={(e) => setData('years', +e.target.value)}
                    >
                        <option value="1">&lt; 5</option>
                        <option value="2"> 5 - 10</option>
                        <option value="3"> 10+</option>
                    </select>
                    <span>{__('general.various.years')}</span>
                </>
            )}
        </>
    )

    const sentences = new Map<string, ReactNode[]>([
        [
            'en',
            [
                <span>I</span>,
                typeSelect,
                <span>with</span>,
                animalTypeSelect,
                experienceTimeSelect,
            ],
        ],
        [
            'de',
            [
                <span>Ich habe</span>,
                experienceTimeSelect,
                <span>mit</span>,
                animalTypeSelect,
                typeSelect,
            ],
        ],
    ])

    const sentence: ReactNode[] =
        sentences.get(locale) ?? (sentences.get('en') as ReactNode[])

    return (
        <form className="w-full space-y-6" onSubmit={submitHandler}>
            <p className="flex gap-2 flex-wrap items-baseline">{...sentence}</p>

            <Button className="w-full" disabled={processing}>
                {__(
                    experience?.id
                        ? 'general.button.update'
                        : 'general.button.save',
                    { resource: '' },
                )}
            </Button>
        </form>
    )
}
