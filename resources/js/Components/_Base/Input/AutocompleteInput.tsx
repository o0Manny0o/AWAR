import { twMerge } from 'tailwind-merge'
import { InputHTMLAttributes, ReactNode, useEffect, useState } from 'react'
import {
    Combobox,
    ComboboxButton,
    ComboboxInput,
    ComboboxOptions,
} from '@headlessui/react'
import { ChevronUpDownIcon } from '@heroicons/react/24/solid'
import { AutocompleteInputOption } from '@/Components/_Base/Input/AutocompleteInputOption'

export type Option = {
    id: string
    name: string
}

interface CreatableInputProps<T extends Option> {
    options: T[]
    onChange: (value: T | null) => void
    value?: string | null
    description?: (value: T) => ReactNode
    canCreate?: boolean
    withEmptyOption?: string
    optionsClassName?: string
}

export default function AutocompleteInput<T extends Option>({
    className = '',
    options,
    onChange,
    value,
    name,
    description,
    canCreate,
    withEmptyOption,
    optionsClassName,
    ...props
}: Omit<InputHTMLAttributes<HTMLInputElement>, 'onChange' | 'value' | 'type'> &
    CreatableInputProps<T>) {
    const findOptionById = (id?: string | null) => {
        return (
            options.find((option) => option.id === id || (!id && !option.id)) ??
            (withEmptyOption
                ? ({
                      id: '',
                      name: withEmptyOption,
                  } as T)
                : null)
        )
    }

    const [selectedOption, setSelectedOption] = useState<T | null>(
        findOptionById(value),
    )

    useEffect(() => {
        // Value changed externally
        if (value !== selectedOption?.id) {
            setSelectedOption(findOptionById(value))
        }
    }, [value])

    const [query, setQuery] = useState('')

    const optionExists = (q: string) => {
        return !!options.find(
            (option) => option.name.toLowerCase() === q.toLowerCase(),
        )
    }

    useEffect(() => {
        onChange(selectedOption)
    }, [selectedOption])

    const filteredOptions =
        query === ''
            ? options
            : options.filter((option) => {
                  return option.name.toLowerCase().includes(query.toLowerCase())
              })

    return (
        <div className="mt-2">
            <Combobox
                immediate
                name={name}
                value={selectedOption}
                onChange={(option) => {
                    setSelectedOption(
                        option ??
                            (query ? ({ name: query, id: query } as T) : null),
                    )
                }}
            >
                <div className="relative">
                    <ComboboxInput
                        {...props}
                        displayValue={(option) =>
                            (option as unknown as T | null)?.name ?? ''
                        }
                        onChange={(event) => setQuery(event.target.value)}
                        onBlur={(event) => {
                            if (canCreate) {
                                // If the option doesn't exist, create it
                                setSelectedOption(
                                    options.find(
                                        (option) =>
                                            option.name.toLowerCase() ===
                                            event.target.value.toLowerCase(),
                                    ) ??
                                        ({
                                            name: event.target.value,
                                            id: event.target.value,
                                        } as T),
                                )
                            }
                        }}
                        className={twMerge(
                            `bg-ceiling text-basic block w-full rounded-md border-0 py-1.5 pl-3 pr-12 ring-1
                            ring-inset ring-gray-300 placeholder:text-gray-400 read-only:ring-0 focus:ring-2
                            focus:ring-inset focus:ring-primary-500 read-only:focus:ring-0 sm:text-sm
                            sm:leading-6 dark:focus:ring-primary-600`,
                            className,
                        )}
                    />
                    <ComboboxButton
                        className="absolute inset-y-0 right-0 flex items-center rounded-r-md px-2
                            focus:outline-none"
                    >
                        <ChevronUpDownIcon
                            className="size-5 text-gray-400"
                            aria-hidden="true"
                        />
                    </ComboboxButton>

                    <ComboboxOptions
                        anchor="bottom start"
                        transition
                        className={twMerge(
                            `border empty:invisible w-[var(--input-width)] bg-ceiling mt-1 rounded-md py-1
                            shadow-lg ring-1 ring-black/5 transition focus:outline-none cursor-pointer
                            data-[closed]:transform data-[closed]:opacity-0 data-[enter]:duration-200
                            data-[leave]:duration-75 data-[enter]:ease-out data-[leave]:ease-in`,
                            optionsClassName,
                        )}
                    >
                        {withEmptyOption && (
                            <AutocompleteInputOption
                                option={{ id: '', name: withEmptyOption } as T}
                                body={
                                    <div className="flex">
                                        <span className="truncate group-data-[selected]:font-semibold">
                                            {withEmptyOption}
                                        </span>
                                    </div>
                                }
                            />
                        )}
                        {filteredOptions.map((option) => (
                            <AutocompleteInputOption
                                key={option.id}
                                option={option}
                                body={
                                    <div className="flex">
                                        <span className="truncate group-data-[selected]:font-semibold">
                                            {option.name}
                                        </span>
                                        {description && (
                                            <span className="ml-2 truncate text-gray-500 group-data-[focus]:text-indigo-200">
                                                {description(option)}
                                            </span>
                                        )}
                                    </div>
                                }
                            />
                        ))}
                        {canCreate &&
                            query.length > 0 &&
                            !optionExists(query) && (
                                <AutocompleteInputOption
                                    option={{ id: query, name: query }}
                                    body={
                                        <div className="flex">
                                            <span className="truncate group-data-[selected]:font-semibold">
                                                Create{' '}
                                                <span className="font-bold">
                                                    "{query}"
                                                </span>
                                            </span>
                                        </div>
                                    }
                                />
                            )}
                    </ComboboxOptions>
                </div>
            </Combobox>
        </div>
    )
}
