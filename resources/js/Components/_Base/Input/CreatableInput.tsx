import { twMerge } from 'tailwind-merge'
import {
    forwardRef,
    InputHTMLAttributes,
    ReactNode,
    useEffect,
    useImperativeHandle,
    useRef,
    useState,
} from 'react'
import {
    Combobox,
    ComboboxInput,
    ComboboxOption,
    ComboboxOptions,
} from '@headlessui/react'

export type Option = {
    id: string
    name: string
}

interface CreatableInputProps<T extends Option> {
    options: T[]
    onChange: (value: Option | null) => void
    value: T
    description?: (value: T) => ReactNode
}

export default forwardRef(function CreatableInput<T extends Option>(
    {
        className = '',
        options,
        onChange,
        value,
        name,
        description,
        ...props
    }: Omit<
        InputHTMLAttributes<HTMLInputElement>,
        'onChange' | 'value' | 'type'
    > &
        CreatableInputProps<T>,
    ref,
) {
    const localRef = useRef<HTMLInputElement>(null)

    useImperativeHandle(ref, () => ({
        focus: () => localRef.current?.focus(),
    }))

    const [selectedOption, setSelectedOption] = useState<Option | null>(
        value
            ? (options.find((option) => option.id === value.id) ?? value)
            : null,
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
                name={name}
                value={selectedOption}
                onChange={(option) => {
                    setSelectedOption(option ?? { name: query, id: query })
                }}
                onClose={() => setQuery('')}
            >
                <ComboboxInput
                    {...props}
                    displayValue={(option) => option?.name}
                    ref={localRef}
                    onChange={(event) => setQuery(event.target.value)}
                    onBlur={(event) => {
                        setSelectedOption(
                            options.find(
                                (option) =>
                                    option.name.toLowerCase() ===
                                    event.target.value.toLowerCase(),
                            ) ?? {
                                name: event.target.value,
                                id: event.target.value,
                            },
                        )
                    }}
                    className={twMerge(
                        `bg-ceiling text-basic block w-full rounded-md border-0 py-1.5 ring-1 ring-inset
                        ring-gray-300 placeholder:text-gray-400 read-only:ring-0 focus:ring-2
                        focus:ring-inset focus:ring-primary-500 read-only:focus:ring-0 sm:text-sm
                        sm:leading-6 dark:focus:ring-primary-600`,
                        className,
                    )}
                />
                <ComboboxOptions
                    anchor="bottom start"
                    transition
                    className="border empty:invisible w-[var(--input-width)] bg-ceiling mt-1 rounded-md py-1
                        shadow-lg ring-1 ring-black/5 transition focus:outline-none
                        data-[closed]:scale-95 data-[closed]:transform data-[closed]:opacity-0
                        data-[enter]:duration-200 data-[leave]:duration-75 data-[enter]:ease-out
                        data-[leave]:ease-in"
                >
                    {filteredOptions.map((option) => (
                        <ComboboxOption
                            key={option.id}
                            value={option}
                            className="text-interactive block w-full px-4 py-2 text-left text-sm
                                data-[focus]:bg-gray-100 data-[focus]:outline-none dark:data-[focus]:bg-gray-700"
                        >
                            {option.name} {description && description(option)}
                        </ComboboxOption>
                    ))}
                    {query.length > 0 && (
                        <ComboboxOption
                            value={{ id: query, name: query }}
                            className="text-interactive block w-full px-4 py-2 text-left text-sm
                                data-[focus]:bg-gray-100 data-[focus]:outline-none dark:data-[focus]:bg-gray-700"
                        >
                            Create <span className="font-bold">"{query}"</span>
                        </ComboboxOption>
                    )}
                </ComboboxOptions>
            </Combobox>
        </div>
    )
})
