import { InputError, InputLabel } from '@/Components/_Base/Input'
import { CheckIcon, PencilIcon } from '@heroicons/react/24/solid'
import AutocompleteInput, {
    Option,
} from '@/Components/_Base/Input/AutocompleteInput'
import { FormEventHandler, ReactNode, useState } from 'react'
import { useForm } from '@inertiajs/react'
import useTranslate from '@/shared/hooks/useTranslate'

interface AssignInputProps<T extends Option> {
    animal: App.Models.Animal
    options: T[]
    value?: T
    label: string | TranslationKey
    prepend?: ReactNode
    routeName: string
    canEdit: boolean
}

export function AssignInput<T extends Option>({
    animal,
    options,
    value,
    prepend,
    label,
    routeName,
    canEdit,
}: AssignInputProps<T>) {
    const __ = useTranslate()
    const [edit, setEdit] = useState(false)

    const { data, setData, post, reset, errors, processing } = useForm<{
        id: string
    }>({
        id: value?.id ?? '',
    })

    const submitHandler: FormEventHandler = (e) => {
        e.preventDefault()

        post(route(routeName, animal.id), {
            onSuccess: () => {
                setEdit(false)
                reset()
            },
        })
    }

    return (
        <div className="space-y-2">
            <InputLabel value={label} className="truncate" />
            {!edit && (
                <div className="flex justify-between py-1.5 items-center">
                    <p className="flex items-center gap-2 flex-1 min-w-0">
                        {value?.name ? (
                            <>
                                {prepend}
                                <span className="truncate">{value?.name}</span>
                            </>
                        ) : (
                            __('general.various.no_one')
                        )}
                    </p>
                    {canEdit && (
                        <button
                            onClick={() => setEdit(true)}
                            className="text-primary-interactive"
                        >
                            <PencilIcon className="size-4" />
                        </button>
                    )}
                </div>
            )}
            {edit && (
                <div>
                    <form onSubmit={submitHandler}>
                        <div className="flex items-center gap-2">
                            <AutocompleteInput
                                containerClassName="flex-1"
                                options={options}
                                value={data.id}
                                disabled={processing}
                                onChange={(e) => setData('id', e?.id ?? '')}
                            />
                            <button
                                type="submit"
                                className="text-primary-interactive disabled:opacity-25"
                                disabled={processing}
                            >
                                <CheckIcon className="size-5" />
                            </button>
                        </div>
                        {errors.id && (
                            <InputError
                                className={'mt-2'}
                                message={errors.id}
                            />
                        )}
                    </form>
                </div>
            )}
        </div>
    )
}
