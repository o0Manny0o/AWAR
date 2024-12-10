import { twMerge } from 'tailwind-merge'
import { InputHTMLAttributes, ReactNode, useEffect, useState } from 'react'
import {
    Combobox,
    ComboboxButton,
    ComboboxInput,
    ComboboxOption,
    ComboboxOptions,
} from '@headlessui/react'
import { CheckIcon, ChevronUpDownIcon } from '@heroicons/react/24/solid'

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
}

export default function AutocompleteInput<T extends Option>({
    className = '',
    options,
    onChange,
    value,
    name,
    description,
    canCreate,
    ...props
}: Omit<InputHTMLAttributes<HTMLInputElement>, 'onChange' | 'value' | 'type'> &
    CreatableInputProps<T>) {
    const [selectedOption, setSelectedOption] = useState<T | null>(
        value ? (options.find((option) => option.id === value) ?? null) : null,
    )

    const [query, setQuery] = useState('')

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
                        className="border empty:invisible w-[var(--input-width)] bg-ceiling mt-1 rounded-md py-1
                            shadow-lg ring-1 ring-black/5 transition focus:outline-none cursor-pointer
                            data-[closed]:scale-95 data-[closed]:transform data-[closed]:opacity-0
                            data-[enter]:duration-200 data-[leave]:duration-75 data-[enter]:ease-out
                            data-[leave]:ease-in"
                    >
                        {filteredOptions.map((option) => (
                            <ComboboxOption
                                key={option.id}
                                value={option}
                                className="group relative text-basic block w-full pl-4 pr-9 py-2 text-left text-sm
                                    data-[focus]:bg-primary-600 data-[focus]:outline-none data-[focus]:text-white
                                    dark:data-[focus]:bg-primary-400/50"
                            >
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

                                <span
                                    className="absolute inset-y-0 right-0 hidden items-center pr-4 text-primary-600
                                        dark:text-primary-400 group-data-[selected]:flex group-data-[focus]:text-white"
                                >
                                    <CheckIcon
                                        className="size-5"
                                        aria-hidden="true"
                                    />
                                </span>
                            </ComboboxOption>
                        ))}
                        {canCreate && query.length > 0 && (
                            <ComboboxOption
                                value={{ id: query, name: query }}
                                className="relative group text-basic block w-full pl-4 pr-9 py-2 text-left text-sm
                                    data-[focus]:bg-primary-600 data-[focus]:outline-none data-[focus]:text-white
                                    dark:data-[focus]:bg-primary-400/50"
                            >
                                <div className="flex">
                                    <span className="truncate group-data-[selected]:font-semibold">
                                        Create{' '}
                                        <span className="font-bold">
                                            "{query}"
                                        </span>
                                    </span>
                                </div>

                                {selectedOption?.id === query && (
                                    <span
                                        className="absolute flex inset-y-0 right-0 items-center pr-4 text-primary-600
                                            dark:text-primary-400 group-data-[focus]:text-white"
                                    >
                                        <CheckIcon
                                            className="size-5"
                                            aria-hidden="true"
                                        />
                                    </span>
                                )}
                            </ComboboxOption>
                        )}
                    </ComboboxOptions>
                </div>
            </Combobox>
        </div>
    )
}
