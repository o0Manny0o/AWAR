import { InputError, InputLabel } from '@/Components/_Base/Input/index'
import AutocompleteInput, {
    Option,
} from '@/Components/_Base/Input/AutocompleteInput'
import { twMerge } from 'tailwind-merge'
import { TrashIcon } from '@heroicons/react/24/outline'

interface ResourceMultiSelectProps {
    name: string
    label: string
    placeholder?: string
    values?: string[]
    options: Option[]
    onChange?: (values: string[]) => void
    error?: string
    className?: string
    readOnly?: boolean
    maxLength?: number
}

export function ResourceMultiSelect({
    name,
    label,
    options,
    onChange,
    className,
    readOnly,
    error,
    values,
    maxLength,
    ...props
}: ResourceMultiSelectProps) {
    const removeResource = (index: number) => {
        onChange?.(values?.filter((_, i) => i !== index) ?? [])
    }

    const addResource = (value: Option) => {
        onChange?.(Array.from(new Set([...(values ?? []), value.id])))
    }

    return (
        <div>
            <InputLabel htmlFor={name} value={label} />

            <ul
                role="list"
                className="my-4 grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3 sm:gap-6
                    2xl:grid-cols-4"
            >
                {values?.map((v, i) => (
                    <li
                        key={v}
                        className="col-span-1 flex rounded-md shadow-sm border-base border"
                    >
                        <div
                            className="flex w-16 shrink-0 items-center justify-center rounded-l-md text-sm font-medium
                                text-white"
                        >
                            TODO: IMAGE
                        </div>
                        <div
                            className="flex flex-1 items-center justify-between truncate rounded-r-md border-b border-r
                                border-t border-gray-200 bg-white"
                        >
                            <div className="flex-1 truncate px-4 py-2 text-sm">
                                <a
                                    href="#"
                                    className="font-medium text-gray-900 hover:text-gray-600"
                                >
                                    {options.find((o) => o.id === v)?.name ?? v}
                                </a>
                                <p className="text-gray-500">TODO: FAMILY</p>
                            </div>
                            <div className="shrink-0 pr-2">
                                <button
                                    onClick={() => removeResource(i)}
                                    type="button"
                                    className="inline-flex size-8 items-center justify-center rounded-full bg-transparent
                                        bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2
                                        focus:ring-indigo-500 focus:ring-offset-2"
                                >
                                    <span className="sr-only">
                                        Remove Resource
                                    </span>
                                    <TrashIcon
                                        aria-hidden="true"
                                        className="size-5"
                                    />
                                </button>
                            </div>
                        </div>
                    </li>
                ))}
            </ul>

            <AutocompleteInput
                {...props}
                value={''}
                id={name}
                name={name}
                options={options.filter((a) => !values?.includes(a.id))}
                maxLength={255}
                onChange={(value) => value && addResource(value)}
                className={twMerge('block w-full', className)}
                readOnly={readOnly}
                canCreate={false}
                clearOnSelect={true}
            />

            <InputError message={error} className="mt-2" />
        </div>
    )
}
