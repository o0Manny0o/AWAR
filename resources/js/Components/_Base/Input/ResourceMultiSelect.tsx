import { InputError, InputLabel } from '@/Components/_Base/Input/index'
import AutocompleteInput, {
    Option,
} from '@/Components/_Base/Input/AutocompleteInput'
import { twMerge } from 'tailwind-merge'
import { TrashIcon } from '@heroicons/react/24/outline'
import { Button } from '@/Components/_Base/Button'
import { ReactNode } from 'react'

interface ResourceMultiSelectProps {
    name: string
    label: string
    placeholder?: string
    values?: Option[]
    options: Option[]
    onChange?: (values: Option[]) => void
    error?: string
    className?: string
    readOnly?: boolean
    maxLength?: number
    resourceThumbnail?: (option: Option) => string
    subtitle?: (option: Option) => ReactNode
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
    resourceThumbnail,
    subtitle,
    ...props
}: ResourceMultiSelectProps) {
    const removeResource = (index: number) => {
        onChange?.(values?.filter((_, i) => i !== index) ?? [])
    }

    const addResource = (value: Option) => {
        onChange?.(Array.from(new Set([...(values ?? []), value])))
    }

    return (
        <div>
            <InputLabel htmlFor={name} value={label} />

            <AutocompleteInput
                {...props}
                value={''}
                id={name}
                name={name}
                options={options.filter(
                    (a) => !values?.find((b) => a.id === b.id),
                )}
                maxLength={255}
                onChange={(value) => value && addResource(value)}
                className={twMerge('block w-full', className)}
                readOnly={readOnly}
                canCreate={false}
                clearOnSelect={true}
            />

            <InputError message={error} className="mt-2" />

            <ul
                role="list"
                className="my-4 grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3 sm:gap-6
                    2xl:grid-cols-4"
            >
                {values?.map((v, i) => (
                    <li
                        key={v.id}
                        className="col-span-1 flex rounded-md shadow-sm border-base border overflow-hidden"
                    >
                        <div
                            className="flex w-16 shrink-0 items-center justify-center rounded-l-md text-sm font-medium
                                text-white"
                        >
                            {resourceThumbnail && (
                                <img
                                    src={resourceThumbnail(
                                        options.find((o) => o.id === v.id)!,
                                    )}
                                    alt=""
                                />
                            )}
                        </div>
                        <div
                            className="flex flex-1 items-center justify-between truncate rounded-r-md border-b border-r
                                border-t border-base bg-ceiling-100"
                        >
                            <a
                                target="_blank"
                                href={route('animals.show', v)}
                                className="flex-1 truncate px-4 py-2 text-sm bg-interactive group"
                            >
                                <span className="font-medium text-interactive">
                                    {options.find((o) => o.id === v.id)?.name ??
                                        v.id}
                                </span>
                                <p className="text-basic">
                                    {subtitle?.(
                                        options.find((o) => o.id === v.id)!,
                                    )}
                                </p>
                            </a>
                            <div className="shrink-0 pr-2">
                                <Button
                                    color="secondary"
                                    rounded="full"
                                    onClick={() => removeResource(i)}
                                    type="button"
                                >
                                    <span className="sr-only">
                                        Remove Resource
                                    </span>
                                    <TrashIcon
                                        aria-hidden="true"
                                        className="size-5"
                                    />
                                </Button>
                            </div>
                        </div>
                    </li>
                ))}
            </ul>
        </div>
    )
}
